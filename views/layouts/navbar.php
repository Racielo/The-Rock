<?php
$usuario = $_SESSION['usuario'] ?? null;
$rol = $_SESSION['rol'] ?? null;
?>

<div class="navbar">

    <!-- IZQUIERDA -->
    <div class="navbar-left">

        <button class="btn-menu" onclick="abrirPanel()">
            <img src="public/assets/img/panel.png" alt="icono-panel" width="20px">
        </button>

        <div>
            <img src="public/assets/img/logo.png" class="logo">
        </div>

    </div>

    <!-- CENTRO -->
    <div class="navbar-center">

        <div class="buscador-2">

            <div class="dropdown">

                <button class="dropbtn">
                    Todos los productos ▼
                </button>

<div class="dropdown-content">

    <a onclick="irASeccion('pasteles')">
        Pasteles
    </a>

    <a onclick="irASeccion('eventos')">
        Pasteles para eventos
    </a>

    <a onclick="irASeccion('galletas')">
        Galletas
    </a>

    <a onclick="irASeccion('panaderia')">
        Panadería
    </a>

</div>

            </div>

            <div class="separador"></div>

            <input type="text" placeholder="Buscar...">

            <button class="btn-buscar">
                <img src="public/assets/img/buscar.png" class="icono-nav">
            </button>

        </div>

    </div>

    <!-- DERECHA -->
    <div class="navbar-right">

        <!-- NOTIFICACIONES 
     <div class="notificaciones">
        <img src="public/assets/img/notificacion.png" class="icono-nav">
    </div>
        -->
        <!-- PERFIL -->
        <div class="perfil">

            <?php if ($usuario): ?>

                <div class="perfil-btn">

                    <?= strtoupper(substr($usuario, 0, 1)) ?>

                </div>

                <div class="perfil-dropdown">

                    <a href="#">
                        <img src="public/assets/img/usuario.png" class="icono-nav"> <?= $usuario ?>
                    </a>

                    <a href="#">
                        Rol: <?= $rol ?>
                    </a>

                    <a href="#">
                        <img src="public/assets/img/proteccion-del-amor.png" class="icono-nav"> Favoritos
                    </a>

                    <a href="#">
                        <img src="public/assets/img/big-gear.png" class="icono-nav">Configuración
                    </a>

                    <a href="?menu=logout">
                        <img src="public/assets/img/cerrar-sesion-de-usuario.png" class="icono-nav"> Cerrar sesión

                    </a>

                </div>

            <?php else: ?>

                <div class="perfil-btn">
                    <img src="public/assets/img/agregar-usuario.png" class="icono-nav">
                </div>

                <div class="perfil-dropdown">

                    <a href="?menu=login">
                        Iniciar sesión
                    </a>

                    <a href="?menu=registro">
                        Crear cuenta
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>