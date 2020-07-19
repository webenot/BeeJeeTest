<?php

class Model {
  public static $tableName;
  protected static $fieldsString;
  protected static $tableExists = false;

  public static function createTable($tableName, $fieldsString) {
    return DB::createTable($tableName, $fieldsString);
  }

  public static function getByFieldName($tableName, $fieldName, $value) {
    $query = "SELECT * FROM `{$tableName}` WHERE `{$fieldName}` = :fieldValue ;";
    $q = DB::prepare($query);
    $q->bindParam(':fieldValue', $value);
    $q->execute();
    $item = $q->fetchAll(PDO::FETCH_CLASS);
    $q->closeCursor();
    if ($item) {
      return array(
        'message' => 'Found',
        'status' => 200,
        'result' => $item
      );
    }
    return array(
      'message' => 'Not found',
      'status' => 404,
    );
  }

  public static function getCount($tableName, $whereConditionString = '') {
    $query = "SELECT COUNT(*) FROM `{$tableName}` {$whereConditionString}";
    $q = DB::prepare($query);
    $q->execute();
    $result = $q->fetch();
    $q->closeCursor();

    return (int) $result[0];
  }
}
