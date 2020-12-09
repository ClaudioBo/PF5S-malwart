<?php

include_once "connections/conn.php";
include_once "clases/ticket.php";

$query = "SELECT * FROM productos " . $busqueda;
$tickets = [];
if ($result = $mysqli->query($query)) {
    while ($res = mysqli_fetch_array($result)) {
        $tck = new Ticket();
        $tck->id = $res['id'];
        $tck->id_cliente = $res['id_cliente'];
        $tck->fecha = $res['fecha'];
        array_push($tickets, $tck);
    }
    $result->free_result();
}
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
            <th>Id cliente</th>
            <th>Fecha</th>
        </tr>
        <?php
        foreach ($tickets as $tick) {
        ?>

            <tr>
                <td>
                    <?echo $tick->id?>
                </td>
                <td>
                    <?echo $tick->id_cliente?>
                </td>
                <td>
                    <?echo $tick->fecha?>
                </td>
            </tr>
        <?php
        }

        ?>
    </table>
</body>

</html>