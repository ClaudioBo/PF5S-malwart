<?php

include_once "connections/conn.php";
$img = addslashes(file_get_contents("roles.jpeg"));
$query = "UPDATE productos SET imagen = '$img' WHERE id = 8;";
if ($mysqli->query($query) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $mysqli->error;
  }
$mysqli->close();
?>