<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Tienda Virtual Abel OSH">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Abel OSH">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
  <title>
    <?= $data['page_tag'] ?>
  </title>
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/js/datepicker/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
  <!-- link de icon boostrap  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- link de formato fecha   -->
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
</head>

<body class="app sidebar-mini">
  <div id="divLoading">
    <div>
      <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
    </div>
  </div>
  <header class="app-header justify-content-between w-100 shadow" style="height: 50px;">
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle text-dark" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"> <i
        class="fas fa-bars"></i> </a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <!-- User Menu-->
      <li class="dropdown">
        <a class="app-nav__item d-flex align-items-center justify-content-center p-0 m-0 " href="#"
          data-toggle="dropdown" aria-label="Open Profile Menu" style="width: 50px; height: 100%;">
          <img src="<?= media(); ?>/images/logologin.png" alt="" class="w-100 p-2">
        </a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="<?= base_url(); ?>/opciones"><i class="fa fa-cog fa-lg"></i> Settings</a>
          </li>
          <li><a class="dropdown-item" href="<?= base_url(); ?>/usuarios/perfil"><i class="fa fa-user fa-lg"></i>
              Profile</a></li>
          <li><a class="dropdown-item" href="<?= base_url(); ?>/logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
          </li>
        </ul>
      </li>
    </ul>
  </header>

  <?php require_once ("nav_admin.php"); ?>