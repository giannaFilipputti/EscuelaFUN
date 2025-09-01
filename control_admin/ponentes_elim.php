<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n3.php");




$result = mysql_query ("DELETE FROM com_users WHERE id = ".$id."",$link);





header("Location: ponentes.php"); ?>