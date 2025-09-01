<?php

// use Dompdf\FrameDecorator\Page;

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$pagina = new Pagina();
$pagina->getLastOrden();
$orden = $pagina->row[0]['orden'];

if (empty($orden)) {
	$orden = 1;
} else {
	$orden = $orden + 1;
}
// $permisos = "***".$per_asi."***".$per_med."***".$per_del."***";
				
 $permisos = "************";

 $pagina->agregar($capitulo,$titulo_con,$subtitulo_con,$autor_con,$tipo,$contenido,$orden,$permisos);
				

 header("Location: paginas.php?id=".$capitulo."&ref=".$curso); 

 
?>

