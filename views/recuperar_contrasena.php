<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/auth.css">
    <link rel="icon" href="public/assets/img/logo.png" type="image/png">
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <div class="izquierda">
                <img src="public/assets/img/logo.png" class="logo">
                <h3>Recuperar Contraseña</h3>
            </div>
            <div class="derecha">
                <p style="margin-bottom:16px; color:#555; font-size:14px;">
                    Ingresa tu correo para solocitar recuperacion de contraseña.
                </p>
                <div class="input-group">
                    <img src="public/assets/img/correo.png" alt="icono-correo" width="20px">
                    <input type="text" id="correo" name="correo" placeholder="Correo electrónico">
                    <div id="errorCorreo" class="error-text"></div>
                </div>
                <button type="button" onclick="recuperarContrasena()">Enviar</button>
                <p style="margin-top:16px;">
                    ¿recuerdas tu contraseña? <a href="?menu=login">Inicia sesión</a><br>
                    <a href="?menu=login">← Regresar</a>
                </p>
            </div>
        </div>
    </div>
    <div class="modal" id="modal">
        <div class="modal-content">
            <div id="modalIcon" class="icono"></div>
            <h3 id="modalTitulo"></h3>
            <p id="modalMensaje"></p>
            <button onclick="cerrarModal()">OK</button>
        </div>
    </div>
    <script src="public/assets/js/recuperar.js"></script>
</body>
</html>