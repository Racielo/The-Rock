<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
</head>

<body>

    <a href="?menu=home">
        <button>Volver</button>
    </a>
    <a href="?menu=productos">
    <button>Ir a Productos</button>
</a>

    <div class="container">
        <div class="card">

            <h1>Usuarios</h1>

            <div class="form">
                <form method="POST" action="?menu=crear">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="email" name="correo" placeholder="Correo" required>
                    <input type="password" name="pass" placeholder="Contraseña" required>

                    <select name="estado">
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>

                    <button type="submit">Agregar</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
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
                                <td>
                                    <a href="?menu=editar&id=<?= $user['id'] ?>">
                                        <button>Editar</button>
                                    </a>

                                    <a href="?menu=borrar&id=<?= $user['id'] ?>" onclick="return confirm('¿Eliminar usuario?')">
                                        <button>Eliminar</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No hay usuarios registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</body>

</html>