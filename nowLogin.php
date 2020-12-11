<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$sesionUsuario = null;
$selectedPage = "Registro";
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
        <h4 class="card-title text-center">Cuenta creada.</h4>
        <p>Tu cuenta ha sido creado, ahora inicia sesion presionando el siguiente boton</p>
        <hr>
        <div class="text-center">
          <a class="btn btn-primary" href="login.php" role="button">Iniciar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php
  include "footer.html"
  ?>

</body>

</html>