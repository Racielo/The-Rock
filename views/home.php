<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>The Rock</title>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
</head>
<body>

<div class="navbar">

    <div class="logo-container">
        <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo">
    </div>

    <div class="acciones">
        <a href="<?= BASE_URL ?>?controller=auth&action=login">
            <button class="btn-login">Iniciar sesión</button>
        </a>

        <a href="<?= BASE_URL ?>?controller=auth&action=registro">
            <button class="btn-crear">Crear cuenta</button>
        </a>
    </div>

</div>


<div class="hero">
    <h1 class="titulo-principal">Productos</h1>
</div>
 <div class="categorias">

        <div class="categoria">
            <div class="icono">
                <img src="assets/img/pasteles.jpg">
            </div>
            <p>Pasteles</p>
        </div>

        <div class="categoria">
            <div class="icono">
                <img src="assets/img/eventos.jpg">
            </div>
            <p>Pasteles para eventos</p>
        </div>

        <div class="categoria">
            <div class="icono">
                <img src="assets/img/galletas.jpg">
            </div>
            <p>Galletas</p>
        </div>

        <div class="categoria">
            <div class="icono">
                <img src="assets/img/panaderia.jpg"> 
            </div>
            <p>Panadería</p>
        </div>

    </div>


</body>
</html>