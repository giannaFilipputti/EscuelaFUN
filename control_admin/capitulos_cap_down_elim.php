<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

$result = mysql_query ("DELETE FROM com_cap_down WHERE id = ".$id."",$link);


header("Location: capitulos_cap_down.php?id=".$ref); ?>