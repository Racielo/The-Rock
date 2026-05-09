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
    <div id="sidebar" class="sidebar">

        <button class="cerrar" onclick="cerrarPanel()">
            ✖
        </button>

        <h2>The Rock</h2>

        <ul>
            <li><a href="?menu=home">Inicio</a></li>
            <li><a href="?menu=usuarios">Usuarios</a></li>
            <li><a href="?menu=productos">Productos</a></li>
            <li><a href="?menu=inventario">Inventario</a></li>
            <li><a href="?menu=ventas">Ventas</a></li>
            <li><a href="?menu=reportes">Reportes</a></li>
        </ul>

    </div>

    <!-- CONTENIDO -->
    <div class="container">

        <div class="card">

            <h1>Inventario de Materia Prima</h1>

            <form method="POST" action="?menu=crearProducto">

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
                       placeholder="Unidad (kg, l, piezas)"
                       required>

                <input type="date"
                       name="fecha"
                       required>

                <button type="submit">
                    Agregar
                </button>

            </form>

            <table>

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

                            <a href="?menu=editarProducto&id=<?= $p['id'] ?>">
                                <button>
                                    Editar
                                </button>
                            </a>

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

    <script src="public/assets/js/sidebar.js"></script>

</body>
</html>