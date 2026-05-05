<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
</head>

<body>

<div style="display:flex; gap:10px; margin:15px;">
    <a href="?menu=productos">
        <button>Volver</button>
    </a>

    <a href="?menu=usuarios">
        <button>Ir a Usuarios</button>
    </a>
</div>

<div class="container">
<div class="card">

<h1>Editar Producto</h1>

<?php if (isset($producto) && $producto): ?>

<form method="POST" action="?menu=editarProducto&id=<?= $producto['id'] ?>">
    
    <input type="text" name="ingrediente" value="<?= $producto['ingrediente'] ?? '' ?>" required>
    
    <input type="number" name="cantidad" value="<?= $producto['cantidad_actual'] ?? '' ?>" required>
    
    <input type="number" name="maximo" value="<?= $producto['cantidad_maxima'] ?? '' ?>" required>
    
    <select name="unidad">
        <option value="kg" <?= ($producto['unidad_medida'] ?? '')=='kg'?'selected':'' ?>>kg</option>
        <option value="l" <?= ($producto['unidad_medida'] ?? '')=='l'?'selected':'' ?>>Litros</option>
        <option value="piezas" <?= ($producto['unidad_medida'] ?? '')=='piezas'?'selected':'' ?>>Piezas</option>
    </select>

    <input type="date" name="fecha" 
    value="<?= isset($producto['fecha']) ? date('Y-m-d', strtotime($producto['fecha'])) : '' ?>" required>

    <button type="submit">Guardar</button>
</form>

<?php else: ?>
    <p>Error: producto no encontrado</p>
<?php endif; ?>

</div>
</div>

</body>
</html>