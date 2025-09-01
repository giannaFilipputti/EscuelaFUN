<?php include("../includes/conn.php");
include ("auto.php");
include("../includes/extraer_variables_seg.php");



$sql = "SELECT * FROM com_foco WHERE id=".$id."";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);



$sql_ind = "SELECT * FROM com_indexador WHERE tabla='com_foco' AND id_tabla = ".$row['id']."";
$result_ind = mysql_query($sql_ind);



if ($row_ind = mysql_fetch_array($result_ind)) {
	 $sqlp = "UPDATE com_indexador SET texto = '". $contenido ."' WHERE id = ".$row_ind['id']."";
	
	} else {
		
		$sqlp = "INSERT INTO com_indexador (id_tabla, tabla, texto) VALUES ('".$row['id']."','com_foco','".$contenido."')";
		
	}

		  
  
   
 
  $result = mysql_query ($sqlp,$link);



header("Location: foco.php?id=".$row['curso']); ?>