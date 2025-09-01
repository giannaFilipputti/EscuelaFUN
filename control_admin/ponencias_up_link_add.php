<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';


// CONTENIDO PAGINA

$link = new Diapositiva();
$link->getLastOrdenLink($imagen);
				
               if(!empty($link->row)) { 
                   $orden = 0;
               }
                else {
                  
                  $orden = $link->row['orden'] + 1;
                }
				
				
      
  // $sqlp = "INSERT INTO com_ponencias_ima_link (id, imagen, top, xleft, ancho, alto, url, orden) VALUES ('".$id."','".$imagen."','".$top."','".$left."','".$ancho."','".$alto."','".$url."','".$orden."')";

  $link->agregarLink($imagen,$top,$left,$ancho,$alto,$url,$orden);

header("Location: ponencias_up_link.php?id=".$imagen); 
 
?>

