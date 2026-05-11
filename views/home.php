<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>The Rock</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">
    <link rel="stylesheet" href="public/assets/css/style.css">

</head>

<body>

    <div class="navbar">
        <button class="btn-menu" onclick="abrirPanel()">
            ☰
        </button>

        <div>
            <img src="public/assets/img/logo.png" class="logo">
        </div>

        <div class="buscador-2">
            <div class="">
                <button class="dropbtn">Todos los productos</button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div>
            <div class="separador"></div>
            <input type="text" placeholder="Buscar...">
            <button class="btn-buscar">🔍</button>

        </div>
        <div class="acciones">
            <a href="?menu=login">
                <button class="btn-login">Iniciar sesión</button>
            </a>

            <a href="?menu=registro">
                <button class="btn-crear">Crear cuenta</button>
            </a>
        </div>
    </div>

    <div id="sidebar" class="sidebar">

        <button class="cerrar" onclick="cerrarPanel()">
            ✖
        </button>

        <h2>Menu</Menu>
        </h2>

        <ul>
            <li><a href="#"> Dashboard</a></li>
            <li><a href="#"> Productos</a></li>
            <li><a href="#"> Pedidos</a></li>
            <li><a href="#"> Clientes</a></li>
            <li><a href="#"> Reportes</a></li>
            <li><a href="#"> Configuración</a></li>
        </ul>

    </div>

    <div class="hero">
        <h1 class="titulo-principal">Productos</h1>
    </div>
    <div class="categorias">

        <div class="categoria">
            <div class="icono">
                <img src="public/assets/img/pasteles.jpg">
            </div>
            <p>Pasteles</p>
        </div>

        <div class="categoria">
            <div class="icono">
                <img src="public/assets/img/eventos.jpg">
            </div>
            <p>Pasteles para eventos</p>
        </div>

        <div class="categoria">
            <div class="icono">
                <img src="public/assets/img/galletas.jpg">
            </div>
            <p>Galletas</p>
        </div>

        <div class="categoria">
            <div class="icono">
                <img src="public/assets/img/panaderia.jpg">
            </div>
            <p>Panadería</p>
        </div>

    </div>
    <script src="public/assets/js/sidebar.js"></script>

</body>

</html>