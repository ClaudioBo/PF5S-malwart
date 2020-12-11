<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";

$sesionUsuario = cargarUsuarioSesion();
if ($sesionUsuario != null) {
  if (isset($_POST['send-carrito'])) {
    $id_producto = $_POST['producto_id'];
    $cantidad = $_POST['producto_cantidad'];
    $exito = añadirProductoCarrito($sesionUsuario, $id_producto, $cantidad);
    if ($exito) {
      $sesionUsuario = cargarUsuarioSesion(); //recargar usuario porque hubo un cambio en el cesto
    }
  } elseif (isset($_POST['borrar-item'])) {
    $id_producto = $_POST['producto_id'];
    $exito = borrarProductoCarrito($sesionUsuario, $id_producto);
    if ($exito) {
      $sesionUsuario = cargarUsuarioSesion(); //recargar usuario porque hubo un cambio en el cesto
    }
  } elseif (isset($_POST['comprar'])) {
    $exito = comprar($sesionUsuario);
    if ($exito != -1) {
      header('Location: gracias.php?folio=' . $exito);
    } else {
      header('Location: error.php');
    }
  }
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
  <div class="container-fluid mt-5 mb-5 col-sm-11 col-md-8 col-lg-8 col-xl-8">
    <div class="row">
      <div class="col">

        <div class="card">
          <div class="card-header">
            <strong>Tu carrito</strong>
          </div>
          <?php
          if ($sesionUsuario != null) {
            if (count($sesionUsuario->carrito) != 0) {
              foreach ($sesionUsuario->carrito as $carrito_item) {
          ?>
                <div class="card-body">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-auto mr-auto">
                        <img src="
                        <?php echo 'data:image/jpeg;base64,' . base64_encode($carrito_item->producto->imagen) ?>
                        " width=192>
                      </div>
                      <div class="col-sm">
                        <p class="font-weight-bold"><?php echo ($carrito_item->producto->nombre) ?></p>
                        <p>
                          $<?php echo ($carrito_item->producto->precio) ?> MXN c/u
                          <br>
                          <?php echo ($carrito_item->cantidad) ?> piezas
                        </p>
                        <form method="POST">
                          <input name="producto_id" hidden value="<?php echo ($carrito_item->producto->id) ?>" />
                          <button name="borrar-item" type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
              <?php
              }
            } else {
              ?>
              <div class="alert alert-secondary" role="alert">
                No tienes items en tu carrito.
              </div>
            <?php
            }
          } else {
            ?>
            <div class="alert alert-danger" role="alert">
              Debes iniciar sesion primero
            </div>
          <?php
          }
          ?>
        </div>
      </div>

      <?php
      if ($sesionUsuario != null) {
        if (count($sesionUsuario->carrito) != 0) {
      ?>
          <div class="col col-sm-4">
            <div class="card">
              <div class="card-header">
                <strong>Total</strong>
              </div>
              <div class="card-body">
                <?php
                $total = 0;
                foreach ($sesionUsuario->carrito as $carrito_item) {
                  $total += $carrito_item->producto->precio * $carrito_item->cantidad;
                }
                ?>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between border-0 px-0 pb-0">
                    Carrito
                    <span>$<?php echo ($total) ?> MXN</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between px-0">
                    Recoger en tienda
                    <span>Gratis</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between border-0 px-0 mb-3">
                    <div>
                      <strong>Total</strong>
                    </div>
                    <span><strong>$<?php echo ($total) ?> MXN</strong></span>
                  </li>
                </ul>
              </div>
              <form method="POST">
                <button name="comprar" type="submit" class="btn btn-danger">Comprar</button>
              </form>
          <?php

        }
      }
          ?>

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