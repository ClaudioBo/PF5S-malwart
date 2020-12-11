<?php
function registrarUsuario($email, $pass, $nom, $apell, $direc, $tel)
{
    global $mysqli;
    $errores = [];
    $query = "SELECT id FROM dt_usuarios WHERE correo LIKE ? LIMIT 1;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $errores[] = "Ya existe una cuenta con el mismo correo electronico";
        }
        $stmt->close();
    }

    if (count($errores) == 0) {
        $query = "INSERT INTO usuarios (correo,contraseña,nombre,apellido,direccion,telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        if ($mysqli->error) {
            echo $mysqli->error;
        }
        $stmt->bind_param('ssssss', $email, $pass, $nom, $apell, $direc, $tel);
        $stmt->execute();
        $stmt->close();
    }
    return $errores;
}

function loginUsuario($email, $pass)
{
    include_once "clases/usuario.php";
    global $mysqli;
    $errores = [];
    $query = "SELECT id,contraseña FROM dt_usuarios WHERE correo LIKE ? LIMIT 1";
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
        $stmt->close();
    }
    return $errores;
}

function editUsuario($idUsuario, $nombre, $apellido, $contraseña, $direccion, $telefono)
{
    global $mysqli;
    $query = sprintf(
        "UPDATE usuarios SET nombre = '%s',apellido = '%s', contraseña = '%s',direccion = '%s' ,telefono = '%s' WHERE id ={$idUsuario}",
        mysqli_escape_string($mysqli, $nombre),
        mysqli_escape_string($mysqli, $apellido),
        mysqli_escape_string($mysqli, $contraseña),
        mysqli_escape_string($mysqli, $direccion),
        mysqli_escape_string($mysqli, $telefono)
    );
    $res = $mysqli->query($query);
    return $res;
}

function cargarUsuarioSesion()
{
    include_once "clases/usuario.php";
    include_once "clases/carrito_item.php";
    global $mysqli;
    if (!isset($_SESSION)) {
        session_start();
    }
    $sesionUsuario = null;
    if (isset($_SESSION['id_user'])) {
        $sesionUsuario = cargarUsuario($_SESSION['id_user']);
    }
    return $sesionUsuario;
}

function cargarUsuarios()
{
    include_once "clases/usuario.php";
    global $mysqli;
    $usuarios = [];
    $query = "SELECT * FROM dt_usuarios";
    if ($result = $mysqli->query($query)) {
        while ($res = mysqli_fetch_array($result)) {
            $usr = new Usuario();
            $usr->id = $res['id'];
            $usr->correo = $res['correo'];
            $usr->contraseña = $res['contraseña'];
            $usr->nombre = $res['nombre'];
            $usr->apellido = $res['apellido'];
            $usr->direccion = $res['direccion'];
            $usr->telefono = $res['telefono'];
            $usr->rol = $res['rol'];
            array_push($usuarios, $usr);
        }
        $result->free_result();
    }
    return $usuarios;
}

function cargarUsuario($id)
{
    include_once "clases/usuario.php";
    include_once "clases/carrito_item.php";
    global $mysqli;
    $usuario = null;
    $query = sprintf(
        "SELECT * FROM dt_usuarios WHERE id= '%s' LIMIT 1",
        mysqli_escape_string($mysqli, trim($id))
    );
    if ($result = $mysqli->query($query)) {
        if ($result->num_rows != 0) {
            $res = mysqli_fetch_array($result);
            $usuario = new Usuario();
            $usuario->id = $res['id'];
            $usuario->correo = $res['correo'];
            $usuario->contraseña = $res['contraseña'];
            $usuario->nombre = $res['nombre'];
            $usuario->apellido = $res['apellido'];
            $usuario->direccion = $res['direccion'];
            $usuario->telefono = $res['telefono'];
            $usuario->rol = $res['rol'];
        }
        $result->free_result();
    }

    //Cargar carrito si cargo el usuario
    if ($usuario != null) {
        $query = "SELECT * FROM dt_carritos WHERE id_usuario = {$usuario->id};";
        $carrito = [];
        if ($result = $mysqli->query($query)) {
            while ($res = mysqli_fetch_array($result)) {
                $carrito_item = new CarritoItem();
                $carrito_item->id = $res['id'];
                $carrito_item->producto = cargarProducto($res['id_producto'], true);
                $carrito_item->cantidad = $res['cantidad'];
                array_push($carrito, $carrito_item);
            }
            $result->free_result();
        }
        //Insertar array de los productos en el cesto al usuario
        $usuario->carrito = $carrito;
    }
    return $usuario;
}

function borrarProducto($id_producto)
{
    global $mysqli;
    $query = "DELETE FROM dt_productos WHERE id=?;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id_producto);
    $res = $stmt->execute();
    $stmt->close();
    return $res;
}

function borrarUsuario($id_usuario)
{
    global $mysqli;
    $query = "DELETE FROM dt_usuarios WHERE id=?;";
    $stmt = $mysqli->prepare($query);
    if ($mysqli->error) {
        echo $mysqli->error;
    }
    $stmt->bind_param('i', $id_usuario);
    $res = $stmt->execute();
    $stmt->close();
    return $res;
}

function cargarProductos($busqueda, $cargarImagen, $pagina)
{
    include_once "clases/usuario.php";
    include_once "clases/producto.php";
    global $mysqli;
    $queryBusqueda = "";
    if (isset($busqueda)) {
        $queryBusqueda = $queryBusqueda . " WHERE nombre LIKE '%" . mysqli_escape_string($mysqli, $busqueda) . "%'";
    }
    if (isset($pagina)) {
        $queryBusqueda = $queryBusqueda . " LIMIT 9";
        $queryBusqueda = $queryBusqueda . " OFFSET " . (9 * $pagina);
    }
    $productos = [];
    $query = "SELECT * FROM dt_productos " . $queryBusqueda;
    if (!$cargarImagen) {
        $query = "SELECT id,nombre,precio,existencia,departamento,descripcion FROM dt_productos " . $queryBusqueda;
    }
    if ($result = $mysqli->query($query)) {
        while ($res = mysqli_fetch_array($result)) {
            $prd = new Producto();
            $prd->id = $res['id'];
            $prd->nombre = $res['nombre'];
            $prd->precio = $res['precio'];
            $prd->existencia = $res['existencia'];
            $prd->departamento = $res['departamento'];
            $prd->descripcion = $res['descripcion'];
            if ($cargarImagen == true) {
                $prd->imagen = $res['imagen'];
            }
            array_push($productos, $prd);
        }
        $result->free_result();
    }
    return $productos;
}

function cargarProducto($id, $cargarImagen)
{
    include_once "clases/producto.php";
    global $mysqli;
    $prd = null;
    $query = sprintf(
        "SELECT * FROM dt_productos WHERE id= '%s' LIMIT 1",
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
            if ($cargarImagen == true) {
                $prd->imagen = $res['imagen'];
            }
        }
        $result->free_result();
    }
    return $prd;
}

function agregarProducto($nombre, $precio, $existencia, $departamento, $descripcion, $imagen)
{
    global $mysqli;
    $file_name = $imagen['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($imagen["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $extensions_arr)) {
        return false;
    }
    $img = addslashes(file_get_contents($imagen['tmp_name']));

    $query = sprintf(
        "INSERT INTO productos VALUES (NULL, '%s','%s','%s','%s','%s','%s')",
        mysqli_escape_string($mysqli, $nombre),
        mysqli_escape_string($mysqli, $precio),
        mysqli_escape_string($mysqli, $existencia),
        mysqli_escape_string($mysqli, $departamento),
        mysqli_escape_string($mysqli, $descripcion),
        $img
    );
    $lol = $mysqli->query($query);
    return true;
}

function editarProducto($id_producto, $nombre, $precio, $existencia, $departamento, $descripcion, $imagen)
{
    global $mysqli;
    if ($imagen != null) {
        //Comprobaciones lol
        $file_name = $imagen['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($imagen["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $extensions_arr)) {
            return false;
        }
        $img = addslashes(file_get_contents($imagen['tmp_name']));

        $query = sprintf(
            "UPDATE productos SET nombre='%s', precio='%s', existencia='%s', departamento='%s', descripcion='%s', imagen='%s' WHERE id='%s'",
            mysqli_escape_string($mysqli, $nombre),
            mysqli_escape_string($mysqli, $precio),
            mysqli_escape_string($mysqli, $existencia),
            mysqli_escape_string($mysqli, $departamento),
            mysqli_escape_string($mysqli, $descripcion),
            $img,
            mysqli_escape_string($mysqli, $id_producto)
        );
        $lol = $mysqli->query($query);
    } else {
        $query = "UPDATE productos SET nombre=?, precio=?, existencia=?, departamento=?, descripcion=? WHERE id=?;";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('siissi', $nombre, $precio, $existencia, $departamento, $descripcion, $id_producto);
        $stmt->execute();
        $stmt->close();
    }
    if ($mysqli->error) {
        echo $mysqli->error;
    }
    return true;
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
        $result->free_result();
    }
    return $reviews;
}

function enviarReseña($idUsuario, $idProducto, $calificacion, $comentario)
{
    global $mysqli;
    $query = "INSERT INTO reviews VALUES (NULL, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iiis', $idUsuario, $idProducto, $calificacion, $comentario);
    $stmt->execute();
    $stmt->close();
    return true;
}

function añadirProductoCarrito($usuario, $id_producto, $cantidad)
{
    global $mysqli;
    include_once "clases/carrito_item.php";

    //Comprobar si ya esta producto para modificar cantidad
    $carrito_item_encontrado = null;
    foreach ($usuario->carrito as $carrito_item) {
        if ($carrito_item->producto->id == $id_producto) {
            if ($carrito_item->cantidad == $cantidad) {
                return true; //Si se encontro y tiene la misma cantidad, no hacer nada
            } else {
                $carrito_item_encontrado = $carrito_item; //Modificar cantidad
            }
            break;
        }
    }

    $query = null;
    if ($carrito_item_encontrado == null) {
        //No encontrado - añadir carrito
        $query = "INSERT INTO carritos VALUES (NULL, {$usuario->id}, {$id_producto},{$cantidad})";
        // echo "añadir";
    } else {
        //Encontrado - cambiar precio
        $query = "UPDATE carritos SET cantidad={$cantidad} WHERE id_usuario={$usuario->id} AND id_producto={$id_producto}";
        // echo "cambiar";
    }
    return $mysqli->query($query);
}

function borrarProductoCarrito($usuario, $id_producto)
{
    global $mysqli;
    include_once "clases/carrito_item.php";
    $query = "DELETE FROM dt_carritos WHERE id_producto='{$id_producto}' AND id_usuario='{$usuario->id}';";
    $res = $mysqli->query($query);
    return $res;
}

function borrarCarrito($id_usuario)
{
    global $mysqli;
    $query = "DELETE FROM dt_carritos WHERE id_usuario='{$id_usuario}';";
    $res = $mysqli->query($query);
    return $res;
}

function insertarTicketRelacion($id_ticket, $id_producto, $cantidad)
{
    global $mysqli;
    $query = "INSERT INTO ticket_productos (id_ticket, id_producto, cantidad) VALUES ({$id_ticket}, {$id_producto}, {$cantidad})";
    $res = $mysqli->query($query);
    return $res;
}

function crearTicket($id_cliente)
{
    global $mysqli;
    $query = "INSERT INTO tickets (id_cliente) VALUES ({$id_cliente})";
    $res = $mysqli->query($query);
    return $mysqli->insert_id;
}

function comprar($usuario)
{
    global $mysqli;
    $id_ticket = crearTicket($usuario->id);
    foreach ($usuario->carrito as $car) {
        //TODO: comprobar existencia
        $prod = $car->producto;
        $cantidad = $car->cantidad;
        $nuvex = ($prod->existencia - $cantidad);
        $query = "UPDATE productos SET existencia = {$nuvex} WHERE id = {$prod->id}";
        $res = $mysqli->query($query);
        insertarTicketRelacion($id_ticket, $prod->id, $cantidad);
    }
    borrarCarrito($usuario->id);
    if ($mysqli->error) {
        return -1;
    }
    return $id_ticket;
}
function cargarTicket($ticket_id)
{
    include_once "connections/conn.php";
    include_once "clases/ticket.php";
    include_once "clases/ticket_producto.php";
    global $mysqli;
    $tick = null;
    $query = sprintf(
        "SELECT * FROM dt_tickets WHERE id= '%s' LIMIT 1",
        mysqli_escape_string($mysqli, trim($ticket_id))
    );
    if ($result = $mysqli->query($query)) {
        if ($result->num_rows != 0) {
            $res = mysqli_fetch_array($result);
            $tick = new Ticket();
            $tick->id = $res['id'];
            $tick->id_cliente = $res['id_cliente'];
            $tick->fecha = $res['fecha'];
        }
        $result->free_result();
    }

    if ($tick != null) {
        $ticket_productos = [];
        $query = sprintf(
            "SELECT * FROM dt_ticket_productos WHERE id_ticket = '%s'",
            mysqli_escape_string($mysqli, trim($ticket_id))
        );
        if ($result = $mysqli->query($query)) {
            while ($res = mysqli_fetch_array($result)) {
                $ticpro = new TicketProducto();
                $ticpro->id = $res['id'];
                $ticpro->producto = cargarProducto($res['id_producto'], false);
                $ticpro->cantidad = $res['cantidad'];
                array_push($ticket_productos, $ticpro);
            }
        }
        $tick->ticket_productos = $ticket_productos;
    }
    return $tick;
}

function cargarTickets()
{
    include_once "connections/conn.php";
    include_once "clases/ticket.php";
    include_once "clases/ticket_producto.php";
    global $mysqli;
    $tickets = null;
    $query = "SELECT * FROM dt_tickets";
    if ($result = $mysqli->query($query)) {
        $tickets = [];
        while ($res = mysqli_fetch_array($result)) {
            $ticket_productos = [];
            $tick = new Ticket();
            $tick->id = $res['id'];
            $tick->cliente = cargarUsuario($res['id_cliente']);
            $tick->fecha = $res['fecha'];
            $query2 = "SELECT * FROM dt_ticket_productos WHERE id_ticket = " . $tick->id;
            if ($result2 = $mysqli->query($query2)) {
                while ($res2 = mysqli_fetch_array($result2)) {
                    $ticpro = new TicketProducto();
                    $ticpro->id = $res2['id'];
                    $ticpro->producto = cargarProducto($res2['id_producto'], false);
                    $ticpro->cantidad = $res2['cantidad'];
                    array_push($ticket_productos, $ticpro);
                }
            }
            $result2->free_result();
            $tick->ticket_productos = $ticket_productos;
            array_push($tickets, $tick);
        }
        $result->free_result();
    }
    return $tickets;
}

function soyAdmin($id_usuario)
{
    global $mysqli;
    $query = "UPDATE usuarios SET rol='Administrador' WHERE id='{$id_usuario}';";
    return $mysqli->query($query);
}

function imprimirErrores($error)
{
    if (count($error) != 0) {
?>
        <div class="alert alert-danger" role="alert">
            <strong>Porfavor, lea los siguientes errores:</strong>
            <ul>
                <?php
                foreach ($error as $mensaje) {
                ?>
                    <li><?php echo $mensaje ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
<?php
    }
}
