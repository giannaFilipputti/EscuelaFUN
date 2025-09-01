<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n4.php");




// CONTENIDO PAGINA



$result = mysql_query ("INSERT INTO com_directores (nombre, zona) VALUES ('".$nombre."','".$zona."')",$link) or die("el error es en el insert: ".mysql_error());
header("Location: directores.php"); 
 
		
?>

