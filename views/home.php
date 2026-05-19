<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>The Rock</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">
    <link rel="stylesheet" href="public/assets/css/home.css">
    <link rel="icon" href="public/assets/img/logo.png" type="image/png">

</head>

<body>
    <?php include 'views/layouts/navbar.php'; ?>

    <?php include 'views/layouts/sidebar.php'; ?>


    <div class="hero">
        <h1 class="titulo-principal">Eslogan</h1>
    </div>
    <div class="slider-showcase">

        <!-- IZQUIERDA -->
<div class="showcase-card small" id="card1">
            <img src="public/assets/img/pastel.jpeg">

            <div class="overlay">

                <button>Ver más </button>

            </div>

        </div>

        <!-- CENTRO -->
<div class="showcase-card large" id="card2">
            <img src="public/assets/img/otropastel.jpeg">

            <div class="overlay center">

                <button>Ver más</button>

            </div>

        </div>

        <!-- DERECHA -->
<div class="showcase-card small" id="card3">
            <img src="public/assets/img/Mexico.jpeg">

            <div class="overlay">

                <button>Ver más</button>

            </div>

        </div>

    </div>

    </div>
        <div class="hero">
        <h1 class="titulo-principal">Productos</h1>
    </div>
    <div class="categorias">

        <div class="categoria" onclick="irASeccion('pasteles')">
            <div class="icono">
                <img src="public/assets/img/pasteles.jpg">
            </div>
            <p>Pasteles</p>
        </div>

        <div class="categoria" onclick="irASeccion('eventos')">
            <div class="icono">
                <img src="public/assets/img/eventos.jpg">
            </div>
            <p>Pasteles para eventos</p>
        </div>

        <div class="categoria" onclick="irASeccion('galletas')">
            <div class="icono">
                <img src="public/assets/img/galletas.jpg">
            </div>
            <p>Galletas</p>
        </div>

        <div class="categoria" onclick="irASeccion('panaderia')">
            <div class="icono">
                <img src="public/assets/img/panaderia.jpg">
            </div>
            <p>Panadería</p>
        </div>

    </div>

    <section id="pasteles" class="seccion-productos">

        <h2>Pasteles</h2>

        <div class="grid-productos">

            <div class="producto">

                <img src="public/assets/img/pastel1.jpg">

                <div class="producto-info">

                    <h3>Pastel Chocolate</h3>

                    <p>$350</p>

                </div>

            </div>

        </div>

    </section>
    <script src="public/assets/js/sidebar.js"></script>
    <script src="public/assets/js/home.js"></script>

</body>

</html>