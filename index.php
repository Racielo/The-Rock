<?php

define('BASE_URL', '/The-Rock/');

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

require_once "controllers/" . ucfirst($controller) . "Controller.php";

$controllerName = ucfirst($controller) . "Controller";
$obj = new $controllerName();

$obj->$action();