<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

		  
  
   
  $sqlp = "UPDATE com_buscar SET origen = 'ppal' WHERE origen <> 'z2c'";
  echo $sqlp."<br>";
  $result = mysql_query ($sqlp,$link);



//header("Location: capitulos.php?id=".$modulo); ?>