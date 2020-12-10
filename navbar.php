<div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Malwart</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($selectedPage == "productos") ? "active" : ""; ?>">
                    <a class="nav-link" href="index.php">Productos</a>
                </li>
                <li class="nav-item <?php echo ($selectedPage == "carrito") ? "active" : ""; ?>">
                    <a class="nav-link" href="#">Carrito</a>
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
                            if ($sesionUsuario->rol != 'Vendedor') {
                            ?>
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