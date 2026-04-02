<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
</head>
<body>
<h1>Usuarios</h1>

<?php foreach($usuarios as $u): ?>
    <p><?php echo $u['nombre']; ?></p>
<?php endforeach; ?>
</body>
</html>