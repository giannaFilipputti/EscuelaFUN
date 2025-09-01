<?php include("../includes/conn.php");
include ("auto.php");

include_once("../includes/extraer_variables.php");

$result = mysql_query ("UPDATE com_comite SET estado = '".$st."' WHERE id = ".$id."",$link);

header("Location: comite.php?id=".$ref); ?>