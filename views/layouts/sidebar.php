<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="sidebar" class="sidebar">

    <button class="cerrar" onclick="cerrarPanel()">

        <img src="public/assets/img/equis.png"
             width="20px">

    </button>

    <h2>Menú</h2>

    <ul>

        <?php if(isset($_SESSION['rol'])): ?>

            <!-- USUARIO -->

            <?php if($_SESSION['rol'] == 'usuario'): ?>

                <li>
                    <a href="?menu=home">
                        Inicio
                    </a>
                </li>

                <li>
                    <a href="?menu=productoscliente">
                        Productos
                    </a>
                </li>

                <li>
                    <a href="?menu=favoritos">
                        Favoritos
                    </a>
                </li>

                <li>
                    <a href="?menu=pedidos">
                        Mis pedidos
                    </a>
                </li>

            <?php endif; ?>


            <!-- ADMIN -->

            <?php if($_SESSION['rol'] == 'admin'): ?>

                <li>
                    <a href="?menu=home">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="?menu=usuarios">
                        Usuarios
                    </a>
                </li>

                <li>
                    <a href="?menu=productos">
                        Administrar productos
                    </a>
                </li>

                <li>
                    <a href="?menu=inventario">
                        Inventario
                    </a>
                </li>

                <li>
                    <a href="?menu=ventas">
                        Ventas
                    </a>
                </li>

            <?php endif; ?>

        <?php endif; ?>

    </ul>

</div>

<div id="overlay"
     class="overlay"
     onclick="cerrarPanel()">
</div>