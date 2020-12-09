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
        $tck->id_empleado = $res['id_empleado'];
        $tck->fecha = $res['fecha'];
        array_push($productos, $tck);
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
</body>

</html>