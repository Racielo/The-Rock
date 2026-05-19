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
}

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

/* =========================
   INVENTARIO
========================= */

elseif ($menu == 'inventario') {

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
}

/* =========================
   CONFIGURACION ADMIN
========================= */

elseif ($menu == 'backup') {

    if ($_SESSION['rol'] != 'admin') {
        header("Location: ?menu=home");
        exit;
    }

    $archivo = "backup_" . date("Ymd_His") . ".sql";

    $comando = "mysqldump -u root therock > backups/$archivo";

    system($comando);

    header("Location: ?menu=configuracion");
    exit;
}
/* =========================
ACTUALIZAR PERFIL (USUARIO)
========================= */
elseif ($menu == 'actualizarPerfil') {

    if (!isset($_SESSION['usuario'])) {
        header("Location: ?menu=login");
        exit;
    }

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];

    $id = $_SESSION['id'];

    $sql = "UPDATE usuarios SET nombre=?, correo=?, pass=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $correo, $pass, $id]);

    $_SESSION['usuario'] = $nombre;

    header("Location: ?menu=configuracion");
    exit;
}

/* =========================
   HOME
========================= */

else {

    include 'views/home.php';
}
?>