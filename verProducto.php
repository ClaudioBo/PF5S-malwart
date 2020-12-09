<?php
include_once "connections/conn.php";
include_once "clases/producto.php";
include_once "clases/usuario.php";
session_start();
if (isset($_GET['id'])) {
  if (is_numeric($_GET['id'])) {
    $prd = null;
    $query = sprintf(
      "SELECT * FROM productos WHERE id= '%s' LIMIT 1",
      mysqli_escape_string($mysqli, trim($_GET['id']))
    );
    if ($result = $mysqli->query($query)) {
      if ($result->num_rows != 0) {
        $res = mysqli_fetch_array($result);
        $prd = new Producto();
        $prd->id = $res['id'];
        $prd->nombre = $res['nombre'];
        $prd->precio = $res['precio'];
        $prd->existencia = $res['existencia'];
        $prd->departamento = $res['departamento'];
        $prd->descripcion = $res['descripcion'];
        $prd->imagen = $res['imagen'];
      } else {
        header('Location: error.php');
      }
      $result->free_result();
    }

    $sesionUsuario = null;
    if (isset($_SESSION)) {
      if (isset($_SESSION['id_user'])) {
        $query = sprintf(
          "SELECT * FROM usuario WHERE id= '%s' LIMIT 1",
          mysqli_escape_string($mysqli, trim($_SESSION['id_user']))
        );
        if ($result = $mysqli->query($query)) {
          if ($result->num_rows != 0) {
            $sesionUsuario = new Usuario();
            $res = mysqli_fetch_array($result);
            $sesionUsuario = new Usuario();
            $sesionUsuario->id = $res['id'];
            $sesionUsuario->correo = $res['correo'];
            $sesionUsuario->contraseña = $res['contraseña'];
            $sesionUsuario->nombre = $res['nombre'];
            $sesionUsuario->apellido = $res['apellido'];
            $sesionUsuario->direccion = $res['direccion'];
            $sesionUsuario->telefono = $res['telefono'];
            $sesionUsuario->rol = $res['rol'];
          } else {
            header('Location: error.php');
          }
          $result->free_result();
        }
      }
    }

    $mysqli->close();
  } else {
    header('Location: error.php');
  }
} else {
  header('Location: error.php');
}
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
        <strong><?php echo $prd->nombre ?></strong>
      </div>
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">

            <div class="col-sm">
              <img class="card-img-top" src="
              <?php echo 'data:image/jpeg;base64,' . base64_encode($prd->imagen) ?>
              " alt="Imagen del producto">
            </div>

            <div class="col-sm">
              <h1><?php echo $prd->nombre ?></h1>
              <h2 class="font-weight-light">$<?php echo $prd->precio ?> MXN</h2>
              <p class="font-weight-light"><?php echo $prd->descripcion ?></p>
              <?php
              if (!$sesionUsuario != null) {
              ?>
                <a class="btn btn-primary" href="#" role="button">Añadir al cesto <?php echo $sesionUsuario->correo ?></a>
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