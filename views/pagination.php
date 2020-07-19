<?php
$tasksCount = Task::getTasksCount();
$pages = makePaginationArray($tasksCount, $limit, $page, 1);
$prevPage = $page - 1;
$nextPage = $page + 1;
$lastPage = $pages[count($pages) - 1];
?>
<div class="container">
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <li class="page-item<?php echo $page > 1 ? '' : ' disabled'; ?>"><a class="page-link" href="<?php $params['page'] = 1; echo $baseUrl . '?' . makeParamsString($params); ?>"><<</a></li>
      <li class="page-item<?php echo $page > 1 ? '' : ' disabled'; ?>"><a class="page-link" href="<?php $params['page'] = $prevPage; echo $baseUrl . '?' . makeParamsString($params); ?>"><</a></li>
      <?php foreach ($pages as $p) : ?>
        <?php if ($p === $page) : ?>
          <li class="page-item active">
            <span class="page-link"><?php echo $p; ?></span >
          </li>
        <?php elseif ($p === '...') : ?>
          <li class="page-item">
            <span class="no-page"><?php echo $p; ?></span>
          </li>
        <?php else : ?>
          <li class="page-item">
            <a class="page-link" href="<?php $params['page'] = $p; echo $baseUrl . '?' . makeParamsString($params); ?>"><?php echo $p; ?></a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
      <li class="page-item<?php echo $page < $lastPage ? '' : ' disabled'; ?>"><a class="page-link" href="<?php $params['page'] = $nextPage; echo $baseUrl . '?' . makeParamsString($params); ?>">></a></li>
      <li class="page-item<?php echo $page < $pages[count($pages) - 1] ? '' : ' disabled'; ?>"><a class="page-link" href="<?php $params['page'] = $lastPage; echo $baseUrl . '?' . makeParamsString($params);; ?>">>></a></li>
    </ul>
  </nav>
</div>
