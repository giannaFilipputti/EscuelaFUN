<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n3.php");





 $sqlg = "SELECT * FROM com_gerentes WHERE director = ".$id. " LIMIT 1";
          $resultg = mysql_query($sqlg);
if ($rowg = mysql_fetch_array($resultg)) { 
 } else { 
$result = mysql_query ("DELETE FROM com_directores WHERE id = ".$id."",$link);

}





header("Location: directores.php"); ?>