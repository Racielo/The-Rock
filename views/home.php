<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>The Rock</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">

</head>

<body>
<?php include 'views/layouts/navbar.php'; ?>

<?php include 'views/layouts/sidebar.php'; ?>

    
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