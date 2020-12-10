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
                        <a class="dropdown-item" href="#">Salir</a>
                        <?php
                        if ($sesionUsuario->rol != 'Normal') {
                        ?>
                            <hr>
                            <a class="dropdown-item" href="#">Panel de <?php echo ($sesionUsuario->rol) ?></a>
                        <?php
                        }
                        ?>
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