<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>

    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
</head>

<body>

<div style="display:flex; gap:10px; margin:15px;">
    <a href="?menu=usuarios">
        <button>Volver</button>
    </a>

</div>

<div class="container">
<div class="card">

<h1>Editar Usuario</h1>

<?php if (isset($usuario) && $usuario): ?>

<form method="POST" action="?menu=editar&id=<?= $usuario['id'] ?>">
    
    <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>" required>
    
    <input type="email" name="email" value="<?= $usuario['correo'] ?>" required>

    <button type="submit">Guardar</button>
</form>

<?php else: ?>
    <p>Error: usuario no encontrado</p>
<?php endif; ?>

</div>
</div>

</body>
</html>