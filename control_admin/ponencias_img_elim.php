<?php


require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$fecha = date('Y-m-d H:i:s');

  $contenido = $_GET['id']; 
  $ref = $_GET['ref']; 
  $logo = $_GET['logo']; 
   
  $diapo = new Diapositiva();
  $diapo->eliminar($contenido,$ref);
			
			
   header("Location: ponencias_up.php?id=".$ref); 
		
?>