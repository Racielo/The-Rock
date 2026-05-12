<!DOCTYPE html>
<html lang = "es">

<head>

    <meta charset = "UTF-8">

    <title>Usuarios</title>

    <link rel = "stylesheet" href="public/assets/css/fondo.css">
    <link rel = "stylesheet" href="public/assets/css/usuarios.css">
    <link rel = "stylesheet" href="public/assets/css/sidebar.css">

</head>

<body>

    <!-- BOTON MENU -->
    <button class = "btn-menu" onclick="abrirPanel()">
        ☰
    </button>

    <!-- SIDEBAR -->
<?php include 'views/layouts/sidebar.php'; ?>

    <!-- CONTENIDO -->
    <div class = "container">

        <div class = "card">

            <h1>Usuarios</h1>

            <!-- BOTON AGREGAR -->
            <button class   = "btn-agregar"
                    onclick = "abrirModal()">

                + Agregar Usuario

            </button>

            <!-- BUSCADOR -->
            <div class = "buscador">

                <input type        = "text"
                       id          = "buscarUsuario"
                       placeholder = "Buscar por ID, nombre o correo..."
                       onkeyup     = "buscarUsuarios()">

            </div>

            <!-- TABLA -->
            <table id = "tablaUsuarios">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($usuarios)): ?>

                        <?php foreach ($usuarios as $user): ?>

                            <tr>

                                <td><?= $user['id'] ?></td>

                                <td><?= $user['nombre'] ?></td>

                                <td><?= $user['correo'] ?></td>

                                <td><?= $user['estado'] ?></td>

                                <td>

                                    <!-- EDITAR -->
                                    <button onclick = "abrirEditar(
                                        '<?= $user['id']; ?>',
                                        '<?= $user['nombre'] ?>',
                                        '<?= $user['correo'] ?>',
                                        '<?= $user['estado'] ?>'
                                    )">

                                        Editar

                                    </button>

                                    <!-- ELIMINAR -->
                                    <a href    = "?menu=borrar&id=<?= $user['id'] ?>"
                                       onclick = "return confirm('¿Eliminar usuario?')">

                                        <button>
                                            Eliminar
                                        </button>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan = "5">
                                No hay usuarios registrados
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- MODAL AGREGAR -->
    <div id = "modalUsuario" class="modal">

        <div class = "modal-contenido">

            <span class   = "cerrar-modal"
                  onclick = "cerrarModal()">

                &times;

            </span>

            <h2>Agregar Usuario</h2>

            <form method = "POST"
                  action = "?menu=crear">

                <input type        = "text"
                       name        = "nombre"
                       placeholder = "Nombre"
                       required>

                <input type        = "email"
                       name        = "correo"
                       placeholder = "Correo"
                       required>

                <input type        = "password"
                       name        = "pass"
                       placeholder = "Contraseña"
                       required>

                <button type = "submit">
                    Guardar
                </button>

            </form>

        </div>

    </div>

    <!-- MODAL EDITAR -->
    <div id = "modalEditar" class="modal">

        <div class = "modal-contenido">

            <span class   = "cerrar-modal"
                  onclick = "cerrarEditar()">

                &times;

            </span>

            <h2>Editar Usuario</h2>

            <form method = "POST"
                  id     = "formEditar">

                <input type = "text"
                       name = "nombre"
                       id   = "editNombre"
                       required>

                <input type = "email"
                       name = "email"
                       id   = "editCorreo"
                       required>

                <select name = "estado"
                        id   = "editEstado">

                    <option value = "Activo">
                        Activo
                    </option>

                    <option value = "Inactivo">
                        Inactivo
                    </option>

                </select>

                <button type = "submit">
                    Guardar Cambios
                </button>

            </form>

        </div>

    </div>

    <!-- JS SIDEBAR -->
    <script src = "public/assets/js/sidebar.js"></script>
    <script src="public/assets/js/usuarios.js"></script>
</body>

</html>