<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Inventario</title>

    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">

    <link rel="icon"
          href="public/assets/img/logo.png"
          type="image/png">

</head>

<body>

    <!-- BOTON MENU -->

    <button class="btn-menu"
            onclick="abrirPanel()">

        ☰

    </button>

    <!-- SIDEBAR -->

    <?php include 'views/layouts/sidebar.php'; ?>

    <!-- CONTENIDO -->

    <div class="container">

        <div class="card">

            <h1>Inventario de Materia Prima</h1>

            <!-- BOTON AGREGAR -->

            <button class="btn-agregar"
                    onclick="abrirModalInventario()">

                + Agregar Ingrediente

            </button>

            <!-- BUSCADOR -->

            <div class="buscador">

                <input type="text"
                       id="buscarInventario"
                       placeholder="Buscar por nombre, categoría o unidad..."
                       onkeyup="buscarInventario()">

            </div>

            <!-- TABLA -->

            <table id="tablaInventario">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Unidad</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Costo</th>
                        <th>Caducidad</th>
                        <th>Estado</th>
                        <th>Alerta</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($inventario as $p): ?>

                    <?php

                        if ($p['stock_actual'] <= $p['stock_minimo']) {

                            $color = "red";
                            $mensaje = "Bajo";

                        }

                        elseif ($p['stock_actual'] <= ($p['stock_minimo'] * 2)) {

                            $color = "orange";
                            $mensaje = "Medio";

                        }

                        else {

                            $color = "green";
                            $mensaje = "Correcto";
                        }

                    ?>

                    <tr>

                        <td><?= $p['id_inventario'] ?></td>

                        <td><?= $p['nombre'] ?></td>

                        <td><?= $p['categoria'] ?></td>

                        <td><?= $p['unidad_medida'] ?></td>

                        <td><?= $p['stock_actual'] ?></td>

                        <td><?= $p['stock_minimo'] ?></td>

                        <td>$<?= $p['costo_unitario'] ?></td>

                        <td><?= $p['fecha_caducidad'] ?></td>

                        <td><?= $p['estado'] ?></td>

                        <td style="color: <?= $color ?>">

                            <?= $mensaje ?>

                        </td>

                        <td>

                            <!-- EDITAR -->

                            <button onclick="abrirEditarInventario(

                                '<?= $p['id_inventario'] ?>',
                                '<?= $p['nombre'] ?>',
                                '<?= $p['categoria'] ?>',
                                '<?= $p['unidad_medida'] ?>',
                                '<?= $p['stock_actual'] ?>',
                                '<?= $p['stock_minimo'] ?>',
                                '<?= $p['costo_unitario'] ?>',
                                '<?= $p['fecha_caducidad'] ?>',
                                '<?= $p['estado'] ?>'

                            )">

                                Editar

                            </button>

                            <!-- ELIMINAR -->

                            <a href="?menu=borrarInventario&id=<?= $p['id_inventario'] ?>"
                               onclick="return confirm('¿Eliminar registro?')">

                                <button>

                                    Eliminar

                                </button>

                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- MODAL AGREGAR -->

    <div id="modalAgregarInventario"
         class="modal">

        <div class="modal-contenido">

            <span class="cerrar-modal"
                  onclick="cerrarModalInventario()">

                &times;

            </span>

            <h2>Agregar Ingrediente</h2>

            <form method="POST"
                  action="?menu=crearInventario">

                <input type="text"
                       name="nombre"
                       placeholder="Nombre"
                       required>

                <input type="text"
                       name="categoria"
                       placeholder="Categoría"
                       required>

                <input type="text"
                       name="unidad"
                       placeholder="Unidad de medida"
                       required>

                <input type="number"
                       step="0.01"
                       name="stock_actual"
                       placeholder="Stock actual"
                       required>

                <input type="number"
                       step="0.01"
                       name="stock_minimo"
                       placeholder="Stock mínimo"
                       required>

                <input type="number"
                       step="0.01"
                       name="costo"
                       placeholder="Costo unitario"
                       required>

                <input type="date"
                       name="fecha"
                       required>

                <button type="submit">

                    Guardar

                </button>

            </form>

        </div>

    </div>

    <!-- MODAL EDITAR -->

    <div id="modalInventario"
         class="modal">

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

                <input type="text"
                       name="categoria"
                       id="editCategoria"
                       required>

                <input type="text"
                       name="unidad"
                       id="editUnidad"
                       required>

                <input type="number"
                       step="0.01"
                       name="stock_actual"
                       id="editStockActual"
                       required>

                <input type="number"
                       step="0.01"
                       name="stock_minimo"
                       id="editStockMinimo"
                       required>

                <input type="number"
                       step="0.01"
                       name="costo"
                       id="editCosto"
                       required>

                <input type="date"
                       name="fecha"
                       id="editFecha"
                       required>

                <select name="estado"
                        id="editEstado">

                    <option value="activo">
                        Activo
                    </option>

                    <option value="inactivo">
                        Inactivo
                    </option>

                </select>

                <button type="submit">

                    Guardar Cambios

                </button>

            </form>

        </div>

    </div>

    <!-- SCRIPTS -->

    <script src="public/assets/js/sidebar.js"></script>

    <script src="public/assets/js/inventario.js"></script>

</body>

</html>