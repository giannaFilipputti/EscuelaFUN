<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

		  
  
   
  $sqlp = "UPDATE com_comite SET nombre = '". addslashes($titulo) ."', contenido = '". addslashes ($contenido) ."' WHERE id = ".$id."";
  $result = mysql_query ($sqlp,$link);



header("Location: comite.php?id=".$ref); ?>