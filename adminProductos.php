<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
$producto = [];

if ($sesionUsuario != null) {
    if ($sesionUsuario->rol == 'Administrador') {
        if (isset($_POST['borrar-producto'])) {
            $producto_id = $_POST['producto_id'];
            borrarProducto(trim($producto_id));
        }
        $producto = cargarProductos(null, false);
    } else {
        header('Location: error.php');
    }
} else {
    header('Location: error.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$selectedPage = "administrarProductos";
include "head.html"
?>

<body>
    <!-- Navigation -->
    <?php
    include "navbar.php";
    ?>

    <!-- Page Content -->´
    <div class="container">
        <div class="card">
            <div class="card-doby">
                <div class="card-body">
                    <h1 class="card-title text-center">Administrar Productos</h1>
                    <div class="container home">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Existencia</th>
                                    <th>departamento</th>
                                    <th>descripcion</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($producto as $pro) {
                                ?>
                                    <tr id="<?php echo $pro->id; ?>">
                                        <td><?php echo $pro->id; ?> </td>
                                        <td><?php echo $pro->nombre; ?></td>
                                        <td><?php echo $pro->precio; ?></td>
                                        <td><?php echo $pro->existencia; ?></td>
                                        <td><?php echo $pro->departamento; ?></td>
                                        <td><?php echo $pro->descripcion; ?></td>
                                        <td>
                                            <form method="POST">
                                                <input name="producto_id" hidden value="<?php echo ($pro->id) ?>">
                                                <button name="borrar-producto" type="submit" class="btn btn-danger">Borrar</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="editarProducto.php" method="GET">
                                                <input name="id" hidden value="<?php echo ($pro->id) ?>">
                                                <button type="submit" class="btn btn-primary">Editar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a href="agregarProducto.php" class="btn btn-success">Agregar producto</a>
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