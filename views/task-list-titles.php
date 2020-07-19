<thead>
<tr>
  <th scope="col">
    <a href="<?php $params['orderBy'] = 'name'; $params['order'] = $order === 'ASC' && $orderBy === 'name' ? 'DESC' : 'ASC'; echo $baseUrl . '?' . makeParamsString($params); ?>">
      <span class="sort-title">Name</span>
      <span class="sort-order"><?php echo $order === 'ASC' && $orderBy === 'name' ? '▲' : '▼'; ?></span>
    </a>
  </th>
  <th scope="col">
    <a href="<?php $params['orderBy'] = 'email'; $params['order'] = $order === 'ASC' && $orderBy === 'email' ? 'DESC' : 'ASC'; echo $baseUrl . '?' . makeParamsString($params); ?>">
      <span class="sort-title">Email</span>
      <span class="sort-order"><?php echo $order === 'ASC' && $orderBy === 'email' ? '▲' : '▼'; ?></span>
    </a>
  </th>
  <th scope="col">Task</th>
  <th scope="col">
    <a href="<?php $params['orderBy'] = 'status'; $params['order'] = $order === 'ASC' && $orderBy === 'status' ? 'DESC' : 'ASC'; echo $baseUrl . '?' . makeParamsString($params); ?>">
      <span class="sort-title">Status</span>
      <span class="sort-order"><?php echo $order === 'ASC' && $orderBy === 'status' ? '▲' : '▼'; ?></span>
    </a>
  </th>
</tr>
</thead>
