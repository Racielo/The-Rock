<?php
session_start();

require_once 'config/database.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/ProductoController.php';

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
}
elseif ($menu == 'logout') {

    session_start();

    session_destroy();

    header("Location: ?menu=home");

    exit;}
     

/* =========================
   PRODUCTOS
========================= */
elseif ($menu == 'productos') {

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

} 
else {

    include 'views/home.php';
}
?>