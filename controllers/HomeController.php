<?php
require_once "models/Producto.php";

class HomeController {

    public function index() {
        $productos = Producto::obtenerTodos();
        require_once "views/home.php";
    }

}