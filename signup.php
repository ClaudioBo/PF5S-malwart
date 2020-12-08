<?php

$error = [];

if (isset($_SESSION['id_user'])) {
  header('Location: cpanel.php');
}

if (isset($_POST['send-login'])) {
  include_once "connections/conn.php";
  include_once "connections/funciones.php";

  // Validacion de correo
  if (isset($_POST['correo'])) {
    if ($_POST['correo'] == '') {
      $error[] = "No se ingreso correo";
    } else {
      if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        $error[] = "El e-mail no es valido";
      }
    }
  } else {
    $error[] = "No se ingreso correo";
  }

  // Validacion de contraseña
  if ((!isset($_POST['pass'])) || $_POST['pass'] == '') {
    $error[] = "No se ingreso la contraseña";
  }

  if(count($error) == 0){
    $email = trim($_POST['correo']);
    $pass = trim($_POST['pass']);

    $reg_errores = registrarUsuario($email,$pass);

    if(count($reg_errores) == 0){
      header('Location: nowLogin.php');
    } else {
      $error = array_merge($error,$reg_errores);
    }

  }
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "Usuario - Registro";
include "head.html"
?>

<body>
  <!-- Navigation -->
  <?php
  include "navbar.php";
  ?>

  <!-- Page Content -->
  <div class="container mt-5 mb-5 col-sm-11 col-md-8 col-lg-4 col-xl-4">
    </br></br>
    <div class="shadow card" style="border-top: 10px solid #138496">
      <div class="card-body">
        <h4 class="card-title text-center">Crear cuenta</h4>
        <hr>
        <?php
        if (count($error) != 0) {
        ?>
          <div class="alert alert-danger" role="alert">
            <strong>Porfavor, lea los siguientes errores:</strong>
            <ul>
              <?php
              foreach ($error as $mensaje) {
              ?>
                <li><?php echo $mensaje ?></li>
              <?php
              }
              ?>
            </ul>
          </div>
        <?php
        }
        ?>
        <form method="POST">
          <label><i class="fa fa-envelope"></i> Correo electronico</label>
          <input name="correo" type="email" class="form-control" placeholder="tucorreo@gmail.com">
          <br>
          <label><i class="fa fa-asterisk"></i> Contraseña</label>
          <input name="pass" type="password" class="form-control" placeholder="********">
          <br>
          <button name="send-login" type="submit" class="btn btn-info btn-lg ml-auto d-block">Crear cuenta</button>
        </form>
        <hr>
        <p>Ya tienes cuenta?</p>
        <a class="btn btn-primary" href="login.php" role="button">Iniciar sesión</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php
  include "footer.html"
  ?>

</body>

</html>