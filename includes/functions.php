<?php
function baseUrl() {
  return ($_SERVER['SERVER_PORT'] === '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
}

function makeRequestFullUrl() {
  return baseUrl() . $_SERVER['REQUEST_URI'];
}

function sanitizeTextField($field) {
  return addslashes(htmlspecialchars(strip_tags($field)));
}

function validateEmail ( $email ) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function simplifyString ( $str = '' ) {
  if ($str === '') return $str;
  return preg_replace(array( '/\W+/i' ), '_', strip_tags(mb_strtolower($str)));
}

function makePaginationArray($total = 1, $limit = 0, $current = 1, $pagesShowBeforeCurrent = 2) {
  $total = (int) $total;
  $limit = (int) $limit;
  $current = (int) $current;

  $pagination = array();
  if (!$limit) return $pagination;

  $pagination[] = 1;
  $pages = (int) ceil($total / $limit);

  $tmp = $pagesShowBeforeCurrent * 2 + 3;

  for ($i = 2; $i <= $pages; $i++) {
    if ($pages > $tmp) {
      if (($i < $current - $pagesShowBeforeCurrent || $i > $current + $pagesShowBeforeCurrent) && $i < $pages) {
        if ($pagination[count($pagination) - 1] !== '...') {
          $pagination[] = '...';
        }
      } else {
        $pagination[] = $i;
      }
    } else {
      $pagination[] = $i;
    }
  }

  return $pagination;
}

function makeParamsString($params) {
  if (is_string($params)) return $params;
  if (!is_array($params) && !is_object($params)) return '';

  $result = array();
  foreach ($params as $key => $value) {
    $result[] = "{$key}={$value}";
  }

  return implode('&', $result);
}
