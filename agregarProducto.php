<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
$error = [];
if ($sesionUsuario != null) {
    if ($sesionUsuario->rol != 'Normal') {
        if (isset($_POST['send-admin-agregar'])) {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $existencia = $_POST['existencia'];
            $departamento = $_POST['departamento'];
            $descripcion = $_POST['descripcion'];
            if (
                $_POST['nombre'] == '' ||
                $_POST['precio'] == '' ||
                $_POST['existencia'] == '' ||
                $_POST['departamento'] == '' ||
                $_POST['descripcion'] == '' ||
                empty($_FILES['img']['name'])
            ) {
                $error[] = "Ingrese todos los campos y imagen";
            } else {
                $imagen = $_FILES['img'];
                if (agregarProducto($nombre, $precio, $existencia, $departamento, $descripcion, $imagen)) {
                    header('Location: adminProductos.php');
                } else {
                    $error[] = "No se pudo agregar el producto";
                }
            }
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
$selectedPage = "Agregar producto";
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
                <h4 class="card-title text-center">Agregar Producto</h4>
                <hr>
                <?php imprimirErrores($errores) ?>
                <form method="POST" enctype='multipart/form-data'>
                    <label><i class="fa"></i>Nombre</label>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre">
                    <br>
                    <label><i class="fa"></i>Precio</label>
                    <input name="precio" type="number" class="form-control" placeholder="15.00">
                    <br>
                    <label><i class="fa"></i>Existencia</label>
                    <input name="existencia" type="number" class="form-control" placeholder="10">
                    <br>

                    <label><i class="fa"></i>Departamento</label>
                    <div>
                        <select name="departamento">
                            <option value="Carniceria" selected>Carniceria</option>
                            <option value="Verduleria">Verduleria</option>
                            <option value="Pescaderia">Pescaderia</option>
                            <option value="Fruteria">Fruteria</option>
                            <option value="Lacteos">Lacteos</option>
                            <option value="Panaderia">Panaderia</option>
                            <option value="Farmacia">Farmacia</option>
                            <option value="Bebidas">Bebidas</option>
                        </select>
                    </div>

                    <br>
                    <label><i class="fa"></i>Descripcion</label>
                    <input name="descripcion" type="text" class="form-control" placeholder="Nombre">
                    <br>
                    <div>
                        <label><i class="fa"></i>Imagen</label><br>
                        <input name="img" type="file">
                    </div>
                    <br>
                    <button name="send-admin-agregar" type="submit" class="btn btn-primary btn-lg">Aceptar</button>
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