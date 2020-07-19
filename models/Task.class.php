<?php

class Task extends Model {

  public static $tableName = 'tasks';
  protected static $fieldsString =
    "`ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT(20) UNSIGNED NOT NULL,
    `content` TEXT NOT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'in progress',
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

  public static function init () {
    parent::createTable(self::$tableName, self::$fieldsString);
  }

  public static function getAll($page = 1, $limit = 3, $orderBy = 'modified', $order = 'DESC') {
    $tableName = self::$tableName;
    $offset = ($page - 1) * $limit;
    $usersTableName = User::$tableName;

    switch ($orderBy) {
      case 'name':
      case 'email':
        $orderBy = "`{$usersTableName}`.`{$orderBy}`";
        break;
      default:
        $orderBy = "`{$tableName}`.`{$orderBy}`";
    }

    $query = "SELECT `{$tableName}`.*, `{$usersTableName}`.`name`, `{$usersTableName}`.`email`
      FROM `{$tableName}`
      LEFT JOIN `{$usersTableName}`
      ON `{$tableName}`.`user_id` = `{$usersTableName}`.`ID`
      ORDER BY {$orderBy} {$order} LIMIT {$offset},{$limit};";
    $q = DB::prepare($query);
    $q->execute();
    $tasksList = $q->fetchAll(PDO::FETCH_CLASS);
    $q->closeCursor();
    return $tasksList;
  }

  public static function create($email, $name, $content) {
    $user = User::createUser($email, $name);
    if ($user['status'] === 406) {
      $user = User::getUser($email);
    }
    if ($user['status'] === 400) {
      return $user;
    }
    $user = $user[ 'result' ][ 0 ];
    $content = sanitizeTextField($content);

    $tableName = self::$tableName;
    $query = "INSERT INTO `{$tableName}` SET 
      `user_id` = :userId,
      `content` = :content";

    $q = DB::prepare($query);
    $q->bindValue(':userId', $user->ID);
    $q->bindValue(':content', $content);

    $q->execute();
    $taskID = DB::lastInsertId();
    $q->closeCursor();
    $newTask = self::getTask($taskID);
    if ($newTask['status'] === 200) {
      return array(
        'message' => 'Task created successfully',
        'status' => 200,
        'result' => $newTask['result'][0],
      );
    }
    return array(
      'error' => 'Unknown error',
      'status' => 400,
    );
  }

  public static function update($id, $content = '', $status = '') {
    if (!User::isAuth()) {
      return array(
        'error' => 'You must be logged in to edit task',
        'status' => 403
      );
    }

    if (!$content && !$status) {
      return array(
        'message' => 'Nothing to update',
        'status' => 204,
      );
    }
    $id = (int) $id;
    $data = array();
    if ($content && $status !== 'closed') {
      $data['content'] = sanitizeTextField($content);
      $data['status'] = 'moderated';
    }
    if ($status) {
      $data['status'] = sanitizeTextField($status);
    }
    if (empty($data)) {
      return array(
        'message' => 'Nothing to update',
        'status' => 204,
      );
    }
    DB::update(self::$tableName, $id, $data);
    return array(
      'message' => 'Task updated successfully',
      'status' => 200,
      'result' => self::getTask($id)['result'][0],
    );
  }

  public static function getTask($id) {
    $tableName = self::$tableName;
    $usersTableName = User::$tableName;
    $query = "SELECT `{$tableName}`.*, `{$usersTableName}`.`name`, `{$usersTableName}`.`email`
      FROM `{$tableName}`
      LEFT JOIN `{$usersTableName}`
      ON `{$tableName}`.`user_id` = `{$usersTableName}`.`ID`
      WHERE `{$tableName}`.`ID` = :taskId;";
    $q = DB::prepare($query);
    $q->bindValue(':taskId', $id);
    $q->execute();
    $task = $q->fetchAll(PDO::FETCH_CLASS);

    $q->closeCursor();
    if ($task) {
      return array(
        'message' => 'Found',
        'status' => 200,
        'result' => $task,
      );
    }
    return array(
      'message' => 'Not found',
      'status' => 404,
    );
  }

  public static function getTasksCount() {
    return parent::getCount(self::$tableName);
  }
}
