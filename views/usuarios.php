<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios</title>
<link rel="stylesheet" href="assets/css/fondo.css">
<link rel="stylesheet" href="public/assets/css/usuarios.css">
</head>

<body>

<a href="public/?controller=home&action=index">
    <button>Volver</button>
</a>

<div class="container">
<div class="card">

<h1>Usuarios</h1>

<div class="form">
    <input type="text" id="nombre" placeholder="Nombre">
    <input type="email" id="correo" placeholder="Correo">
    <select id="estado">
        <option>Activo</option>
        <option>Inactivo</option>
    </select>
    <button onclick="agregarUsuario()">Agregar</button>
</div>

<table>
<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Correo</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>
<tbody id="tablaUsuarios"></tbody>
</table>

</div>
</div>

<script src="public/assets/js/usuarios.js"></script>
</body>
</html>