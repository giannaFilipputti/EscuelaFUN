<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n3.php");




$result = mysql_query ("DELETE FROM com_invitados WHERE evento = ".$id."",$link);





header("Location: eventos_invitados.php?id=".$id); ?>