<?php

include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();

$busqueda = null;
$pagina = 1;
if (isset($_GET['busqueda'])) {
  $busqueda = trim($_GET['busqueda']);
}
if (isset($_GET['pagina'])) {
  $pagina = trim($_GET['pagina']);
}

$productos = cargarProductos($busqueda, true, $pagina-1);
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "Inicio";
include "head.html"
?>

<body>
  <!-- Navigation -->
  <?php
  include "navbar.php";
  ?>

  <!-- Page Content -->
  <div class="container mt-5 mb-5">

    <div>
      <h1 class="display-4 text-center">Productos</h1>

      <form method="get" class="form-inline mb-2">
        <input class="form-control mr-sm-2" name="busqueda" type="search" placeholder="Buscar un producto">
        <input class="btn btn-outline-success my-2 my-sm-0" type="submit" />
      </form>

      <div class="row">

        <?php
        foreach ($productos as $prod) {
          $url = "verProducto.php?id=" . $prod->id
        ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="<?php echo $url ?>"><img class="card-img-top" src="
                  <?php echo 'data:image/jpeg;base64,' . base64_encode($prod->imagen) ?>
                  " alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="<?php echo $url ?>"><?php echo $prod->nombre ?></a>
                </h4>
                <h5>$<?php echo $prod->precio ?></h5>
                <p class="card-text"><?php echo $prod->descripcion ?></p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>
        <?php
        } ?>
      </div>

      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between border-0 px-0 pb-0">
          <a class="btn btn-primary btn-lg <?php if($pagina <= 1)echo("disabled") ?>" href="index.php?pagina=<?php if($pagina > 1)echo($pagina-1) ?>">Pagina anterior</a>
          <a class="btn btn-secondary btn-lg"><?php echo($pagina) ?></a>
          <a class="btn btn-primary btn-lg <?php if(count($productos) != 9)echo("disabled") ?>" href="index.php?pagina=<?php echo($pagina+1) ?>">Siguiente pagina</a>
        </li>
      </ul>
    </div>
  </div>

  </div>

  <!-- Footer -->
  <?php
  include "footer.html"
  ?>

</body>

</html>