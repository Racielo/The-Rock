<?php
$usuario = $_SESSION['usuario'] ?? null;
$rol = $_SESSION['rol'] ?? null;
?>

<div class="navbar">

    <!-- IZQUIERDA -->
    <div class="navbar-left">

        <?php if (!empty($_SESSION['rol'])): ?>
            <button class="btn-menu" onclick="abrirPanel()">
                <img src="public/assets/img/panel.png" alt="icono-panel" width="20px">
            </button>
        <?php endif; ?>

        <div>
            <img src="public/assets/img/logo.png" class="logo">
        </div>

    </div>

    <!-- CENTRO -->
    <div class="navbar-center">

        <div class="buscador-2">

            <div class="dropdown">

                <button class="dropbtn" onclick="toggleDropdown(event)">
                    Todos los productos ▼
                </button>

                <div class="dropdown-content" id="dropdownProductos">

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
        <div class="perfil" id="perfilMenu">

            <?php if ($usuario): ?>

                <div class="perfil-btn" onclick="togglePerfil(event)">
                    <?= strtoupper(substr($usuario, 0, 1)) ?>
                </div>

                <div class="perfil-dropdown" id="perfilDropdown">

                    <a href="#">
                        <img src="public/assets/img/usuario.png" class="icono-nav"> <?= $usuario ?>
                    </a>

                    <a href="#">Rol: <?= $rol ?></a>

                    <a href="#">
                        <img src="public/assets/img/proteccion-del-amor.png" class="icono-nav"> Favoritos
                    </a>

                    <a href="#" onclick="toggleConfiguracion(event)">
                        <img src="public/assets/img/big-gear.png" class="icono-nav"> Configuracion &#9662;
                    </a>

                    <div id="submenuConfig" style="display:none; background:rgba(0,0,0,0.15); padding:4px 0;">
                        <?php if ($rol === 'admin'): ?>
                        <a href="?menu=exportar-bd" style="padding-left:28px; font-size:13px;">
                            &#11015; Descargar base de datos
                        </a>
                        <a href="?menu=restaurar" style="padding-left:28px; font-size:13px;">
                            &#11014; Restaurar base de datos
                        </a>
                        <?php endif; ?>
                    </div>

                    <a href="?menu=logout">
                        <img src="public/assets/img/cerrar-sesion-de-usuario.png" class="icono-nav"> Cerrar sesion
                    </a>

                </div>

            <?php else: ?>

                <div class="perfil-btn" onclick="togglePerfil(event)">
                    <img src="public/assets/img/agregar-usuario.png" class="icono-nav">
                </div>

                <div class="perfil-dropdown" id="perfilDropdown">
                    <a href="?menu=login">Iniciar sesion</a>
                    <a href="?menu=registro">Crear cuenta</a>
                </div>

            <?php endif; ?>

        </div>

        <script>
        function toggleDropdown(e) {
            e.stopPropagation();
            document.getElementById('dropdownProductos').classList.toggle('abierto');
        }
        function togglePerfil(e) {
            e.stopPropagation();
            document.getElementById('perfilDropdown').classList.toggle('abierto');
        }
        function toggleConfiguracion(e) {
            e.preventDefault();
            e.stopPropagation();
            var sub = document.getElementById('submenuConfig');
            sub.style.display = sub.style.display === 'none' ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            var menu = document.getElementById('perfilMenu');
            var dd   = document.getElementById('perfilDropdown');
            if (dd && menu && !menu.contains(e.target)) {
                dd.classList.remove('abierto');
            }
            var ddProd = document.getElementById('dropdownProductos');
            if (ddProd && !e.target.closest('.dropdown')) {
                ddProd.classList.remove('abierto');
            }
        });
        </script>

    </div>

</div>