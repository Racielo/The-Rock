<?php
$usuario = $_SESSION['usuario'] ?? null;
$rol = $_SESSION['rol'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Configuración</title>

    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">
</head>

<body>

<?php include 'views/layouts/navbar.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<div class="container">

    <div class="card">

        <h1>Configuración</h1>

        <?php if ($rol == 'admin'): ?>

            <h3>Administrador</h3>

            <p>Respaldo del sistema</p>

            <form method="POST" action="?menu=backup">

                <button type="submit">
                    Generar respaldo de base de datos
                </button>

            </form>

        <?php else: ?>

            <h3>Usuario</h3>

            <p>Editar información personal</p>

            <form method="POST" action="?menu=actualizarPerfil">

                <input type="text" name="nombre"
                       value="<?= $usuario ?>"
                       placeholder="Nombre">

                <input type="email" name="correo"
                       placeholder="Correo">

                <input type="password" name="pass"
                       placeholder="Nueva contraseña">

                <button type="submit">
                    Guardar cambios
                </button>

            </form>

        <?php endif; ?>

    </div>

</div>

</body>
</html>