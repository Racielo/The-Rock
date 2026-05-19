<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
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

            <h1>Inventario</h1>

            <button class="btn-agregar" onclick="abrirModalInventario()">+ Agregar Insumo</button>

            <div class="buscador">
                <input type="text" id="buscarInventario"
                       placeholder="Buscar insumo..."
                       onkeyup="buscarInventario()">
            </div>

            <table id="tablaInventario">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Stock mínimo</th>
                        <th>Ingreso</th>
                        <th>Caducidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inventario)): ?>
                        <?php foreach ($inventario as $item):
                            $color = match($item['estado']) {
                                'Agotado'     => '#c0392b',
                                'Por caducar' => '#e67e22',
                                'Inactivo'    => '#888888',
                                default       => '#27ae60'
                            };
                        ?>
                            <tr>
                                <td><?= $item['id_insumo'] ?></td>
                                <td><?= htmlspecialchars($item['nombre']) ?></td>
                                <td><?= number_format($item['cantidad_actual'], 2) ?></td>
                                <td><?= htmlspecialchars($item['unidad_medida']) ?></td>
                                <td><?= number_format($item['stock_minimo'], 2) ?></td>
                                <td><?= $item['fecha_ingreso'] ?></td>
                                <td><?= $item['fecha_caducidad'] ?? '—' ?></td>
                                <td style="color:<?= $color ?>; font-weight:bold;">
                                    <?= htmlspecialchars($item['estado']) ?>
                                </td>
                                <td>
                                    <button onclick="abrirEditarInventario(
                                        '<?= $item['id_insumo'] ?>',
                                        '<?= htmlspecialchars($item['nombre'],        ENT_QUOTES) ?>',
                                        '<?= $item['cantidad_actual'] ?>',
                                        '<?= htmlspecialchars($item['unidad_medida'], ENT_QUOTES) ?>',
                                        '<?= $item['stock_minimo'] ?>',
                                        '<?= $item['fecha_ingreso'] ?>',
                                        '<?= $item['fecha_caducidad'] ?? '' ?>',
                                        '<?= htmlspecialchars($item['estado'],        ENT_QUOTES) ?>'
                                    )">Editar</button>

                                    <a href="?menu=borrarInventario&id=<?= $item['id_insumo'] ?>"
                                       onclick="return confirm('¿Eliminar insumo?')">
                                        <button>Eliminar</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9">No hay insumos registrados</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- MODAL AGREGAR -->
    <div id="modalInventario" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" onclick="cerrarModalInventario()">&times;</span>
            <h2>Agregar Insumo</h2>
            <form method="POST" action="?menu=crearInventario">
                <input type="text"   name="nombre"          placeholder="Nombre del insumo" required>
                <input type="number" step="0.01" name="cantidad_actual" placeholder="Cantidad" required>
                <input type="text"   name="unidad_medida"   placeholder="Unidad (kg, litros...)" required>
                <input type="number" step="0.01" name="stock_minimo"   placeholder="Stock mínimo" required>
                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso" value="<?= date('Y-m-d') ?>" required>
                <label>Fecha de caducidad</label>
                <input type="date" name="fecha_caducidad">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="modalEditarInventario" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" onclick="cerrarEditarInventario()">&times;</span>
            <h2>Editar Insumo</h2>
            <form method="POST" id="formEditarInventario">
                <input type="text"   name="nombre"          id="editNombre"        required>
                <input type="number" step="0.01" name="cantidad_actual" id="editCantidad" required>
                <input type="text"   name="unidad_medida"   id="editUnidad"        required>
                <input type="number" step="0.01" name="stock_minimo"   id="editStockMin"  required>
                <label>Fecha de ingreso</label>
                <input type="date" name="fecha_ingreso"   id="editFechaIngreso">
                <label>Fecha de caducidad</label>
                <input type="date" name="fecha_caducidad" id="editFechaCaducidad">
                <select name="estado" id="editEstado">
                    <option value="Disponible">Disponible</option>
                    <option value="Por caducar">Por caducar</option>
                    <option value="Agotado">Agotado</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="public/assets/js/sidebar.js"></script>
    <script src="public/assets/js/inventario.js"></script>
</body>
</html>