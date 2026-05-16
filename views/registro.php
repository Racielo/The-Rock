<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/auth.css">
        <link rel="icon" href="public/assets/img/logo.png" type="image/png">

</head>

<body>

    <div class="contenedor">
        <div class="card">

            <div class="izquierda">
                <img src="public/assets/img/logo.png" class="logo">
                <h3>Crear Cuenta</h3>
            </div>

            <div class="derecha">

                <input type="text" id="nombre" placeholder="Nombre"><br>
                <input type="text" id="correo" placeholder="Correo"><br>
                <input type="password" id="password" placeholder="Contraseña"><br>
                <input type="password" id="confirmar" placeholder="Confirmar"><br>

                <button onclick="registrar()">Registrar</button>

                <p>
                    ¿Ya tienes cuenta?
                    <a href="?menu=home">
                        <button>Volver</button>
                    </a>
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

    <script src="public/assets/js/usuarios.js"></script>
</body>

</html>