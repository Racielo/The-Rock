<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Inventario</title>

    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">

</head>

<body>

    <!-- BOTON MENU -->
    <button class="btn-menu" onclick="abrirPanel()">
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
                    onclick="abrirModalProducto()">

                + Agregar Producto

            </button>

            <!-- BUSCADOR -->
            <div class="buscador">

                <input type="text"
                       id="buscarProducto"
                       placeholder="Buscar por ID, ingrediente o unidad..."
                       onkeyup="buscarProductos()">

            </div>

            <!-- TABLA -->
            <table id="tablaProductos">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Ingrediente</th>
                        <th>Cantidad</th>
                        <th>Máximo</th>
                        <th>Unidad</th>
                        <th>% Stock</th>
                        <th>Caducidad</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($productos as $p):

                        $porcentaje =
                        ($p['cantidad_actual'] /
                        $p['cantidad_maxima']) * 100;

                    ?>

                    <tr>

                        <td><?= $p['id'] ?></td>

                        <td><?= $p['ingrediente'] ?></td>

                        <td><?= $p['cantidad_actual'] ?></td>

                        <td><?= $p['cantidad_maxima'] ?></td>

                        <td><?= $p['unidad_medida'] ?></td>

                        <td style="
                            color:
                            <?= $porcentaje < 30
                            ? 'red'
                            : ($porcentaje < 60
                            ? 'orange'
                            : 'green') ?>
                        ">

                            <?= round($porcentaje) ?>%

                        </td>

                        <td><?= $p['fecha'] ?></td>

                        <td>

                            <!-- EDITAR -->
                            <button onclick="abrirEditarProducto(
                                '<?= $p['id'] ?>',
                                '<?= $p['ingrediente'] ?>',
                                '<?= $p['cantidad_actual'] ?>',
                                '<?= $p['cantidad_maxima'] ?>',
                                '<?= $p['unidad_medida'] ?>',
                                '<?= $p['fecha'] ?>'
                            )">

                                Editar

                            </button>

                            <!-- ELIMINAR -->
                            <a href="?menu=borrarProducto&id=<?= $p['id'] ?>"
                               onclick="return confirm('¿Eliminar producto?')">

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

    <!-- MODAL AGREGAR PRODUCTO -->
    <div id="modalAgregarProducto" class="modal">

        <div class="modal-contenido">

            <span class="cerrar-modal"
                  onclick="cerrarModalProducto()">

                &times;

            </span>

            <h2>Agregar Producto</h2>

            <form method="POST"
                  action="?menu=crearProducto">

                <input type="text"
                       name="ingrediente"
                       placeholder="Ingrediente"
                       required>

                <input type="number"
                       name="cantidad"
                       placeholder="Cantidad actual"
                       required>

                <input type="number"
                       name="maximo"
                       placeholder="Cantidad máxima"
                       required>

                <input type="text"
                       name="unidad"
                       placeholder="Unidad"
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

    <!-- MODAL EDITAR PRODUCTO -->
    <div id="modalProducto" class="modal">

        <div class="modal-contenido">

            <span class="cerrar-modal"
                  onclick="cerrarEditarProducto()">

                &times;

            </span>

            <h2>Editar Producto</h2>

            <form method="POST"
                  id="formEditarProducto">

                <input type="text"
                       name="ingrediente"
                       id="editIngrediente"
                       required>

                <input type="number"
                       name="cantidad"
                       id="editCantidad"
                       required>

                <input type="number"
                       name="maximo"
                       id="editMaximo"
                       required>

                <input type="text"
                       name="unidad"
                       id="editUnidad"
                       required>

                <input type="date"
                       name="fecha"
                       id="editFecha"
                       required>

                <button type="submit">
                    Guardar Cambios
                </button>

            </form>

        </div>

    </div>

    <!-- SIDEBAR -->
    <script src="public/assets/js/sidebar.js"></script>
        <script src="public/assets/js/productos.js"></script>


</body>

</html>