<?php
function autoloader($class) {
  if (class_exists($class)) return;
  if (file_exists(BASE_PATH . "/includes/{$class}.class.php")) {
    require_once BASE_PATH . "/includes/{$class}.class.php";
    return;
  }
  if (file_exists(__DIR__ . "/models/{$class}.class.php")) {
    require_once BASE_PATH . "/models/{$class}.class.php";
  }
}

spl_autoload_register('autoloader');
