<!DOCTYPE html>
<html lang="ru">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta charset="utf-8">
  <meta name="theme-color" content="#ccc">
  <link rel="shortcut icon" href="/assets/icons/icon32x32.png" type="image/png">
  <link rel="apple-touch-icon" href="/assets/icons/icon32x32.png" type="image/png">
  <link rel="icon" href="/assets/icons/icon32x32.png" type="image/png">
  <title>Tasks List</title>
  <link href="/assets/dist/css/index.css" rel="stylesheet">
  <script type="application/javascript">
    window.limit = <?php echo array_key_exists('limit', $_GET) ? (int) $_GET['limit'] : 3; ?>;
    window.page = <?php echo array_key_exists('page', $_GET) ? (int) $_GET['page'] : 1; ?>;
  </script>
</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light align-items-center">
    <div class="container">
      <div class="row">
        <div class="navbar-brand logo col-3">
          <a href="/" class="row align-items-center no-gutters">
          <span class="col-3">
            <img class="img-fluid" src="/assets/icons/icon640x640.png" alt="Checked" decoding="async">
          </span>
            <span class="title col-9">Tasks List</span>
          </a>
        </div>
        <div class="col main-menu-wrapper">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link auth-link" href="#" data-toggle="modal" data-target="#login"><?php echo User::isAuth() ? 'Logout' : 'Login'; ?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>
