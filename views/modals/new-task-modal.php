<div id="newTask" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/ajax.php" method="post" class="needs-validation addNewTaskForm" novalidate>
          <div class="form-group">
            <label for="emailAddNewTask">Email address</label>
            <input type="email" class="form-control" name="email" id="emailAddNewTask" placeholder="email@examlpe.com" required>
          </div>
          <div class="form-group">
            <label for="nameAddNewTask">Name</label>
            <input type="text" class="form-control" name="name" id="nameAddNewTask" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <label for="textAddNewTask">Task</label>
            <textarea class="form-control" name="content" id="textAddNewTask" rows="3" placeholder="Your Task Content" required></textarea>
          </div>
          <input type="hidden" name="checkSecurity" value="">
          <input type="hidden" name="referer" value="<?php echo makeRequestFullUrl(); ?>">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button id="newTaskSubmit" type="submit" class="btn btn-primary" tabindex="1">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
