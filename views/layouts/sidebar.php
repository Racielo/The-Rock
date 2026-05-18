<?php if (!empty($_SESSION['rol'])): ?>

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">

        <button class="cerrar" onclick="cerrarPanel()">
            <img src="public/assets/img/equis.png" width="20px">
        </button>

        <h2>Menú</h2>

        <ul>

            <?php if ($_SESSION['rol'] == 'usuario'): ?>

                <li><a href="?menu=home">Inicio</a></li>
                <li><a href="?menu=productoscliente">Productos</a></li>
                <li><a href="?menu=favoritos">Favoritos</a></li>
                <li><a href="?menu=pedidos">Mis pedidos</a></li>

            <?php elseif ($_SESSION['rol'] == 'admin'): ?>

                <li><a href="?menu=inventario">inventario</a></li>
                <li><a href="?menu=usuarios">Usuarios</a></li>
                <li><a href="?menu=productos">Administrar productos</a></li>
                <li><a href="?menu=inventario">Inventario</a></li>
                <li><a href="?menu=ventas">Ventas</a></li>

            <?php endif; ?>

        </ul>

    </div>

    <!-- OVERLAY -->
    <div id="overlay" class="overlay" onclick="cerrarPanel()"></div>

<?php endif; ?>