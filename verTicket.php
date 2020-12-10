<?php

include_once "connections/conn.php";
include_once "connections/funciones.php";

if (isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        $ticket = cargarTicket(trim($_GET['id']));
    } else {
        header('Location: error.php');
    }
}else {
    header('Location: error.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<?php
$selectedPage = "Ver ticket";
include "head.html";
?>

<body>
    <?php
    include "navbar.php";
    ?>
    <h1>Ticket</h1>
    <p><b>Folio:</b> <?php echo $ticket->id ?></p>
    <p><b>Id del cliente:</b> <?php echo $ticket->id_cliente ?></p>
    <p><b>Fecha:</b> <?php echo $ticket->fecha ?></p>

    <table>
        <tr>
            <th>Id del producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio</th>
        </tr>
        <?php
        foreach ($ticket->ticket_productos as $tick_prod) {
            $url = "verProducto.php?id=".$tick_prod->producto->id;
        ?>
        <tr>
            <td><?php echo $tick_prod->producto->id?></td>
            <td><a href="<?php echo $url ?>"><?php echo $tick_prod->producto->nombre?></a></td>
            <td><?php echo $tick_prod->cantidad?></td>
            <td>$<?php echo ($tick_prod->producto->precio*$tick_prod->cantidad)?> MXN</td>
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