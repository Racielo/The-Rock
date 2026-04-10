<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="assets/css/fondo.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/auth.css">
</head>

<body>

<div class="contenedor">
<div class="card">

<div class="izquierda">
    <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo">
    <h3>Iniciar Sesión</h3>
</div>

<div class="derecha">

<div class="input-group">
    <input type="text" id="correo" placeholder="Correo">
    <div id="errorCorreo" class="error-text"></div>
</div>

<div class="input-group">
    <input type="password" id="password" placeholder="Contraseña">
    <div id="errorPassword" class="error-text"></div>
</div>

<button onclick="login()">Entrar</button>

<p>
¿No tienes cuenta?
<a href="<?= BASE_URL ?>?controller=auth&action=registro">Regístrate</a>
</p>

</div>
</div>
</div>

<div class="modal" id="modal">
<div class="modal-content">
    <div id="modalIcon"></div>
    <h3 id="modalTitulo"></h3>
    <p id="modalMensaje"></p>
    <button onclick="cerrarModal()">OK</button>
</div>
</div>

<script src="<?= BASE_URL ?>assets/js/auth.js"></script>
</body>
</html>