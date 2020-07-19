<?php
$login = array_key_exists('login', $_POST) ? $_POST['login'] : '';
$password = array_key_exists('password', $_POST) ? $_POST['password'] : '';
if (!$login) {
  echo json_encode(array(
    'error' => 'Empty login field',
    'target' => 'login',
  ));
  die;
}
if (!$password) {
  echo json_encode(array(
    'error' => 'Empty password field',
    'target' => 'password',
  ));
  die;
}

echo json_encode(User::login($_POST['login'], $_POST['password']));
die;
