<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

$result = mysql_query ("DELETE FROM com_guias WHERE id = ".$id."",$link);


header("Location: guias.php?id=".$ref); ?>