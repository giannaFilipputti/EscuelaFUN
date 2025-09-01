<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");

//echo "DELETE FROM com_alumnos WHERE id = ".$id." <br>"."DELETE FROM com_alumnos_eventos WHERE alumno = ".$id."<br>"."DELETE FROM com_alumnos_exam WHERE alumno = ".$id."<br>"."DELETE FROM com_alumnos_resp WHERE alumno = ".$id."";
if ($rowff['nivel'] >= 4) {

$result = mysql_query ("DELETE FROM com_alumnos WHERE id = ".$id."",$link);


$result = mysql_query ("DELETE FROM com_alumnos_exam WHERE alumno = ".$id."",$link);
	
	$result = mysql_query ("DELETE FROM com_alumnos_exam_cap WHERE alumno = ".$id."",$link);

$result = mysql_query ("DELETE FROM com_alumnos_resp WHERE alumno = ".$id."",$link);



}


header("Location: ".$_SERVER["HTTP_REFERER"]); 
?>