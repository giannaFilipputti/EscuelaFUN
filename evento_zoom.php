<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "registro";
$scripts = "none";
//include('head.php');


$prox = New Evento();

$prox->inscribir($evento, $authj->rowff['id']);

//echo $eventos['link_zoom'];
header("Location: https://pulpro.zoom.us/j/97567898540?pwd=bXpiYmIyUGw0TWl0UGYwSG5TQWU2dz09");



?>