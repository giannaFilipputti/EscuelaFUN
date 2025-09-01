<?php 
error_reporting(E_ALL);
ini_set('display_errors', '0');


require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$cur = new Curso();

// CONTENIDO PAGINA
if (empty($ex_unico)) {
	$ex_unico = 0;
}


$cur->agregar($titulo, $fechoy,$bienvenida, $ex_unico ,$con , $zon);

?>

