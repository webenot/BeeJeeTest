<?php

class DB {

  public static $connection = null;

  public static $charset = CHARSET;
  public static $collate = DB_COLLATE;

  private static $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8 ',
    PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    PDO::ATTR_PERSISTENT => false,
    PDO::ERRMODE_EXCEPTION => true
  );

  private static function getConnection () {
    if (DB::$connection) {
      return DB::$connection;
    }

    $driver = 'mysql';
    $user = DB_USER;
    $password = DB_PASS;
    $host = DB_HOST;
    $database = DB_NAME;
    $charset = self::$charset;
    $collate = self::$collate;
    $options = self::$options;

    $dsn = "${driver}:host={$host};dbname={$database}";

    DB::$connection = null;

    try {
      DB::$connection = new PDO ($dsn, $user, $password, $options);
    } catch (PDOException $e) {
      if ($e->getCode() == 1049) {
        $sql = "CREATE DATABASE `{$database}` CHARACTER SET = '{$charset}' COLLATE = '{$collate}'";
        DB::$connection = new PDO("mysql:host={$host}", $user, $password, $options);
        $result = DB::$connection->query($sql);
        if ($result->errorCode() !== '00000') {
          echo 'Невозможно создать базу данных, код ошибки ' . $result->errorCode();
          exit();
        }
        try {
          DB::$connection = new PDO ($dsn, $user, $password, $options);
        } catch (PDOException $e) {
          echo 'Невозможно подключиться к базе данных, код ошибки ' . $e->getCode();
          exit();
        }
      }
    }

    DB::createTable(User::$tableName, User::$fieldsString);
    $user = User::getUser(ADMIN_EMAIL);
    if ($user[ 'status' ] !== 200) {
      User::createUser(ADMIN_EMAIL, ADMIN_USERNAME, ADMIN_PASS, ADMIN_USERNAME, 'admin');
    }

    return DB::$connection;
  }

  public static function __callStatic ( $name, $args ) {
    $callback = array( self::getConnection(), $name );
    return call_user_func_array($callback, $args);
  }

  public static function prepare ( $query ) {
    if (!self::$connection) self::getConnection();
    return self::$connection->prepare($query, self::$options);
  }

  public static function lastInsertId ( $q = null ) {
    if (!self::$connection) self::getConnection();
    return self::$connection->lastInsertId($q);
  }

  public static function createTable ( $tableName, $fieldsString ) {
    $charset = self::$charset;
    $collate = self::$collate;
    $q = self::prepare("SHOW TABLES LIKE '{$tableName}';");
    $q->execute();
    $result = $q->fetchAll();
    if (!$result) {
      $charset_collate = "DEFAULT CHARACTER SET '{$charset}' COLLATE '{$collate}'";
      $query = "CREATE TABLE IF NOT EXISTS  `{$tableName}` ({$fieldsString}) {$charset_collate};";
      $q = self::prepare($query);
      $q->execute();
      $q = self::prepare("SHOW TABLES LIKE '{$tableName}';");
      $q->execute();
      $result = $q->execute();
      $q->closeCursor();
    }
    $q->closeCursor();
    return $result;
  }

  public static function update ( $tableName, $id, $data ) {
    if (!is_array($data) && !is_array($data)) return false;

    $fields = array();
    foreach ($data as $key => $value) {
      $fields[] = "`{$key}` = :{$key}Value";
    }

    $fields = implode(', ', $fields);

    $query = "UPDATE `{$tableName}` SET {$fields} WHERE `ID` = {$id};";

    $q = DB::prepare($query);
    foreach ($data as $k => $v) {
      $q->bindValue(":{$k}Value", $v);
    }
    $q->execute();
    $list = $q->fetch();
    $q->closeCursor();
    return $list;
  }
}
