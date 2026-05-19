<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Productos</title>

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

        <h1>Productos</h1>

        <!-- BOTON AGREGAR -->
        <button class="btn-agregar"
                onclick="abrirModalProducto()">

            + Agregar Producto

        </button>

        <!-- TABLA -->
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

                <?php if(!empty($productos)): ?>

                    <?php foreach($productos as $producto): ?>

                        <tr>

                            <td><?= $producto['id_producto'] ?></td>

                            <td><?= $producto['nombre_producto'] ?></td>

                            <td><?= $producto['descripcion'] ?></td>

                            <td>$<?= $producto['precio_venta'] ?></td>

                            <td><?= $producto['categoria'] ?></td>

                            <td><?= $producto['dias_vida_util'] ?> días</td>

                            <td><?= $producto['estado_producto'] ?></td>

                            <td>

                                <!-- EDITAR -->
                                <button onclick="abrirEditarProducto(
                                    '<?= $producto['id_producto'] ?>',
                                    '<?= $producto['nombre_producto'] ?>',
                                    '<?= $producto['descripcion'] ?>',
                                    '<?= $producto['precio_venta'] ?>',
                                    '<?= $producto['categoria'] ?>',
                                    '<?= $producto['fecha_elaboracion'] ?>',
                                    '<?= $producto['dias_vida_util'] ?>',
                                    '<?= $producto['imagen_url'] ?>',
                                    '<?= $producto['estado_producto'] ?>'
                                )">

                                    Editar

                                </button>

                                <!-- ELIMINAR -->
                                <a href="?menu=borrarProducto&id=<?= $producto['id_producto'] ?>"
                                   onclick="return confirm('¿Eliminar producto?')">

                                    <button>

                                        Eliminar

                                    </button>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="8">

                            No hay productos registrados

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- MODAL AGREGAR -->
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
                   name="nombre_producto"
                   placeholder="Nombre del producto"
                   required>

            <textarea name="descripcion"
                      placeholder="Descripción"
                      required></textarea>

            <input type="number"
                   step="0.01"
                   name="precio_venta"
                   placeholder="Precio"
                   required>

            <input type="text"
                   name="categoria"
                   placeholder="Categoría"
                   required>

            <input type="datetime-local"
                   name="fecha_elaboracion"
                   required>

            <input type="number"
                   name="dias_vida_util"
                   placeholder="Días de vida útil"
                   required>

            <input type="text"
                   name="imagen_url"
                   placeholder="Ruta de imagen">

            <select name="estado_producto">

                <option value="Activo">
                    Activo
                </option>

                <option value="Inactivo">
                    Inactivo
                </option>

                <option value="Temporada">
                    Temporada
                </option>

            </select>

            <button type="submit">

                Guardar

            </button>

        </form>

    </div>

</div>

<!-- MODAL EDITAR -->
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
                   name="nombre_producto"
                   id="editNombreProducto"
                   required>

            <textarea name="descripcion"
                      id="editDescripcion"
                      required></textarea>

            <input type="number"
                   step="0.01"
                   name="precio_venta"
                   id="editPrecio"
                   required>

            <input type="text"
                   name="categoria"
                   id="editCategoria"
                   required>

            <input type="datetime-local"
                   name="fecha_elaboracion"
                   id="editFecha"
                   required>

            <input type="number"
                   name="dias_vida_util"
                   id="editVida"
                   required>

            <input type="text"
                   name="imagen_url"
                   id="editImagen">

            <select name="estado_producto"
                    id="editEstadoProducto">

                <option value="Activo">
                    Activo
                </option>

                <option value="Inactivo">
                    Inactivo
                </option>

                <option value="Temporada">
                    Temporada
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
<script src="public/assets/js/productos.js"></script>

</body>

</html>