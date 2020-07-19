<?php

class User extends Model {

  public static $tableName = 'users';
  public static $fieldsString =
    "`ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `login` VARCHAR(255) NOT NULL,
    `password` VARCHAR(2048),
    `role` VARCHAR(255) NOT NULL DEFAULT 'guest',
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

  public static function init () {
    self::$tableExists = parent::createTable(self::$tableName, self::$fieldsString);
  }

  public static function isAuth () {
    return !!($_SESSION && array_key_exists('is_auth', $_SESSION) && $_SESSION[ 'is_auth' ]);
  }

  public static function isAdmin() {
    return array_key_exists('role', $_SESSION) && $_SESSION[ 'role' ] === 'admin';
  }

  public static function createUser ( $email, $name, $password = '', $loginName = '', $role = 'guest' ) {
    $tableName = self::$tableName;
    $user = self::getUser($email);
    if ($user[ 'status' ] === 200) {
      return array(
        'message' => 'User with this email already exists',
        'status' => 406,
      );
    }
    if (!validateEmail($email)) {
      return array(
        'message' => 'Email validation error',
        'status' => 400,
      );
    }

    $login = simplifyString($loginName);
    $login = self::makeLoginName($login, $login, $email);

    $name = sanitizeTextField($name);

    if ($password !== '')
      $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    else $passwordHash = '';

    $query = "INSERT INTO `{$tableName}` SET 
      `email` = :email,
      `password` = :password,
      `login` = :login,
      `name` = :username,
      `role` = :role";
    $q = DB::prepare($query);
    $q->bindValue(':email', $email);
    $q->bindValue(':password', $passwordHash);
    $q->bindValue(':login', $login);
    $q->bindValue(':username', $name);
    $q->bindValue(':role', $role);
    $q->execute();
    $q->closeCursor();

    return User::getUser($email);
  }

  public static function login ( $username, $password ) {
    $username = sanitizeTextField($username);
    if (preg_match('/@/', $username)) {
      $user = self::getUser($username);
    } else {
      $user = self::getUserByLogin($username);
    }
    if ($user[ 'status' ] === 200) {
      $user = $user[ 'result' ][ 0 ];
      if ($user->password === '') {
        return array(
          'error' => 'This user cannot be logged in',
          'target' => 'login',
        );
      }
      if (password_verify($password, $user->password)) {
        $_SESSION[ 'is_auth' ] = true;
        $_SESSION[ 'login' ] = $username;
        $_SESSION[ 'role' ] = $username;
        return array(
          'message' => 'You successfully logged in',
        );
      }
      return array(
        'error' => 'Password is incorrect',
        'target' => 'password',
      );
    }
    return array(
      'error' => 'Login is incorrect',
      'target' => 'login',
    );
  }

  public static function logout () {
    $_SESSION = array();
    return array(
      'message' => 'You successfully logged out',
    );
  }

  public static function getUser ( $email ) {
    return self::getByFieldName(self::$tableName, 'email', $email);
  }

  public static function getUserByLogin ( $login ) {
    return self::getByFieldName(self::$tableName, 'login', $login);
  }

  private static function makeLoginName ( $basicLogin, $login, $email, $iteration = 1 ) {
    if (!$login) $login = explode('@', $email)[ 0 ];

    $user = self::getUserByLogin($login);
    if ($user[ 'status' ] === 200) {
      $login = "{$basicLogin}_{$iteration}";
      self::makeLoginName($basicLogin, $login, $email, $iteration + 1);
    }

    return $login;
  }
}
