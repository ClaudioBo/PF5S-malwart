<?php
include_once "clases/producto.php";
include_once "connections/conn.php";
include_once "connections/funciones.php";
if (isset($_GET['id'])) {
  if (is_numeric($_GET['id'])) {
    $sesionUsuario = loginUsuarioSesion();
    $producto = cargarProducto(trim($_GET['id']));
  } else {
    header('Location: error.php');
  }
} else {
  header('Location: error.php');
}
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "Productos";
include "head.html"
?>

<body>
  <!-- Navigation -->
  <?php
  include "navbar.php";
  ?>

  <!-- Page Content -->
  </br></br>
  <div class="container mt-5 mb-5">
    <div class="card">
      <div class="card-header">
        <strong><?php echo $producto->nombre ?></strong>
      </div>
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">

            <div class="col-sm">
              <img class="card-img-top" src="
              <?php echo 'data:image/jpeg;base64,' . base64_encode($producto->imagen) ?>
              " alt="Imagen del producto">
            </div>

            <div class="col-sm">
              <h1><?php echo $producto->nombre ?></h1>
              <h2 class="font-weight-light">$<?php echo $producto->precio ?> MXN</h2>
              <p class="font-weight-light"><?php echo $producto->descripcion ?></p>
              <?php
              if ($sesionUsuario != null) {
              ?>
                <a class="btn btn-primary" href="#" role="button">Añadir al cesto</a>
              <?php
              } else {
              ?>
                <a class="btn btn-danger disabled" href="#" role="button">Debes iniciar sesion primero</a>
              <?php
              }
              ?>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">

            <div class="col-auto mr-auto">
              <img src="https://via.placeholder.com/64" alt="">
              <p class="text-center">Usuario</p>
            </div>

            <div class="col-sm">
              <strong>comento:</strong>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In perferendis aliquam tenetur assumenda voluptate, enim natus vel quaerat! Placeat aliquid illo saepe tenetur dolorum voluptatum debitis nihil in sed rem.</p>
            </div>

          </div>
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