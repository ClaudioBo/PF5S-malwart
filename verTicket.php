<?php

include_once "connections/conn.php";
include_once "clases/ticket.php";
include_once "clases/producto.php";
include_once "connections/funciones.php";

$sesionUsuario = cargarUsuarioSesion();
if ($sesionUsuario != null) {
    if ($sesionUsuario->rol != 'Normal') {
        if (isset($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                $ticket = cargarTicket(trim($_GET['id']));
            } else {
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
<?php
$selectedPage = "Ticket #" . $ticket->id;
include "head.html";
?>

<body>
    <?php
    include "navbar.php";
    ?>

    <div class="container">
        <div class="card">
            <div class="card-doby">
                <div class="card-body">
                    <div class="text-center">
                        <h3><span class="badge badge-secondary">Ticket #<?php echo $ticket->id ?></span></h3>
                        <h5><span class="badge badge-info">
                                Id. Cliente: <?php echo $ticket->id_cliente ?>
                                </br>
                                Fecha: <?php echo $ticket->fecha ?>
                            </span></h5>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cantida</th>
                                <th>Precio</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ticket->ticket_productos as $tick_prod) {
                                $url = "verProducto.php?id=" . $tick_prod->producto->id;
                            ?>
                                <tr>
                                    <td><?php echo $tick_prod->producto->id ?></td>
                                    <td><a href="<?php echo $url ?>"><?php echo $tick_prod->producto->nombre ?></a></td>
                                    <td><?php echo $tick_prod->cantidad ?></td>
                                    <td>$<?php echo ($tick_prod->producto->precio * $tick_prod->cantidad) ?> MXN</td>
                                    <td><a class="btn btn-primary" href="<?php echo $url ?>">Ver producto</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "footer.html"
    ?>
</body>

</html>