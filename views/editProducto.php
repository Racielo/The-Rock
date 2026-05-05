<?php if (isset($producto) && $producto): ?>

<h2>Editar Producto</h2>

<form method="POST" action="?menu=editarProducto&id=<?= $producto['id'] ?>">
    
    <input type="text" name="ingrediente" value="<?= $producto['ingredientes'] ?? '' ?>" required>
    
    <input type="number" name="cantidad" value="<?= $producto['cantidad_actual'] ?? '' ?>" required>
    
    <input type="number" name="maximo" value="<?= $producto['cantidad_maxima'] ?? '' ?>" required>
    
    <select name="unidad">
        <option value="kg" <?= ($producto['unidad_medida'] ?? '')=='kg'?'selected':'' ?>>kg</option>
        <option value="litros" <?= ($producto['unidad_medida'] ?? '')=='litros'?'selected':'' ?>>litros</option>
        <option value="gramos" <?= ($producto['unidad_medida'] ?? '')=='gramos'?'selected':'' ?>>gramos</option>
    </select>

    <input type="date" name="fecha" value="<?= isset($producto['fecha']) ? date('Y-m-d', strtotime($producto['fecha'])) : '' ?>" required>

    <button type="submit">Guardar</button>
</form>

<?php else: ?>
    <p>Error: producto no encontrado</p>
<?php endif; ?>