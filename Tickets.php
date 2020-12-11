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
$selectedPage = "Productos";
include "head.html"
?>

<body>
    <?php
    include "navbar.php";
    ?>
    <table>
        <tr>
            <th>Folio</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
        </tr>
        <?php
        foreach ($tickets as $tick) {
            $url = "verTicket.php?id=" . $tick->id
        ?>

            <tr>
                <td>
                    <a href="<?php echo $url ?>"><?php echo $tick->id ?></a>
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
            </tr>
        <?php
        }

        ?>
    </table>
    <?php
    include "footer.html"
    ?>
</body>

</html>