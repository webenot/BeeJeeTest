<?php
session_start();
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';
User::init();
Task::init();

$id = 21;
/*$result = Task::update($id, 'test task 8');
var_dump($result);*/
/*$result = DB::update(Task::$tableName, $id, array('content' => 'test task 9', 'status' => 'moderated'));
var_dump($result);*/

include __DIR__ . '/views/header.php';
include __DIR__ . '/views/main.php';
include __DIR__ . '/views/footer.php';
include __DIR__ . '/views/modals/modals.php';
