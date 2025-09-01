<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n3.php");




$sqlk = "SELECT * FROM com_eventos WHERE id=".$id."";
            $resultk = mysql_query($sqlk);
			$row = mysql_fetch_array($resultk);
			
			if (date("Y-m-d",strtotime($row['fecha'])) >= $diahoy or $rowff['nivel'] == 4) { 
			
			

$result = mysql_query ("DELETE FROM com_eventos WHERE id = ".$id."",$link);

$result = mysql_query ("DELETE FROM com_alumnos_eventos WHERE evento = ".$id."",$link);

$result = mysql_query ("DELETE FROM com_evento_examen WHERE evento = ".$id."",$link);

$result = mysql_query ("UPDATE com_alumnos_exam SET evento = '0' WHERE evento = ".$id."",$link);

			 }


header("Location: eventos.php?id=".$ref); ?>