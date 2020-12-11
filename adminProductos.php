<?php
$error =[];
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();

if (isset($_POST['send-edit'])) {
    foreach ($_POST as $taco => $salsa) {
        if ($salsa == '' && $taco != "send-edit"){
            $error[] = "la caja $taco es requerida";
        }
    }
    if (isset($_SESSION)) {
        session_start();
        if (isset($_SESSION['id_user'])) {
            // header('Location: pane.php');
        }
    }

    if(count($error) ==0){
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $existencia = $_POST['existencia'];
        $departamento = $_POST['departamento'];
        $descripcion = $_POST['descripcion'];
        if(cargarProductos($nombre,$precio,$existencia,$departamento,$descripcion)){
            header('Location: administrarProductos.php');
        } else{
            $error[] = "hubo un problema con la query";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "administrarProductos";
include "head.html"
?>

<body>
    <!-- Navigation -->
    <?php
    include "navbar.php";
    ?>

    <!-- Page Content -->
    <div class="card">
        </br></br>
        <div class="card-doby" >
            <div class="card-body">
                <h1 class="card-title text-center">Administrar Productos</h1>
                <hr>
                <?php
                if (count($error) != 0) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Porfavor, lea los siguientes errores:</strong>
                        <ul>
                            <?php
                            foreach ($error as $mensaje) {
                            ?>
                                <li><?php echo $mensaje ?></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                <?php
                }
                ?>
                <div class="container home">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Existencia</th>
                                <th>departamento</th>
                                <th>descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td><?php echo $sesionUsuario->nombre;?></td>
                            <td>I</td>
                            <td>T</td>
                            <td>O</td>
                            <td>M</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    include "footer.html"
    ?>

</body>

</html>