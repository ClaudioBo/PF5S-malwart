<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
$errores = [];
if ($sesionUsuario != null) {
    if ($sesionUsuario->rol != 'Normal') {
        if (isset($_POST['send-admin-editar'])) {
            $idproducto = $_POST['producto_id'];
            $producto = cargarProducto(trim($idproducto), false);
            if ($producto != null) {
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $existencia = $_POST['existencia'];
                $departamento = $_POST['departamento'];
                $descripcion = $_POST['descripcion'];
                $imagen = null;
                if (!empty($_FILES['img']['name'])) {
                    $imagen = $_FILES['img'];
                }
                if (
                    $_POST['nombre'] == '' ||
                    $_POST['precio'] == '' ||
                    $_POST['existencia'] == '' ||
                    $_POST['departamento'] == '' ||
                    $_POST['descripcion'] == ''
                ) {
                    $errores[] = "No debes dejar ningun campo vacio";
                }

                if (editarProducto($idproducto, $nombre, $precio, $existencia, $departamento, $descripcion, $imagen)) {
                    header('Location: adminProductos.php');
                } else {
                    $errores[] = "No se pudo editar el producto";
                }
            } else {
                header('Location: error.php');
            }
        } elseif (isset($_GET['id'])) {
            $producto = cargarProducto(trim($_GET['id']), true);
            if ($producto == null) {
                header('Location: error.php');
            }
        } else {
            header('Location: error.php');
        }
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
$selectedPage = "Editar producto";
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
        <div class="shadow card" style="border-top: 10px solid #007BFF">
            <div class="card-body">
                <h4 class="card-title text-center">Editar Producto</h4>
                <?php imprimirErrores($errores) ?>
                <hr>
                <form method="POST" enctype='multipart/form-data'>
                    <label><i class="fa"></i>Nombre</label>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $producto->nombre; ?>">
                    <br>
                    <label><i class="fa"></i>Precio</label>
                    <input name="precio" type="number" class="form-control" placeholder="0.00" value="<?php echo $producto->precio; ?>">
                    <br>
                    <label><i class="fa"></i>Existencia</label>
                    <input name="existencia" type="number" class="form-control" placeholder="10" value="<?php echo $producto->existencia; ?>">
                    <br>

                    <label><i class="fa"></i>Departamento</label>
                    <div>
                        <select name="departamento">
                            <option value="Carniceria" <?php if ($producto->departamento == 'Carniceria') echo ("selected") ?>>Carniceria</option>
                            <option value="Verduleria" <?php if ($producto->departamento == 'Verduleria') echo ("selected") ?>>Verduleria</option>
                            <option value="Pescaderia" <?php if ($producto->departamento == 'Pescaderia') echo ("selected") ?>>Pescaderia</option>
                            <option value="Fruteria" <?php if ($producto->departamento == 'Fruteria') echo ("selected") ?>>Fruteria</option>
                            <option value="Lacteos" <?php if ($producto->departamento == 'Lacteos') echo ("selected") ?>>Lacteos</option>
                            <option value="Panaderia" <?php if ($producto->departamento == 'Panaderia') echo ("selected") ?>>Panaderia</option>
                            <option value="Farmacia" <?php if ($producto->departamento == 'Farmacia') echo ("selected") ?>>Farmacia</option>
                            <option value="Bebidas" <?php if ($producto->departamento == 'Bebidas') echo ("selected") ?>>Bebidas</option>
                        </select>
                    </div>

                    <br>
                    <label><i class="fa"></i>Descripcion</label>
                    <input name="descripcion" type="text" class="form-control" placeholder="Nombre" value="<?php echo $producto->descripcion; ?>">
                    <br>
                    <div>
                        <label><i class="fa"></i>Imagen</label><br>
                        <input name="img" type="file">
                    </div>
                    <br>
                    <input name="producto_id" hidden value="<?php echo ($producto->id) ?>" />
                    <button name="send-admin-editar" type="submit" class="btn btn-primary btn-lg">Aceptar</button>
                    <a class="btn btn-danger btn-lg" href="adminProductos.php">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    include "footer.html"
    ?>

</body>

</html>