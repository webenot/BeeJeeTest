<tr>
  <td class="taskUserName"><?php echo $task->name; ?></td>
  <td class="taskUserEmail"><?php echo $task->email; ?></td>
  <td class="taskContent">
    <div class="field-wrapper">
      <span class="task-content"><?php echo $task->content; ?></span>
      <?php if (User::isAuth() && User::isAdmin()) : ?>
        <button type="button" class="btn btn-info editTask" <?php echo $task->status === 'closed' ? 'disabled' : ''; ?>>Edit</button>
      <?php endif; ?>
    </div>
    <?php if (User::isAuth() && User::isAdmin()) : ?>
      <form action="/ajax.php" method="post" class="needs-validation editTaskForm hidden" novalidate>
        <div class="form-group">
          <label for="textAddNewTask-<?php echo $task->ID; ?>"></label>
          <textarea class="form-control" name="content" id="textAddNewTask-<?php echo $task->ID; ?>" rows="3" placeholder="Your Task Content" required><?php echo $task->content; ?></textarea>
        </div>
        <input type="hidden" name="checkSecurity" value="">
        <input type="hidden" name="id" value="<?php echo $task->ID; ?>">
        <input type="hidden" name="referer" value="<?php echo makeRequestFullUrl(); ?>">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cancelTaskEditing">Cancel</button>
          <button id="newTaskSubmit-<?php echo $task->ID; ?>" type="submit" class="btn btn-primary" tabindex="1">Update</button>
        </div>
      </form>
    <?php endif; ?>
  </td>
  <td class="taskStatus">
    <div class="field-wrapper">
      <?php
        $taskStatusClass = 'text-danger';
        if ($task->status === 'closed') {
          $taskStatusClass = 'text-success';
        } elseif ($task->status === 'moderated') {
          $taskStatusClass = 'text-warning';
        }
      ?>
      <span class="<?php echo $taskStatusClass; ?> task-status"><?php echo $task->status; ?></span>
      <?php if (User::isAuth() && User::isAdmin()) : ?>
        <div class="custom-control custom-switch">
          <input value="<?php echo $task->ID; ?>" type="checkbox" class="custom-control-input closeTask" id="closeTask-<?php echo $task->ID; ?>" <?php echo $task->status === 'closed' ? 'disabled' : ''; ?>>
          <label class="custom-control-label" for="closeTask-<?php echo $task->ID; ?>">Close task</label>
        </div>
      <?php endif; ?>
    </div>
  </td>
</tr>
