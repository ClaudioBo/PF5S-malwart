<?php
function registrarUsuario($email, $pass)
{
    global $mysqli;
    $errores = [];
    $query = "SELECT id FROM usuarios WHERE correo LIKE ? LIMIT 1;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $errores[] = "Ya existe una cuenta con el mismo correo electronico";
        }
    }
    $stmt->close();

    if (count($errores) == 0) {
        $query = "INSERT INTO usuarios (correo,contraseña) VALUES (?, ?)";
        $stmt = $mysqli->prepare($query);
        if ($mysqli->error) {
            echo $mysqli->error;
        }
        $stmt->bind_param('ss', $email, $pass);
        $stmt->execute();
    }
    $stmt->close();
    return $errores;
}

function cargarUsuario($email, $pass)
{
    include_once "clases/usuario.php";
    global $mysqli;
    $errores = [];
    $query = "SELECT id,contraseña FROM usuarios WHERE correo LIKE ? LIMIT 1";
    $stmt = $mysqli->prepare($query);
    if ($mysqli->error) {
        echo $mysqli->error;
    }
    $stmt->bind_param('s', $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            if ($row = $result->fetch_assoc()) {
                if ($pass != $row['contraseña']) {
                    $errores[] = "Contraseña incorrecta";
                } else {
                    $errores = $row['id'];
                }
            }
        } else {
            $errores[] = "Cuenta inexistente";
        }
    }
    $stmt->close();
    return $errores;
}

function loginUsuarioSesion()
{
    global $mysqli;
    session_start();
    $sesionUsuario = null;
    if (isset($_SESSION['id_user'])) {
        $query = sprintf(
            "SELECT * FROM usuarios WHERE id= '%s' LIMIT 1",
            mysqli_escape_string($mysqli, trim($_SESSION['id_user']))
        );
        if ($result = $mysqli->query($query)) {
            if ($result->num_rows != 0) {
                $sesionUsuario = new Usuario();
                $res = mysqli_fetch_array($result);
                $sesionUsuario = new Usuario();
                $sesionUsuario->id = $res['id'];
                $sesionUsuario->correo = $res['correo'];
                $sesionUsuario->contraseña = $res['contraseña'];
                $sesionUsuario->nombre = $res['nombre'];
                $sesionUsuario->apellido = $res['apellido'];
                $sesionUsuario->direccion = $res['direccion'];
                $sesionUsuario->telefono = $res['telefono'];
                $sesionUsuario->rol = $res['rol'];
            } else {
                header('Location: error.php');
            }
            $result->free_result();
        }
    }
    return $sesionUsuario;
}
