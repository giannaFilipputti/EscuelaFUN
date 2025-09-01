<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

$result = mysql_query ("DELETE FROM com_alumnos_servicios WHERE tipo_reg = 1",$link);

 ?>