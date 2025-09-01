<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$pagina = new Pagina();
$pagina->eliminar($id,$curso,$ref);

// $ponencia = new Ponencia();
// $ponencia->eliminar($id,$curso,$ref);


// $result = mysql_query ("DELETE FROM com_capitulo_contenidos WHERE id = ".$id."",$link);

// $result66 = mysql_query ("DELETE FROM com_ponencias_ima WHERE ponencia = ".$id."",$link);



header("Location: paginas.php?id=".$ref."&ref=".$curso); ?>