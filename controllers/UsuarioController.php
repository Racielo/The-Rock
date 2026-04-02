<?php
require_once "models/usuarios.php";

class UsuarioController {
    public function index(){
        $modelo = new Usuarios();
        $usuarios = $modelo->obtenerusuarios();

        require_once "views/usuarios.php";
    }
}