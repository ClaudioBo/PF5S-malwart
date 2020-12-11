<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$errores = [];
if (isset($_GET['id'])) {
  if (is_numeric($_GET['id'])) {
    $sesionUsuario = cargarUsuarioSesion();
    $producto = cargarProducto(trim($_GET['id']), true);

    $reviewEnviada = null;
    if (isset($_POST['send-review'])) {
      $calificacion = $_POST['calificacion'];
      $comentario = trim($_POST['comentario']);
      if(!empty($comentario)){
        enviarReseña($_SESSION['id_user'], trim($_GET['id']), $calificacion, $comentario);
      } else {
        $errores[] = "No escribiste un comentario";
      }

    }

    $reviews = cargarReviews(trim($_GET['id']));
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
$selectedPage = $producto->nombre;
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
              <p>
                <strong>⭐⭐⭐⭐⭐</strong>
              </p>

              <form action="carrito.php" method="post">
                <input name="producto_id" type="number" value="<?php echo ($producto->id) ?>" hidden/>
                <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <input type="number" name="producto_cantidad" class="form-control form-control-sm" value="1" min="1" max="<?php echo ($producto->existencia) ?>">
                  </div>
                </div>
                <br/>
                <?php
                if ($sesionUsuario != null) {
                ?>
                  <button name="send-carrito" type="submit" class="btn btn-primary btn-lg">Añadir al carrito</button>
                <?php
                } else {
                ?>
                  <a class="btn btn-danger disabled" role="button">Debes iniciar sesion primero</a>
                <?php
                }
                ?>
              </form>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="container-fluid">´
          <?php
          imprimirErrores($errores);
          if (count($reviews) != 0) {
            foreach ($reviews as $rev) {
          ?>
              <div class="row">
                <div class="col-auto mr-auto">
                  <img src="https://i.imgur.com/zRjpTrl.png" width=64>
                  <p class="text-center"><?php echo $rev->usuario_nombre ?></p>
                </div>
                <div class="col-sm">
                  <strong>comento:</strong>
                  <p><?php echo $rev->comentario ?></p>
                  <p>
                    <?php
                    $i = 0;
                    for ($j = 0; $j < 5; $j++) {
                      if ($i >= $rev->calificacion) {
                        echo ("☆");
                      } else {
                        echo ("★");
                        $i += 1;
                      }
                    }
                    ?>
                  </p>
                </div>
              </div>
              <hr>
            <?php
            }
          } else {
            ?>
            <div class="row">
              <div class="col-sm">
                <div class="alert alert-secondary text-center" role="alert">
                  Aun nadie ha dejado una reseña, se el primero en dejar una
                </div>
              </div>
            </div>
          <?php
          }

          ?>

          <div class="row">
            <div class="col-sm">
              <form method="post">
                <label><i class="fa fa-envelope"></i> Dejar una reseña</label>
                <?php
                if ($sesionUsuario != null) {
                ?>
                  <div class="input-group mb-3">
                    <input name="comentario" type="text" class="form-control" placeholder="Escribe aqui tu reseña" maxlength="256" />
                    <select name="calificacion">
                      <option value="5">5 estrellas</option>
                      <option value="4">4 estrellas</option>
                      <option value="3">3 estrellas</option>
                      <option value="2">2 estrellas</option>
                      <option value="1">1 estrellas</option>
                    </select>
                    <button name="send-review" type="submit" class="btn btn-info">Enviar reseña</button>
                  </div>
                <?php
                } else {
                ?>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control text-center" disabled placeholder="Debes iniciar sesion primero">
                    <button class="btn btn-secondary" disabled>5 estrellas</button>
                    <button class="btn btn-secondary" disabled>Enviar reseña</button>
                  </div>
                <?php
                }
                ?>
              </form>
              <sub>Maximo 256 caracteres</sub>
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