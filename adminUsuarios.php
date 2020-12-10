<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
$usuarios = [];
if ($sesionUsuario != null) {
    if ($sesionUsuario->rol == 'Administrador') {
        if (isset($_POST['borrar-usuario'])) {
            $usuario_id = $_POST['usuario_id'];
            borrarUsuario(trim($usuario_id));
        }
        $usuarios = cargarUsuarios();
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
$selectedPage = "Administrar usuarios";
include "head.html"
?>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Administrar Usuarios</h1>
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
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $usr) {
                            ?>
                                <tr id="<?php echo $usr->id; ?>">
                                    <td><?php echo $usr->id; ?></td>
                                    <td><?php echo $usr->nombre; ?></td>
                                    <td><?php echo $usr->apellido; ?></td>
                                    <td><?php echo str_repeat("*", 6); ?></td>
                                    <td><?php echo $usr->direccion; ?></td>
                                    <td><?php echo $usr->telefono; ?></td>
                                    <td>
                                        <form method="POST">
                                            <input name="usuario_id" hidden value="<?php echo ($usr->id) ?>" />
                                            <button name="borrar-usuario" type="submit" class="btn btn-danger">Borrar</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="editarUsuario.php" method="POST">
                                            <input name="usuario_id" hidden value="<?php echo ($usr->id) ?>" />
                                            <button name="send-admin-editar" type="submit" class="btn btn-primary">Editar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
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