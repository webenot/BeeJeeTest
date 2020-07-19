<?php
if (!User::isAuth()) {
  echo json_encode(array(
    'error' => 'You must be logged in to edit task',
  ));
  die;
}

$id = array_key_exists('id', $_POST) ? (int) $_POST['id'] : '';
$content = array_key_exists('content', $_POST) ? $_POST['content'] : '';
$status = array_key_exists('status', $_POST) ? $_POST['status'] : '';

if (!$id) {
  echo json_encode(array(
    'error' => 'Unknown task',
  ));
  die;
}
if (!$content && !$status) {
  echo json_encode(array(
    'error' => 'Nothing to update',
    'target' => 'content',
  ));
  die;
}

$result = Task::update($id, $content, $status);
if ($result['status'] === 200) {
  echo json_encode(array(
    'message' => $result['message'],
    'task' => $result['result'],
  ));
  die;
}
if ($result['status'] === 204) {
  echo json_encode($result);
  die;
}
echo json_encode(array(
  'error' => 'Unknown error',
));
die;
