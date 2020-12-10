<?php
$error = [];

include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();

if (isset($_POST['send-edit'])) {
    foreach ($_POST as $taco => $salsa) {
        if ($salsa == '' && $taco != "send-edit"){
            $error[] = "la caja $taco es requerida";
        }
    }

    if (count($error) == 0) {
        if ($_POST['pass'] != $_POST['pass2']) {
            $error[] = "la contraseña no coincide";
        }
    }

    if (count($error) == 0) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $pass = $_POST['pass'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        if (editUsuario($nombre, $apellido, $pass, $direccion, $telefono)) {
            header('Location: index.php');
        } else {
            $error[] = "hubo un problema con la query";
        }
    }
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
                <form method="POST">
                    <label><i class="fa "></i>Nombre</label>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $sesionUsuario->nombre; ?>">
                    <br>
                    <label><i class="fa"></i>Apellido</label>
                    <input name="apellido" type="text" class="form-control" placeholder="Apellido" value="<?php echo $sesionUsuario->apellido; ?>">
                    <br>
                    <label><i class="fa"></i>Nueva contraseña</label>
                    <input name="pass" type="password" class="form-control" placeholder="*******" value="<?php echo $sesionUsuario->contraseña; ?>">
                    <br>
                    <label><i class="fa "></i>Repetir nueva contraseña</label>
                    <input name="pass2" type="password" class="form-control" placeholder="*******" value="<?php echo $sesionUsuario->contraseña; ?>">
                    <br>
                    <label><i class="fa "></i>Direccion</label>
                    <input name="direccion" type="text" class="form-control" placeholder="Direccion" value="<?php echo $sesionUsuario->direccion; ?>">
                    <br>
                    <label><i class="fa "></i>Telefono</label>
                    <input name="telefono" type="text" class="form-control" placeholder="Telefono" value="<?php echo $sesionUsuario->telefono; ?>">
                    <br>
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