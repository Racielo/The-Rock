<?php
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