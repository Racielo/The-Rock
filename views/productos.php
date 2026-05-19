<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">
    <link rel="icon" href="public/assets/img/logo.png" type="image/png">
</head>
<body>

    <button class="btn-menu" onclick="abrirPanel()">☰</button>
    <?php include 'views/layouts/sidebar.php'; ?>

    <div class="container">
        <div class="card">

            <h1>Productos</h1>

            <button class="btn-agregar" onclick="abrirModalProducto()">+ Agregar Producto</button>

            <div class="buscador">
                <input type="text" id="buscarProducto"
                       placeholder="Buscar por nombre, categoría o estado..."
                       onkeyup="buscarProductos()">
            </div>

            <table id="tablaProductos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Vida útil</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= $p['id_producto'] ?></td>
                                <td><?= htmlspecialchars($p['nombre_producto']) ?></td>
                                <td><?= htmlspecialchars($p['descripcion']) ?></td>
                                <td>$<?= number_format($p['precio_venta'], 2) ?></td>
                                <td><?= htmlspecialchars($p['categoria']) ?></td>
                                <td><?= $p['dias_vida_util'] ?> días</td>
                                <td style="color: <?= $p['estado_producto']==='Activo' ? 'green' : ($p['estado_producto']==='Temporada' ? 'orange' : '#888') ?>; font-weight:bold;">
                                    <?= htmlspecialchars($p['estado_producto']) ?>
                                </td>
                                <td>
                                    <button onclick="abrirEditarProducto(
                                        '<?= $p['id_producto'] ?>',
                                        '<?= htmlspecialchars($p['nombre_producto'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($p['descripcion'],     ENT_QUOTES) ?>',
                                        '<?= $p['precio_venta'] ?>',
                                        '<?= htmlspecialchars($p['categoria'],       ENT_QUOTES) ?>',
                                        '<?= $p['dias_vida_util'] ?>',
                                        '<?= htmlspecialchars($p['estado_producto'], ENT_QUOTES) ?>'
                                    )">Editar</button>

                                    <a href="?menu=borrarProducto&id=<?= $p['id_producto'] ?>"
                                       onclick="return confirm('¿Eliminar producto?')">
                                        <button>Eliminar</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No hay productos registrados</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- MODAL AGREGAR -->
    <div id="modalAgregarProducto" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" onclick="cerrarModalProducto()">&times;</span>
            <h2>Agregar Producto</h2>
            <form method="POST" action="?menu=crearProducto">
                <input type="text"   name="nombre_producto" placeholder="Nombre"       required>
                <input type="text"   name="descripcion"     placeholder="Descripción"  required>
                <input type="number" step="0.01" name="precio_venta" placeholder="Precio ($)" required>
                <select name="categoria" required>
                    <option value="" disabled selected>Categoría</option>
                    <option value="Pasteles">Pasteles</option>
                    <option value="Galletas">Galletas</option>
                    <option value="Panadería">Panadería</option>
                    <option value="Postres">Postres</option>
                    <option value="Bebidas">Bebidas</option>
                    <option value="Otro">Otro</option>
                </select>
                <input type="number" name="dias_vida_util" placeholder="Días de vida útil" required>
                <select name="estado_producto" required>
                    <option value="Activo">Activo</option>
                    <option value="Temporada">Temporada</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="modalEditarProducto" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" onclick="cerrarEditarProducto()">&times;</span>
            <h2>Editar Producto</h2>
            <form method="POST" id="formEditarProducto">
                <input type="text"   name="nombre_producto" id="editNombre"      required>
                <input type="text"   name="descripcion"     id="editDescripcion" required>
                <input type="number" step="0.01" name="precio_venta" id="editPrecio" required>
                <select name="categoria" id="editCategoria" required>
                    <option value="Pasteles">Pasteles</option>
                    <option value="Galletas">Galletas</option>
                    <option value="Panadería">Panadería</option>
                    <option value="Postres">Postres</option>
                    <option value="Bebidas">Bebidas</option>
                    <option value="Otro">Otro</option>
                </select>
                <input type="number" name="dias_vida_util" id="editDias" required>
                <select name="estado_producto" id="editEstado" required>
                    <option value="Activo">Activo</option>
                    <option value="Temporada">Temporada</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="public/assets/js/sidebar.js"></script>
    <script src="public/assets/js/productos.js"></script>
</body>
</html>