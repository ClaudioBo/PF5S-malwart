<?php
$error = [];

$resQueryLoggedUserDetail = mysqli_query($connLocalhost, $queryLoggedUserDetail) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$LoggedUserDetail = mysqli_fetch_assoc($resQueryLoggedUserDetail);


if (isset($_SESSION)) {
    session_start();
    if (isset($_SESSION['id_user'])) {
        // header('Location: pane.php');
    }
}

if (isset($_POST['send-login'])) {
    include_once "connections/conn.php";
    include_once "connections/funciones.php";
}

if(isset($_POST['userUpdateSent'])){

    foreach($_POST as $taco => $salsa){
        if($salsa == '' && $taco != "telefono") $error[] = "la caja $salsa es requerida";
    }

    if($_POST['password'] != $_POST['password2']){
        $error[] = "la contraseña no coincide";
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
                <form action="editarUsuario.php" method="POST">
                    <label><i class="fa "></i>Nombre</label>
                    <input name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $LoggedUserDetail['nombre'];?>">
                    <br>
                    <label><i class="fa"></i>Apellido</label>
                    <input name="apellido" type="text" class="form-control" placeholder="Apellido" value="<?php echo $LoggedUserDetail['apellido'];?>">
                    <br>
                    <label><i class="fa"></i>Nueva Contraseña</label>
                    <input name="pass" type="password" class="form-control" placeholder="*******" value="<?php echo $LoggedUserDetail['contraseña'];?>">
                    <br>
                    <label><i class="fa "></i>Nueva Contraseña</label>
                    <input name="pass" type="password2" class="form-control" placeholder="*******">
                    <br>
                    <label><i class="fa "></i>Direccion</label>
                    <input name="direccion" type="text" class="form-control" placeholder="Direccion" value="<?php echo $LoggedUserDetail['direccion'];?>">
                    <br>
                    <label><i class="fa "></i>Telefono</label>
                    <input name="telefono" type="text" class="form-control" placeholder="Telefono" value="<?php echo $LoggedUserDetail['telefono'];?>">
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