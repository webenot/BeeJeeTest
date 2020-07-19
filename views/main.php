<?php
$page = array_key_exists('page', $_GET) ? (int) $_GET['page'] : 1;
$limit = array_key_exists('limit', $_GET) ? (int) $_GET['limit'] : 3;
$orderBy = array_key_exists('orderBy', $_GET) ? $_GET['orderBy'] : '';
$order = array_key_exists('order', $_GET) ? $_GET['order'] : '';
$params = array(
  'limit' => $limit,
);
if ($page) $params['page'] = $page;
if ($orderBy) $params['orderBy'] = $orderBy;
if ($order) $params['order'] = $order;
$baseUrl = baseUrl() . ($_SERVER['SCRIPT_NAME'] === '/index.php' ? '/' : $_SERVER['SCRIPT_NAME']);
?>
<main class="container">
  <div class="add-task-wrapper">
    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#newTask">+ New Task</a>
  </div>
  <table class="table">
    <?php include_once BASE_PATH . '/views/task-list-titles.php'; ?>
    <tbody class="tasks-list">
      <?php
        $tasksList = Task::getAll($page, $limit, $orderBy ? $orderBy : 'modified', $order ? $order : 'DESC');
        foreach ($tasksList as $task) :
          include BASE_PATH . '/views/task-item.php';
        endforeach;
      ?>
    </tbody>
  </table>
  <?php include_once BASE_PATH . '/views/pagination.php'; ?>
</main>
