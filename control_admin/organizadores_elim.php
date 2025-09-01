<?php include("../includes/conn.php");
include_once("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n4.php");



$result = mysql_query ("DELETE FROM com_users WHERE id = ".$id."",$link);





header("Location: organizadores.php"); ?>