<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n3.php");






$result = mysql_query ("DELETE FROM com_alumnos_eventos WHERE id = ".$id." AND evento = ".$evento,$link);




header("Location: eventos_ponentes.php?id=".$evento); ?>