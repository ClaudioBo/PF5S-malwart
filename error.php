<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "Error";
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
    <div class="shadow card" style="border-top: 10px solid #ff0000">
      <div class="card-body">
        <h4 class="card-title text-center">404</h4>
        <hr>
        <div class="alert alert-danger text-center" role="alert">
          <strong>Pagina no encontrada</strong>
        </div>
        <div class="text-center">
          <a class="btn btn-danger" href="index.php" role="button">Regresar</a>
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