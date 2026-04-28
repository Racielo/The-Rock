<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>The Rock</title>
<link rel="stylesheet" href="public/assets/css/fondo.css">
<link rel="stylesheet" href="public/assets/css/styles.css">
</head>
<body>

<div class="navbar">


    <div >
        <img src="public/assets/img/logo.png" class="logo">
           </div>

    <div class="buscador-2">
        <div class="btn-todos"> <!-- se van a implentar dropdown en el boton de "Todos los productos" -->
            <p>Todos los productos<span></span></p>
            <ul>
                <!-- Aqui se pondran los productos de "Pasteles", "Pasteles para eventos", "galletas" y "panaderia" -->
            </ul>
        </div>
        <div class="separador"></div>
        <input type="text" placeholder="Buscar...">
        <button class="btn-buscar">🔍</button>

    </div>
        <div class="acciones">
        <a href="?controller=auth&action=login">
            <button class="btn-login">Iniciar sesión</button>
        </a>

        <a href="?controller=auth&action=registro">
            <button class="btn-crear">Crear cuenta</button>
        </a>
    </div>
    </div>


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


</body>
</html>