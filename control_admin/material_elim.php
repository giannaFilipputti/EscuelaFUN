<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

$result = mysql_query ("DELETE FROM com_material WHERE id = ".$id."",$link);


header("Location: material.php?id=".$ref); ?>