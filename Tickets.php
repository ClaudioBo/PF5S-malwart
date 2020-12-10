<?php

include_once "connections/conn.php";
include_once "connections/funciones.php";

$tickets = cargarTickets();
// $query = "SELECT * FROM tickets ";
// if ($result = $mysqli->query($query)) {
//     while ($res = mysqli_fetch_array($result)) {
//         $tck = new Ticket();
//         $tck->id = $res['id'];
//         $tck->id_cliente = $res['id_cliente'];
//         $tck->fecha = $res['fecha'];
//         array_push($tickets, $tck);
//     }
//     $result->free_result();
// }
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
            $url = "verTicket.php?id=" . $tick->id
        ?>

            <tr>
                <td>
                    <a href="<?php echo $url ?>"><?php echo $tick->id ?></a>
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
    <?php
    include "footer.html"
    ?>
</body>

</html>