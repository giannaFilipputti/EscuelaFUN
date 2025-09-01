<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

		  
 $sql_pre = "SELECT * FROM com_cursos_prelanding WHERE curso=".$curso."";
$result_pre = mysql_query($sql_pre);
if ($row_pre = mysql_fetch_array($result_pre)) { 
   
  $sqlp = "UPDATE com_cursos_prelanding SET contenido = '". $contenido ."' WHERE curso = ".$curso."";
  $result = mysql_query ($sqlp,$link);
} else {
	
	$result = mysql_query ("INSERT INTO com_cursos_prelanding (curso, contenido) VALUES ('".$curso."','".$contenido."')",$link) or die("el error es en el insert1: ".mysql_error());
	}



header("Location: cursos.php"); ?>