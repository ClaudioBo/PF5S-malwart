<?php
session_start();
$error = [];
if (isset($_SESSION)) {
    if (isset($_SESSION['id_user'])) {
        // header('Location: pane.php');
    }
}

if (isset($_POST['send-login'])) {
    include_once "connections/conn.php";
    include_once "connections/funciones.php";

   

    // Validacion de contraseña
    if ((!isset($_POST['pass'])) || $_POST['pass'] == '') {
        $error[] = "No se ingreso la contraseña";
    }

    if (count($error) == 0) {
        $email = trim($_POST['correo']);
        $pass = trim($_POST['pass']);

        $id_o_error = cargarUsuario($email, $pass);

        if (!is_array($id_o_error)) {
            $_SESSION['id_user'] = $id_o_error;
            header('Location: productos.php');
        } else {
            $error = array_merge($error, $id_o_error);
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
                    <input name="nombre" type="" class="form-control" placeholder="Nombre">
                    <br>
                    <label><i class="fa"></i>Apellido</label>
                    <input name="apellido" type="" class="form-control" placeholder="Apellido">
                    <br>
                    <label><i class="fa"></i>Nueva Contraseña</label>
                    <input name="pass" type="password" class="form-control" placeholder="*******">
                    <br>
                    <label><i class="fa "></i>Nueva Contraseña</label>
                    <input name="pass" type="password" class="form-control" placeholder="*******">
                    <br>
                    <button name="send-login" type="submit" class="btn btn-primary btn-lg ml-auto d-block">Aceptar</button>
                </form>
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