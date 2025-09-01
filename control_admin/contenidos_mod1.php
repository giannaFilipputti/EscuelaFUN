<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

		  
  
   
  $sqlp = "UPDATE com_contenidos SET titulo = '". $titulo ."', menu = '". $menu ."', contenido = '". $contenido ."' WHERE id = ".$id."";
  $result = mysql_query ($sqlp,$link);



header("Location: contenidos.php?id=".$ref); ?>