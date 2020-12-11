<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
if ($sesionUsuario != null) {
    if (isset($_GET['id'])) {
        $producto = cargarProducto(trim($_GET['id']), true);
        if ($producto != null) {
            if(isset($_POST['send-edit'])){
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $existencia = $_POST['existencia'];
                $departamento = $_POST['departamento'];
                $descripcion = $_POST['descripcion'];
                $imagen = $_POST['imagen'];
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
$selectedPage = "Cuentas - Ingreso";
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
                <h4 class="card-title text-center">Editar Perfil</h4>
                <hr>
                <form method="POST">
                    <label><i class="fa "></i>Nombre</label>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $usuarioEditar->nombre; ?>">
                    <!-- $nombre = $_POST['nombre'];
                    $precio = $_POST['precio'];
                    $existencia = $_POST['existencia'];
                    $departamento = $_POST['departamento'];
                    $descripcion = $_POST['descripcion'];
                    $imagen = $_POST['imagen']; -->
                    <br>
                    <input name="usuario_id" hidden value="<?php echo ($usuarioEditar->id) ?>" />
                    <button name="send-edit" type="submit" class="btn btn-primary btn-lg ml-auto d-block">Aceptar</button>
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