<?php
/*
require_once 'controllers/UsuarioController.php';
require_once 'config/database.php';

$menu= $_GET['menu'];

$db=new Database();
$conexion=$db->getConnection();

if ($menu=='login'){
    include 'views/login.php';
}
elseif($menu=='home'){
    include 'views/home.php';
}
elseif($menu=='usuarios'){
    $usuarios=new UsuarioController($conexion);
    $usuarios->index();
}
*/

require_once 'controllers/UsuarioController.php';
require_once 'config/database.php';

$menu = $_GET['menu'] ?? 'home';

$db = new Database();
$conexion = $db->getConnection();

if ($menu == 'login') {

    include 'views/login.php';

} elseif ($menu == 'registro') {

    include 'views/registro.php';

} elseif ($menu == 'usuarios') {

    $usuarios = new UsuarioController($conexion);
    $usuarios->index();

} elseif ($menu == 'verificar'){
    $usuarios = new UsuarioController($conexion);
    $usuarios->veirifar();
}
else
{

    include 'views/home.php';
}