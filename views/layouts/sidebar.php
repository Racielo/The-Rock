<div id="sidebar" class="sidebar">

        <button class="cerrar" onclick="cerrarPanel()">
                        <img src="public/assets/img/equis.png" alt="opcion-salir" width="20px">

        </button>

        <h2>Menu</Menu>
        </h2>   

<ul>

    <li>
        <a href="?menu=home">inicio</a>
    </li>

    <li>
        <a href="?menu=productoscliente">Productos</a>
    </li>

<?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
        <li>
        <a href="?menu=home">inicio</a>
        </li>    
        <li>
            <a href="?menu=usuarios">Usuarios</a>
        </li>
            <li>
        <a href="?menu=productos">Productos</a>
    </li>

        <li>
            <a href="?menu=inventario">Inventario</a>
        </li>

        <li>
            <a href="?menu=ventas">Ventas</a>
        </li>

        <li>
            <a href="?menu=configuracion">Configuración</a>
        </li>

    <?php endif; ?>

</ul>

    </div>
