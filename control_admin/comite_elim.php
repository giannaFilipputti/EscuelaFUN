<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

$result = mysql_query ("DELETE FROM com_comite WHERE id = ".$id."",$link);


header("Location: comite.php?id=".$ref); ?>