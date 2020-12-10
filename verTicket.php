<?php

include_once "connections/conn.php";
include_once "clases/ticket.php";
include_once "clases/producto.php";

if (isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        $tick = null;
        $query = sprintf(
            "SELECT * FROM tickets WHERE id= '%s' LIMIT 1",
            mysqli_escape_string($mysqli, trim($_GET['id']))
        );
        if ($result = $mysqli->query($query)) {
            if ($result->num_rows != 0) {
                $res = mysqli_fetch_array($result);
                $tick = new Ticket();
                $tick->id = $res['id'];
                $tick->id_cliente = $res['id_cliente'];
                $tick->fecha = $res['fecha'];
            } else {
                header('Location: error.php');
            }
            $result->free_result();
        }

        $id_productos = [];
        $query = sprintf(
            "SELECT * FROM tickets_productos WHERE id_ticket = '%s'",
            mysqli_escape_string($mysqli, trim($_GET['id']))
        );
        if ($result = $mysqli->query($query)) {
            while ($res = mysqli_fetch_array($result)) {
                $ticpro = new TicketProducto();
                $ticpro->id = $res['id'];
                $ticpro->id_ticket = $res['id_ticket'];
                $ticpro->id_producto = $res['id_producto'];
                $ticpro->cantidad = $res['cantidad'];
                array_push($id_productos, $ticpro);
            }
        }
        $nombre_productos = [];

        foreach ($id_productos as $ids) {
            $query = sprintf(
                "SELECT nombre FROM productos WHERE id = '%s'",
                mysqli_escape_string($mysqli, trim($ids['id_producto']))
            );
            if ($result = $mysqli->query(($query))) {
                $res = mysqli_fetch_array($result);
                array_push($nombre_productos, $res);
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<?php
include "head.html";
?>

<body>
    <?php
    include "navbar.php";
    ?>
    <h1>Ticket</h1>
    <p><b>Folio:</b> <?php echo $tick->id ?></p>
    <p><b>Id del cliente:</b> <?php echo $tick->id_cliente ?></p>
    <p><b>Fecha:</b> <?php echo $tick->fecha ?></p>

    <table>
        <tr>
            <th>Id del producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
        </tr>
        <?php
            foreach($id_productos as $prod)
        ?>
    </table>
    <?php
    include "footer.html"
    ?>
</body>

</html>