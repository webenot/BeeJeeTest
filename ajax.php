<?php
session_start();
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

if (!array_key_exists('action', $_POST) && !array_key_exists('action', $_GET)) {
  echo json_encode(array(
    'error' => 'No action detected',
  ));
  die;
}
if (!array_key_exists('referer', $_POST) || !$_POST['referer']) {
  echo json_encode(array(
    'error' => 'Forbidden',
  ));
  die;
}
if ($_POST) {
  if (!array_key_exists('checkSecurity', $_POST) || $_POST['checkSecurity'] !== '') {
    echo json_encode(array(
      'error' => 'Bot detected',
    ));
    die;
  }
  include_once __DIR__ . '/controllers/' . $_POST['action'] . '.php';

  header("Location: {$_POST['referer']}");
  die;
}
if ($_GET) {
  if (!array_key_exists('checkSecurity', $_GET) || $_GET['checkSecurity'] !== '') {
    echo json_encode(array(
      'error' => 'Bot detected',
    ));
    die;
  }
  include_once __DIR__ . '/controllers/' . $_GET['action'] . '.php';
}
header('Location: ' . baseUrl());
die;
