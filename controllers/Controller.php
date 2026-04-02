<?php
class Controller {
    public function index() {
        $mensaje = "Bienvenido a mi proyecto MVC";
        require_once "views/home.php";
    }
}