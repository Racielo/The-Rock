<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/auth.css">
</head>

<body>

<div class="contenedor">
<div class="card">

<div class="izquierda">
    <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo">
    <h3>Crear Cuenta</h3>
</div>

<div class="derecha">

<input type="text" id="nombre" placeholder="Nombre">
<input type="text" id="correo" placeholder="Correo">
<input type="password" id="password" placeholder="Contraseña">
<input type="password" id="confirmar" placeholder="Confirmar">

<button onclick="registrar()">Registrar</button>

<p>
¿Ya tienes cuenta?
<a href="<?= BASE_URL ?>?controller=auth&action=login">Inicia sesión</a>
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