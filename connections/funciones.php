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

function loginUsuario($email, $pass)
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

function editUsuario($nombre,$apellido,$tel,$dire)
{
    include_once "clases/usuario.php";
    global $mysqli;
    session_start();
    if(isset($_SESSION['id_user'])){
    $query = sprintf("UPDATE usuario SET nombre = '%s',apellido = '%s', contraseña = '%s',direccion = '%s' ,telefono = '%s' WHERE id ={$_SESSION['id_user']}",
                    mysqli_escape_string($mysqli, trim($_POST['nombre'])),
                    mysqli_escape_string($mysqli, trim($_POST['apellido'])),
                    mysqli_escape_string($mysqli, trim($_POST['contraseña'])),
                    mysqli_escape_string($mysqli, trim($_POST['direccion'])),
                    mysqli_escape_string($mysqli, trim($_POST['telefono']))
                );
    }
}

function loginUsuarioSesion()
{
    include_once "clases/usuario.php";
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

function cargarProductos($busqueda)
{
    include_once "clases/usuario.php";
    global $mysqli;
    $queryBusqueda = "";
    if (isset($busqueda)) {
        $queryBusqueda = "WHERE nombre LIKE '%" . mysqli_escape_string($mysqli, $busqueda) . "%'";
    }
    $productos = [];
    $query = "SELECT * FROM productos " . $queryBusqueda;
    if ($result = $mysqli->query($query)) {
        while ($res = mysqli_fetch_array($result)) {
            $prd = new Producto();
            $prd->id = $res['id'];
            $prd->nombre = $res['nombre'];
            $prd->precio = $res['precio'];
            $prd->existencia = $res['existencia'];
            $prd->departamento = $res['departamento'];
            $prd->descripcion = $res['descripcion'];
            $prd->imagen = $res['imagen'];
            array_push($productos, $prd);
        }
        $result->free_result();
    }
    return $productos;
}

function cargarProducto($id)
{
    include_once "clases/producto.php";
    global $mysqli;
    $prd = null;
    $query = sprintf(
        "SELECT * FROM productos WHERE id= '%s' LIMIT 1",
        mysqli_escape_string($mysqli, trim($id))
    );
    if ($result = $mysqli->query($query)) {
        if ($result->num_rows != 0) {
            $res = mysqli_fetch_array($result);
            $prd = new Producto();
            $prd->id = $res['id'];
            $prd->nombre = $res['nombre'];
            $prd->precio = $res['precio'];
            $prd->existencia = $res['existencia'];
            $prd->departamento = $res['departamento'];
            $prd->descripcion = $res['descripcion'];
            $prd->imagen = $res['imagen'];
        }
        $result->free_result();
    }
    return $prd;
}

function cargarReviews($idProducto)
{
    include_once "clases/review.php";
    global $mysqli;
    $reviews = [];
    $query = sprintf(
        "SELECT r.id,r.usuario_id,u.nombre,producto_id,calificacion,comentario 
        FROM reviews AS r 
        INNER JOIN usuarios AS u 
        ON r.usuario_id = u.id
        WHERE r.producto_id = %s;",
        mysqli_escape_string($mysqli, trim($idProducto))
    );
    if ($result = $mysqli->query($query)) {
        while ($res = mysqli_fetch_array($result)) {
            $rev = new Review();
            $rev->id = $res['id'];
            $rev->usuario_id = $res['usuario_id'];
            $rev->usuario_nombre = $res['nombre'];
            $rev->producto_id = $res['producto_id'];
            $rev->calificacion = $res['calificacion'];
            $rev->comentario = $res['comentario'];
            array_push($reviews, $rev);
        }
    }
    $result->free_result();
    return $reviews;
}

function enviarReseña($idUsuario, $idProducto, $calificacion, $comentario)
{
    global $mysqli;
    // $query = "SELECT * FROM reviews WHERE id=? AND usuario_id=? LIMIT 1;";
    // $stmt = $mysqli->prepare($query);
    // $stmt->bind_param('ii', $idProducto, $idUsuario);
    // if ($stmt->execute()) {
    //     $result = $stmt->get_result();
    //     if ($result->num_rows != 0) {
    //         return false;
    //     }
    // }
    // $stmt->close();
    $query = "INSERT INTO reviews VALUES (NULL, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iiis', $idUsuario, $idProducto, $calificacion, $comentario);
    $stmt->execute();
    $stmt->close();
    return true;
}
