<?php
session_start();

require_once 'config/database.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/ProductoController.php';
require_once 'controllers/InventarioController.php';

$menu = $_GET['menu'] ?? 'home';

$db = new Database();
$conexion = $db->getConnection();

/* =========================
   USUARIOS
========================= */

if ($menu == 'login') {

    include 'views/login.php';

} elseif ($menu == 'registro') {

    include 'views/registro.php';

} elseif ($menu == 'usuarios') {

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    $usuarios = new UsuarioController($conexion);
    $usuarios->index();

} elseif ($menu == 'verificar') {

    $usuarios = new UsuarioController($conexion);
    $usuarios->verificar();

} elseif ($menu == 'crear') {

    $usuarios = new UsuarioController($conexion);
    $usuarios->crear();

} elseif ($menu == 'borrar') {

    $usuarios = new UsuarioController($conexion);
    $usuarios->borrar($_GET['id']);

} elseif ($menu == 'editar') {

    $usuarios = new UsuarioController($conexion);
    $usuarios->editar($_GET['id']);

} elseif ($menu == 'logout') {

    session_destroy();
    header("Location: ?menu=home");
    exit;

/* =========================
   PRODUCTOS
========================= */

} elseif ($menu == 'productos') {

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    $productos = new ProductoController($conexion);
    $productos->index();

} elseif ($menu == 'crearProducto') {

    $productos = new ProductoController($conexion);
    $productos->crear();

} elseif ($menu == 'borrarProducto') {

    $productos = new ProductoController($conexion);
    $productos->borrar($_GET['id']);

} elseif ($menu == 'editarProducto') {

    $productos = new ProductoController($conexion);
    $productos->editar($_GET['id']);

/* =========================
   INVENTARIO
========================= */

} elseif ($menu == 'inventario') {

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    $inventario = new InventarioController($conexion);
    $inventario->index();

} elseif ($menu == 'crearInventario') {

    $inventario = new InventarioController($conexion);
    $inventario->crear();

} elseif ($menu == 'borrarInventario') {

    $inventario = new InventarioController($conexion);
    $inventario->borrar($_GET['id']);

} elseif ($menu == 'editarInventario') {

    $inventario = new InventarioController($conexion);
    $inventario->editar($_GET['id']);

/* =========================
   RECUPERAR / RESTAURAR
========================= */

} elseif ($menu == 'recuperar') {

    include 'views/recuperar_contrasena.php';

} elseif ($menu == 'enviar-recuperacion') {

    header('Content-Type: application/json');

    $correo = trim($_POST['correo'] ?? '');

    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'mensaje' => 'Correo inválido.']);
        exit;
    }

    $usuarios = new UsuarioController($conexion);
    $usuario  = $usuarios->buscarPorCorreo($correo);

    if ($usuario) {
        echo json_encode([
            'success' => true,
            'mensaje' => 'Tu contraseña es: ' . $usuario['pass']
        ]);
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'No encontramos ninguna cuenta con ese correo.']);
    }
    exit;

} elseif ($menu == 'exportar-bd') {

    require 'controllers/exportar_bd.php';

} elseif ($menu == 'restaurar-bd') {

    require 'controllers/restaurar_bd.php';

} elseif ($menu == 'restaurar') {

    include 'views/restaurar.php';

/* =========================
   CONFIGURACION
========================= */

} elseif ($menu == 'configuracion') {

    include 'views/configuracion.php';

} elseif ($menu == 'guardar-perfil') {

    header('Content-Type: application/json');

    if (empty($_SESSION['usuario'])) {
        echo json_encode(['success' => false, 'mensaje' => 'No has iniciado sesión.']);
        exit;
    }

    $nombre       = trim($_POST['nombre'] ?? '');
    $correo       = trim($_POST['correo'] ?? '');
    $pass         = trim($_POST['pass']   ?? '');
    $nombreActual = $_SESSION['usuario'];

    if (empty($nombre)) {
        echo json_encode(['success' => false, 'mensaje' => 'El nombre no puede estar vacío.']);
        exit;
    }

    $usuarios = new UsuarioController($conexion);
    $ok = $usuarios->actualizarPerfil($nombre, $correo, $pass, $nombreActual);

    if ($ok) {
        $_SESSION['usuario'] = $nombre;
        echo json_encode(['success' => true, 'mensaje' => 'Datos actualizados correctamente.']);
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'No se pudo actualizar.']);
    }
    exit;

} else {

    include 'views/home.php';

}
?>