<?php
$error = [];
if (isset($_SESSION)) {
    session_start();
    if (isset($_SESSION['id_user'])) {
        // header('Location: pane.php');
    }
}

include_once "connections/conn.php";
include_once "connections/funciones.php";
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php
$selectedPage = "usuarios";
include "head.html"
?>

<body>
    <!-- Navigation -->
    <?php

    include "navbar.php";
    ?>

    <!-- Page Content -->
    <div class="card">
        <div class="card-body">
            <h1 class="card-title text-center">Administrar Usuarios</h1>
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

                <table id="data_table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Contraseña</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once "connections/conn.php";

                        $sql_query = "SELECT `id`, `correo`, `contraseña`, `nombre`, `apellido`, `direccion`, `telefono`, `rol` FROM `usuarios`";
                        $resultset = mysqli_query($mysqli, $sql_query) or die("error base de datos:" . mysqli_error($conn));
                        while ($usuario = mysqli_fetch_assoc($resultset)) {
                        ?>
                            <tr id="<?php echo $usuario['id']; ?>">
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['nombre']; ?></td>
                                <td><?php echo $usuario['apellido']; ?></td>
                                <td><?php echo $usuario['contraseña']; ?></td>
                                <td><?php echo $usuario['direccion']; ?></td>
                                <td><?php echo $usuario['telefono']; ?></td>
                                <td> <a class="btn btn-primary" role="button" onclick="delete()">Eliminar</a></td>
                                <td><a class="btn btn-primary" href="#" role="button">Editar</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <hr>
        </div>
    </div>

    <?php
    include_once "connections/conn.php";


    function delete($id_user)
    {
        global $mysqli;
        $id_user = $_GET['id'];
        $sql_query = "DELETE from 'usuarios' WHERE 'id' = $id_user ";
        $resultset = mysqli_query($mysqli, $sql_query) or die("error base de datos:" . mysqli_error($mysqli));
    }
    ?>

    <!-- Footer -->
    <?php
    include "footer.html"
    ?>

</body>

</html>