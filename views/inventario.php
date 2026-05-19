<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Inventario</title>

    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">

    <link rel="icon"
          href="public/assets/img/logo.png"
          type="image/png">

</head>

<body>

<?php include 'views/layouts/navbar.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<!-- CONTENIDO -->
<div class="container">

    <div class="card">

        <h1>Inventario</h1>

        <!-- BOTON -->
        <button class="btn-agregar"
                onclick="abrirModalInventario()">

            + Agregar Insumo

        </button>

        <!-- BUSCADOR -->
        <div class="buscador">

            <input type="text"
                   id="buscarInventario"
                   placeholder="Buscar insumo..."
                   onkeyup="buscarInventario()">

        </div>

        <!-- TABLA -->
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

            <?php if(!empty($inventario)): ?>

                <?php foreach($inventario as $item): ?>

                    <tr>

                        <td><?= $item['id_insumo'] ?></td>

                        <td><?= $item['nombre'] ?></td>

                        <td><?= $item['cantidad_actual'] ?></td>

                        <td><?= $item['unidad_medida'] ?></td>

                        <td><?= $item['stock_minimo'] ?></td>

                        <td><?= $item['fecha_ingreso'] ?></td>

                        <td><?= $item['fecha_caducidad'] ?></td>

                        <td><?= $item['estado'] ?></td>

                        <td>

                            <!-- EDITAR -->
                            <button onclick="abrirEditarInventario(
                                '<?= $item['id_insumo'] ?>',
                                '<?= $item['nombre'] ?>',
                                '<?= $item['cantidad_actual'] ?>',
                                '<?= $item['unidad_medida'] ?>',
                                '<?= $item['stock_minimo'] ?>',
                                '<?= $item['fecha_ingreso'] ?>',
                                '<?= $item['fecha_caducidad'] ?>',
                                '<?= $item['estado'] ?>'
                            )">

                                Editar

                            </button>

                            <!-- ELIMINAR -->
                            <a href="?menu=borrarInventario&id=<?= $item['id_insumo'] ?>"
                               onclick="return confirm('¿Eliminar insumo?')">

                                <button>

                                    Eliminar

                                </button>

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9">

                        No hay insumos registrados

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- MODAL AGREGAR -->
<div id="modalInventario" class="modal">

    <div class="modal-contenido">

        <span class="cerrar-modal"
              onclick="cerrarModalInventario()">

            &times;

        </span>

        <h2>Agregar Insumo</h2>

        <form method="POST"
              action="?menu=crearInventario">

            <input type="text"
                   name="nombre"
                   placeholder="Nombre"
                   required>

            <input type="number"
                   step="0.01"
                   name="cantidad_actual"
                   placeholder="Cantidad actual"
                   required>

            <input type="text"
                   name="unidad_medida"
                   placeholder="Unidad"
                   required>

            <input type="number"
                   step="0.01"
                   name="stock_minimo"
                   placeholder="Stock mínimo"
                   required>

            <input type="date"
                   name="fecha_ingreso"
                   required>

            <input type="date"
                   name="fecha_caducidad"
                   required>

            <select name="estado">

                <option value="Disponible">
                    Disponible
                </option>

                <option value="Por caducar">
                    Por caducar
                </option>

                <option value="Agotado">
                    Agotado
                </option>

                <option value="Inactivo">
                    Inactivo
                </option>

            </select>

            <button type="submit">

                Guardar

            </button>

        </form>

    </div>

</div>

<!-- MODAL EDITAR -->
<div id="modalEditarInventario" class="modal">

    <div class="modal-contenido">

        <span class="cerrar-modal"
              onclick="cerrarEditarInventario()">

            &times;

        </span>

        <h2>Editar Inventario</h2>

        <form method="POST"
              id="formEditarInventario">

            <input type="text"
                   name="nombre"
                   id="editNombre"
                   required>

            <input type="number"
                   step="0.01"
                   name="cantidad_actual"
                   id="editCantidad"
                   required>

            <input type="text"
                   name="unidad_medida"
                   id="editUnidad"
                   required>

            <input type="number"
                   step="0.01"
                   name="stock_minimo"
                   id="editMinimo"
                   required>

            <input type="date"
                   name="fecha_ingreso"
                   id="editIngreso"
                   required>

            <input type="date"
                   name="fecha_caducidad"
                   id="editCaducidad"
                   required>

            <select name="estado"
                    id="editEstado">

                <option value="Disponible">
                    Disponible
                </option>

                <option value="Por caducar">
                    Por caducar
                </option>

                <option value="Agotado">
                    Agotado
                </option>

                <option value="Inactivo">
                    Inactivo
                </option>

            </select>

            <button type="submit">

                Guardar Cambios

            </button>

        </form>

    </div>

</div>

<!-- JS -->
<script src="public/assets/js/sidebar.js"></script>
<script src="public/assets/js/inventario.js"></script>

</body>

</html>