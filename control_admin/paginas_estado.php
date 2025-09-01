<?php 

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$pagina = new Pagina();
$pagina->modificarEstado($st,$id);

// $result = mysql_query ("UPDATE com_capitulo_contenidos SET estado = '".$st."' WHERE id = ".$id."",$link);

header("Location: paginas.php?id=".$ref."&ref=".$curso); 
