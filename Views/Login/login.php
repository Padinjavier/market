<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Abel OSH">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">


</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <!-- <h1><?= $data['page_title']; ?></h1> -->
    </div>
    <div class="login-box" style="border-radius: 20px;">
      <div id="divLoading">
        <div>
          <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
        </div>
      </div>
      <form class="login-form " name="formLogin" id="formLogin" action="">
        <div class="row justify-content-around align-items-center mb-4">
          <div class="text-start">
            <h4 class="m-7 text-primary">¡Bienvenido de nuevo!</h4>
            <p class="m-0">Logéate para acceder a la Agencia</p>
          </div>
          <img src="<?= media(); ?>/images/logologin.png" alt="">
        </div>
        <div class="form-group">
          <label class="control-label">Correo</label>
          <input id="txtEmail" name="txtEmail" class="form-control" type="email" placeholder="Ingresar correo"
            autofocus>
        </div>
        <div class="form-group">
          <label class="control-label">Contraseña</label>
          <div class="input-group">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password"
              placeholder="Ingresar contraseña">
            <div class="input-group-append " onclick="togglePasswordVisibility()"
              style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); z-index: 10000;">
              <span class="input-group-text bg-white border-0 bg-transparent" id="togglePassword">
                <i class="fas fa-eye-slash"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="utility">
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste tu contraseña?</a></p>
          </div>
        </div>
        <div id="alertLogin" class="text-center"></div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block rounded">Iniciar sesión</button>
        </div>
      </form>
      <form id="formRecetPass" name="formRecetPass" class="forget-form" action="">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste contraseña?</h3>
        <div class="form-group">
          <label class="control-label">EMAIL</label>
          <input id="txtEmailReset" name="txtEmailReset" class="form-control" type="email" placeholder="Email">
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block"><i
              class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar
              sesión</a></p>
        </div>
      </form>
    </div>
  </section>
  <script>
    const base_url = "<?= base_url(); ?>";
  </script>
  <!-- Essential javascripts for application to work-->
  <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
  <script src="<?= media(); ?>/js/popper.min.js"></script>
  <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
  <script src="<?= media(); ?>/js/fontawesome.js"></script>
  <script src="<?= media(); ?>/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
  <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
  <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
</body>

</html>