<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
if (!isset($_GET['folio']) || !is_numeric($_GET['folio'])) {
  header('Location: error.php');
}
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
    <div class="shadow card" style="border-top: 10px solid #218838">
      <div class="card-body">
        <h4 class="card-title text-center">Gracias!</h4>
        <hr>
        <div class="alert alert-sucess text-center" role="alert">
          <p>Tu compra ha sido confirmada, porfavor pase a pagar y recoger sus cosas en nuestro local.</p>
          <p>Folio: <?php echo($_GET['folio']) ?></p>
        </div>
        <div class="text-center">
          <a class="btn btn-success" href="index.php" role="button">Regresar</a>
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