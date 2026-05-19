<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (empty($_SESSION['usuario'])) {
    header("Location: ?menu=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">
    <link rel="stylesheet" href="public/assets/css/home.css">
    <link rel="icon" href="public/assets/img/logo.png" type="image/png">
</head>
<body>
    <?php include 'views/layouts/navbar.php'; ?>
    <?php include 'views/layouts/sidebar.php'; ?>

    <div style="max-width:700px; margin:40px auto; padding:20px;">

        <h1>Configuración</h1>
        <h3>Usuario</h3>
        <p style="color:#000000; margin-bottom:20px;">Editar información personal</p>

        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
            <input type="text" id="cfg-nombre" placeholder="Nombre"
                value="<?= htmlspecialchars($_SESSION['usuario']) ?>"
                style="padding:10px; border-radius:20px; border:2px solid transparent; outline:none; flex:1; min-width:140px;">
            <input type="email" id="cfg-correo" placeholder="Correo"
                style="padding:10px; border-radius:20px; border:2px solid transparent; outline:none; flex:1; min-width:140px;">
            <input type="password" id="cfg-pass" placeholder="Nueva contraseña"
                style="padding:10px; border-radius:20px; border:2px solid transparent; outline:none; flex:1; min-width:140px;">
            <button onclick="guardarCambios()"
                style="padding:10px 20px; border-radius:20px; border:none; background:#8b5a2b; color:white; cursor:pointer;">
                Guardar cambios
            </button>
        </div>

    </div>

    <!-- Modal -->
    <div id="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
         background:rgba(0,0,0,0.4); justify-content:center; align-items:center;">
        <div style="background:#d9d9d9; padding:30px; border-radius:25px; width:340px; text-align:center;">
            <div id="modalIcon" style="font-size:36px; margin-bottom:8px;"></div>
            <h3 id="modalTitulo"></h3>
            <p  id="modalMensaje"></p>
            <button onclick="cerrarModal()"
                style="padding:10px 24px; border-radius:20px; border:none; background:#8b5a2b; color:white; cursor:pointer; margin-top:10px;">
                OK
            </button>
        </div>
    </div>

    <script src="public/assets/js/sidebar.js"></script>
    <script>
    function guardarCambios() {
        const nombre = document.getElementById('cfg-nombre').value.trim();
        const correo = document.getElementById('cfg-correo').value.trim();
        const pass   = document.getElementById('cfg-pass').value.trim();

        if (!nombre) {
            mostrarModal('⚠️', 'Campo requerido', 'El nombre no puede estar vacío.');
            return;
        }

        fetch('?menu=guardar-perfil', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `nombre=${encodeURIComponent(nombre)}&correo=${encodeURIComponent(correo)}&pass=${encodeURIComponent(pass)}`
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                mostrarModal('✅', '¡Listo!', data.mensaje);
            } else {
                mostrarModal('❌', 'Error', data.mensaje);
            }
        })
        .catch(() => mostrarModal('⚠️', 'Error de red', 'No se pudo conectar con el servidor.'));
    }

    function mostrarModal(icono, titulo, mensaje) {
        document.getElementById('modalIcon').textContent    = icono;
        document.getElementById('modalTitulo').textContent  = titulo;
        document.getElementById('modalMensaje').textContent = mensaje;
        document.getElementById('modal').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modal').style.display = 'none';
    }

    document.getElementById('modal').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });
    </script>
</body>
</html>