<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pastelería The Rock</title>
    <style>
        body {
            font-family: Arial;
            background: #8B5A2B;
            color: white;
        }
    </style>
</head>
<body>

<h1>Pastelería The Rock</h1>

<h2>Productos</h2>

<?php foreach($productos as $p): ?>
    <p><?= $p['nombre'] ?></p>
<?php endforeach; ?>

<div>
    <p>Pasteles</p>
    <p>Panadería</p>
    <p>Eventos</p>
</div>

<h2>Novedades</h2>

<p>Aquí irá tu contenido visual 👀</p>

</body>
</html>