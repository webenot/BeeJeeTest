<div id="login" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/ajax.php" method="post" class="needs-validation loginForm" novalidate>
          <div class="form-group">
            <label for="emailLogin">Email address or login</label>
            <input type="text" name="login" class="form-control" id="emailLogin" placeholder="Email or login" required>
          </div>
          <div class="form-group">
            <label for="passwordLogin">Password</label>
            <input type="password" name="password" class="form-control" id="passwordLogin" placeholder="********" required>
          </div>
          <input type="hidden" name="checkSecurity" value="">
          <input type="hidden" name="referer" value="<?php echo makeRequestFullUrl(); ?>">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button id="loginSubmit" type="submit" class="btn btn-primary" tabindex="1">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
