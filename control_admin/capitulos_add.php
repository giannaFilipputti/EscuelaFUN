<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require '../vendor/autoload.php';
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

use Vimeo\Vimeo;

$capitulo = new Capitulo();
$capitulo->getLastOrden();

$pagina = new Pagina();
$pagina->getLastOrden();

$orden = $capitulo->row[0]['orden'];

if (empty($orden)) {
	$orden = 1;
} else {
	$orden = $orden + 1;
}
$capitulo->getLastId();
$id = $capitulo->row[0]['id'];
if (empty($id)) {
	$id = 1;
} else {
	$id = $id + 1;
}

if (empty($sub_menu)) {
	$sub_menu = 0;
}



$client = new Vimeo("cc2ca18d6db9af024e8cd3500fc8e73bc440225d", "tJzM3P8mgbso/T6FKR7LCIO2+bztP2XxRcRgClDdBlVJMoUu1OkHXC156GGzrNLpiR/7ZS7tIMnt7aDljxkkuZtSorTd/T/e87+JJkaca1yiBkB0wvxlzad0b0CsfHg9", "0086c348f138863b43f1cf18579f1f2a");
$elvideo = "/videos/$video";
//echo $elvideo;
$response = $client->request($elvideo, array(), 'GET');

$duracion = $response['body']['duration'];

//echo $duracion;

$capitulo->agregar($id, $caso, $modulo, $titulo, $titulo_eng, $autor, $orden, $resena_autor, $revista, $duracion, $tema, $sub_menu, $video);

$ordenCon = $pagina->row[0]['orden'];

if (empty($orden)) {
	$orden = 1;
} else {
	$orden = $orden + 1;
}



$permisos = "***".$per_asi."***".$per_med."***".$per_del."***";

header("Location: capitulos.php?id=".$modulo."&ref=".$curso); 
