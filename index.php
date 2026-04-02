<?php
$url = $_GET['url'] ?? 'home';

switch($url){
    case 'home':
        require_once "controllers/Controller.php";
        $c = new Controller();
        $c->index();
        break;
}