<div id="sidebar" class="sidebar">

    <button class="cerrar" onclick="cerrarPanel()">

        <img src="public/assets/img/equis.png"
             alt="cerrar"
             width="20px">

    </button>

    <h2>Menú</h2>

    <ul>

        <!-- =========================
             USUARIO NORMAL
        ========================== -->

        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'usuario'): ?>

            <li>
                <a href="?menu=home">
                    <img src="public/assets/img/hogar.png" alt="icono-home" width="20px">
                    inicio
                </a>
            </li>

            <li>
                <a href="?menu=productos">
                    <img src="public/assets/img/pastelito.png" alt="icono-producto" width="20px">
                    productoa
                </a>
            </li>

            <li>
                <a href="?menu=favoritos">
                    <img src="public/assets/img/carrito.png" alt="icono-carrito" width="20px">
                    carrito
                </a>
            </li>

            <li>
                <a href="?menu=pedidos">
                    <img src="public/assets/img/bolsacompra.png" alt="icono-pediycompr" width="20px">
                    Pedidos y compras
                                
                </a>
            </li>

        <?php endif; ?>


        <!-- =========================
             ADMIN
        ========================== -->

        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>

            <li>
                <a href="?menu=home">
                    🏠 Dashboard
                </a>
            </li>

            <li>
                <a href="?menu=usuarios">
                    👥 Usuarios
                </a>
            </li>

            <li>
                <a href="?menu=productos">
                    🧁 Administrar productos
                </a>
            </li>

            <li>
                <a href="?menu=inventario">
                    📦 Inventario
                </a>
            </li>

            <li>
                <a href="?menu=pedidosAdmin">
                    🛒 Pedidos
                </a>
            </li>

            <li>
                <a href="?menu=ventas">
                    📈 Ventas
                </a>
            </li>

        <?php endif; ?>

    </ul>

</div>

<div id="overlay"
     class="overlay"
     onclick="cerrarPanel()">
</div>