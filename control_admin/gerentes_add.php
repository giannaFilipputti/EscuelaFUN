<?php include("../includes/conn.php");

include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n4.php");



// CONTENIDO PAGINA



$result = mysql_query ("INSERT INTO com_gerentes (nombre, zona, director) VALUES ('".$nombre."','".$zona."','".$director."')",$link) or die("el error es en el insert: ".mysql_error());
header("Location: gerentes.php"); 
 
		
?>

