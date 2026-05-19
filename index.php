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

    (new UsuarioController($conexion))->index();

} elseif ($menu == 'verificar') {

    (new UsuarioController($conexion))->verificar();

} elseif ($menu == 'crear') {

    (new UsuarioController($conexion))->crear();

} elseif ($menu == 'borrar') {

    (new UsuarioController($conexion))->borrar($_GET['id']);

} elseif ($menu == 'editar') {

    (new UsuarioController($conexion))->editar($_GET['id']);

} elseif ($menu == 'logout') {

    session_destroy();
    header("Location: ?menu=home");
    exit;
}

/* =========================
   PRODUCTOS
========================= */

elseif ($menu == 'productos') {

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    (new ProductoController($conexion))->index();

} elseif ($menu == 'crearProducto') {

    (new ProductoController($conexion))->crear();

} elseif ($menu == 'borrarProducto') {

    (new ProductoController($conexion))->borrar($_GET['id']);

} elseif ($menu == 'editarProducto') {

    (new ProductoController($conexion))->editar($_GET['id']);
}

/* =========================
   INVENTARIO
========================= */

elseif ($menu == 'inventario') {

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    (new InventarioController($conexion))->index();

} elseif ($menu == 'crearInventario') {

    (new InventarioController($conexion))->crear();

} elseif ($menu == 'borrarInventario') {

    (new InventarioController($conexion))->borrar($_GET['id']);

} elseif ($menu == 'editarInventario') {

    (new InventarioController($conexion))->editar($_GET['id']);
}

/* =========================
   CONFIGURACION USUARIO
========================= */

elseif ($menu == 'configuracion') {

    if (!isset($_SESSION['usuario'])) {
        header("Location: ?menu=login");
        exit;
    }

    include 'views/configuracion.php';

} elseif ($menu == 'actualizarPerfil') {

    if (!isset($_SESSION['usuario'])) {
        header("Location: ?menu=login");
        exit;
    }

    $sql = "UPDATE usuarios SET nombre=?, correo=?, pass=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        $_POST['nombre'],
        $_POST['correo'],
        $_POST['pass'],
        $_SESSION['id']
    ]);

    $_SESSION['usuario'] = $_POST['nombre'];

    header("Location: ?menu=configuracion");
    exit;
}

/* =========================
   BACKUP / BD
========================= */

elseif ($menu == 'backup') {

    if ($_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    $archivo = "backup_" . date("Ymd_His") . ".sql";
    system("mysqldump -u root therock > backups/$archivo");

    header("Location: ?menu=configuracion");
    exit;

} elseif ($menu == 'exportar-bd') {

    require 'controllers/exportar_bd.php';

} elseif ($menu == 'restaurar-bd') {

    require 'controllers/restaurar_bd.php';

} elseif ($menu == 'restaurar') {

    include 'views/restaurar.php';
}

/* =========================
   EXTRA (TU COMPA)
========================= */

elseif ($menu == 'recuperar') {

    include 'views/recuperar.php';
}

/* =========================
   HOME
========================= */

else {

    include 'views/home.php';
}
?>