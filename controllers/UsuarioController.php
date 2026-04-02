<?php
require_once "models/Usuarios.php";

class UsuarioController {
    public function index(){
        $modelo = new Usuarios();
        $usuarios = $modelo->obtenerUsuarios();

        require_once "views/Usuarios.php";
    }
}