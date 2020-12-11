<div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div>
            <a class="navbar-brand" href="#">Malwart</a>
            <img src="logo.png" width=48>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($selectedPage == "productos") ? "active" : ""; ?>">
                    <a class="nav-link" href="index.php">Productos</a>
                </li>
                <li class="nav-item <?php echo ($selectedPage == "carrito") ? "active" : ""; ?>">
                    <a class="nav-link" href="carrito.php">Carrito
                        <?php
                        if ($sesionUsuario != null && count($sesionUsuario->carrito) != 0) {
                            $count = count($sesionUsuario->carrito);
                            echo ("<strong>({$count})</strong>");
                        }
                        ?>
                    </a>
                </li>
                <li class="nav-item <?php echo ($selectedPage == "usuario") ? "active" : ""; ?>">
                    <?php
                    if ($sesionUsuario != null) {
                    ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"><strong><?php echo ($sesionUsuario->nombre); ?></strong></a>
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="editarUsuario.php">Editar tu informacion</a>
                        <?php
                        if ($sesionUsuario->rol != 'Normal') {
                        ?>
                            <hr>
                            <div class="text-center">
                                <span class="badge badge-pill badge-primary"><?php echo ($sesionUsuario->rol) ?></span>
                            </div>
                            <?php
                            if ($sesionUsuario->rol == 'Administrador') {
                            ?>
                                <a class="dropdown-item" href="tickets.php">Ver tickets</a>
                                <a class="dropdown-item" href="adminUsuarios.php">Administrar usuarios</a>
                            <?php
                            }
                            ?>
                            <a class="dropdown-item" href="adminProductos.php">Administrar productos</a>
                        <?php
                        }
                        ?>
                        <hr>
                        <a class="dropdown-item" href="logout.php">Salir</a>
                    </div>
                </li>
            <?php
                    } else {
            ?>
                <a class="nav-link" href="login.php">Usuario </a>
            <?php
                    }
            ?>
            </li>
            </ul>
        </div>
    </div>
</div>
<br>