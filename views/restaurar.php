<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restaurar Base de Datos</title>
    <link rel="stylesheet" href="public/assets/css/fondo.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/sidebar.css">
    <link rel="stylesheet" href="public/assets/css/usuarios.css">
    <link rel="icon" href="public/assets/img/logo.png" type="image/png">
    <style>
        .restaurar-card {
            max-width: 700px;
            margin: 0 auto 30px auto;
        }

        .restaurar-titulo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            color: #8b5a2b;
        }

        .restaurar-titulo h1 {
            font-size: 1.6rem;
            margin: 0;
            text-align: left;
        }

        .restaurar-titulo img {
            width: 36px;
            height: 36px;
        }

        .campo-label {
            font-size: 0.85rem;
            font-weight: bold;
            color: #555;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-archivo {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 0.95rem;
            box-sizing: border-box;
        }

        .btn-restaurar {
            margin-top: 16px;
            width: 100%;
            padding: 13px;
            background: #8b5a2b;
            color: white;
            font-size: 0.95rem;
            font-weight: bold;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-restaurar:hover {
            background: #6e4420;
        }

        .btn-restaurar:disabled {
            background: #bbb;
            cursor: not-allowed;
        }

        .alerta {
            margin-top: 16px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.92rem;
            display: none;
        }

        .alerta.exito {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alerta.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* HISTORIAL */
        .historial-card {
            max-width: 700px;
            margin: 0 auto;
        }

        .historial-titulo {
            font-size: 1.1rem;
            color: #8b5a2b;
            font-weight: bold;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .historial-vacio {
            text-align: center;
            color: #999;
            padding: 20px;
            font-style: italic;
        }

        #tablaHistorial th {
            background: #8b5a2b;
            color: white;
        }

        #tablaHistorial td {
            font-size: 0.9rem;
        }

        .badge-fecha {
            background: #f3e3d3;
            color: #8b5a2b;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.82rem;
        }
    </style>
</head>

<body>

    <?php include 'views/layouts/navbar.php'; ?>
    <?php include 'views/layouts/sidebar.php'; ?>

    <div class="container">

        <!-- TARJETA RESTAURAR -->
        <div class="card restaurar-card">

            <div class="restaurar-titulo">
                <img src="public/assets/img/big-gear-admin.png" alt="restaurar">
                <h1>Restaurar Base de Datos</h1>
            </div>

            <div class="campo-label">Archivo SQL</div>
            <input
                type="file"
                id="archivoSQL"
                accept=".sql"
                class="input-archivo"
            >

            <button class="btn-restaurar" id="btnRestaurar" onclick="restaurarBD()">
                Restaurar Base de Datos
            </button>

            <div class="alerta" id="alerta"></div>

        </div>

        <!-- TARJETA HISTORIAL -->
        <div class="card historial-card">

            <div class="historial-titulo">
                📋 Historial de Restauraciones
            </div>

            <div id="contenidoHistorial">
                <p class="historial-vacio">Cargando historial...</p>
            </div>

        </div>

    </div>

    <?php include 'views/layouts/sidebar.php'; ?>

    <script src="public/assets/js/sidebar.js"></script>
    <script>
        // ── Restaurar ──────────────────────────────
        function restaurarBD() {
            const input  = document.getElementById('archivoSQL');
            const alerta = document.getElementById('alerta');
            const btn    = document.getElementById('btnRestaurar');

            alerta.style.display = 'none';

            if (!input.files || !input.files[0]) {
                mostrarAlerta('Por favor selecciona un archivo .sql', 'error');
                return;
            }

            const archivo = input.files[0];
            if (!archivo.name.endsWith('.sql')) {
                mostrarAlerta('Solo se permiten archivos con extensión .sql', 'error');
                return;
            }

            if (!confirm('¿Estás seguro de restaurar la base de datos? Esta acción reemplazará los datos actuales.')) {
                return;
            }

            btn.disabled    = true;
            btn.textContent = 'Restaurando...';

            const formData = new FormData();
            formData.append('archivo_sql', archivo);

            fetch('?menu=restaurar-bd', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('✅ ' + data.mensaje, 'exito');
                    input.value = '';
                    cargarHistorial();
                } else {
                    mostrarAlerta('❌ ' + data.mensaje, 'error');
                }
            })
            .catch(() => mostrarAlerta('❌ Error de conexión con el servidor.', 'error'))
            .finally(() => {
                btn.disabled    = false;
                btn.textContent = 'Restaurar Base de Datos';
            });
        }

        function mostrarAlerta(msg, tipo) {
            const alerta = document.getElementById('alerta');
            alerta.textContent    = msg;
            alerta.className      = 'alerta ' + tipo;
            alerta.style.display  = 'block';
        }

        // ── Historial ──────────────────────────────
        function cargarHistorial() {
            fetch('?menu=restaurar-bd&historial=1')
            .then(r => r.json())
            .then(data => renderHistorial(data))
            .catch(() => {
                document.getElementById('contenidoHistorial').innerHTML =
                    '<p class="historial-vacio">No se pudo cargar el historial.</p>';
            });
        }

        function renderHistorial(data) {
            const cont = document.getElementById('contenidoHistorial');

            if (!data || data.length === 0) {
                cont.innerHTML = '<p class="historial-vacio">Aún no hay restauraciones registradas.</p>';
                return;
            }

            const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                           'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

            let html = `
                <table id="tablaHistorial">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Día</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Hora</th>
                            <th>Archivo</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.forEach((item, i) => {
                const mes = meses[(parseInt(item.mes) - 1)] || item.mes;
                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td><span class="badge-fecha">${item.dia}</span></td>
                        <td>${mes}</td>
                        <td>${item.anio}</td>
                        <td>${item.hora}</td>
                        <td style="font-size:0.8rem; color:#666;">${item.archivo}</td>
                        <td>${item.usuario}</td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            cont.innerHTML = html;
        }

        // Cargar historial al entrar
        cargarHistorial();
    </script>

</body>
</html>