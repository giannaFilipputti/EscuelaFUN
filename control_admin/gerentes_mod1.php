<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n4.php");



	   
  $sqlp = "UPDATE com_gerentes SET nombre = '". $nombre ."', zona = '". $zona ."', director = '". $director ."' WHERE id = ".$id."";
  

  $result = mysql_query ($sqlp,$link) ;



      header("Location: gerentes.php"); 

			 ?>