<?php

include_once "connections/conn.php";
include_once "clases/ticket.php";
include_once "connections/funciones.php";

$sesionUsuario = cargarUsuarioSesion();

$tickets = cargarTickets();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php
$selectedPage = "Tickets";
include "head.html"
?>

<body>
    <?php
    include "navbar.php";
    ?>

    <div class="container">
        <div class="card">
            <div class="card-doby">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tickets as $tick) {
                                $url = "verTicket.php?id=" . $tick->id
                            ?>
                                <tr>
                                    <td>
                                        <a><?php echo $tick->id ?></a>
                                    </td>
                                    <td>
                                        <?php echo $tick->cliente->nombre ?>
                                    </td>
                                    <td>
                                        <?php echo $tick->fecha ?>
                                    </td>
                                    <td>
                                        $<?php
                                            $total = 0;
                                            foreach ($tick->ticket_productos as $tick_prod) {
                                                $total += $tick_prod->producto->precio * $tick_prod->cantidad;
                                            }
                                            echo ($total);
                                            ?>
                                        MXN
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo($url) ?>">Ver ticket</a>
                                    </td>
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