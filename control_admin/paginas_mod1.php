<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
		  
$pagina = new Pagina();

  // $permisos = "***".$per_asi."***".$per_med."***".$per_del."***";
   $permisos = "************";

  // $sqlp = "UPDATE com_capitulo_contenidos SET titulo = '". $titulo_con ."', subtitulo = '". $subtitulo_con ."', autor = '". $autor_con ."', tipo = '". $tipo ."', contenido = '". $contenido ."', video = '". $video ."', permisos = '". $permisos ."' WHERE id = ".$id."";
  // //echo $sqlp;
  // $result = mysql_query ($sqlp,$link);

$pagina->modificar($id,$titulo_con,$subtitulo_con,$autor_con,$tipo,$contenido,$video,$permisos);


header("Location: paginas.php?id=".$capitulo."&ref=".$curso); ?>