<?php

// Controlador principal
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

require_once "controllers/" . $controller . "Controller.php";

$controllerName = ucfirst($controller) . "Controller";
$obj = new $controllerName();

$obj->$action();