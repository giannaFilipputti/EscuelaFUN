<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n3.php");





 $sqlg = "SELECT * FROM com_users WHERE gerente = ".$id. " LIMIT 1";
          $resultg = mysql_query($sqlg);
if ($rowg = mysql_fetch_array($resultg)) { 
 } else { 
$result = mysql_query ("DELETE FROM com_gerentes WHERE id = ".$id."",$link);

}





header("Location: gerentes.php"); ?>