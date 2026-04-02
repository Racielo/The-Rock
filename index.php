<?php
$url = $_GET['url'] ?? 'home';

switch($url){
    case 'home':
        require_once "controllers/HomeController.php";
        $c = new Controller();
        $c->index();
        break;
}