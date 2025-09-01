<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

$result = mysql_query ("DELETE FROM com_foco WHERE id = ".$id."",$link);
$result = mysql_query ("DELETE FROM com_indexador WHERE id_tabla = ".$id." AND tabla = 'com_foco' ",$link);


header("Location: foco.php?id=".$ref); ?>