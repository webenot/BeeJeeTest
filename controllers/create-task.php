<?php
$email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
$name = array_key_exists('name', $_POST) ? $_POST['name'] : '';
$content = array_key_exists('content', $_POST) ? $_POST['content'] : '';
if (!$email) {
  echo json_encode(array(
    'error' => 'Empty email field',
    'target' => 'email',
  ));
  die;
}
if (!$name) {
  echo json_encode(array(
    'error' => 'Empty name field',
    'target' => 'name',
  ));
  die;
}
if (!$content) {
  echo json_encode(array(
    'error' => 'Empty content field',
    'target' => 'content',
  ));
  die;
}

$newTask = Task::create($email, $name, $content);
if ($newTask['status'] === 200) {
  echo json_encode(array(
    'message' => $newTask['message'],
    'task' => $newTask['result']
  ));
  die;
}
echo json_encode($newTask);
die;
