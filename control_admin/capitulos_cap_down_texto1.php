<?php include("../includes/conn.php");
include ("auto.php");
include("../includes/extraer_variables_seg.php");



$sql = "SELECT * FROM com_cap_down WHERE id=".$id."";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);


$sql_cap = "SELECT * FROM com_cursos_mod_cap WHERE id=".$row['capitulo']."";
$result_cap = mysql_query($sql_cap);
$row_cap = mysql_fetch_array($result_cap);

$sql_mod = "SELECT * FROM com_cursos_mod WHERE id=".$row_cap['modulo']."";
          $result_mod = mysql_query($sql_mod,$link);
		  $row_mod = mysql_fetch_array($result_mod);
		  
		  $curso = $row_mod['curso'];
		  

$sql_ind = "SELECT * FROM com_indexador WHERE tabla='com_cap_down' AND id_tabla = ".$row['id']."";
$result_ind = mysql_query($sql_ind);



if ($row_ind = mysql_fetch_array($result_ind)) {
	 $sqlp = "UPDATE com_indexador SET texto = '". $contenido ."', curso = '". $curso ."' WHERE id = ".$row_ind['id']."";
	
	} else {
		
		$sqlp = "INSERT INTO com_indexador (id_tabla, tabla, texto, curso) VALUES ('".$row['id']."','com_cap_down','".$contenido."','".$curso."')";
		
	}

		  
  
   
 
  $result = mysql_query ($sqlp,$link);



header("Location: capitulos_cap_down.php?id=".$row_cap['id']."&ref=".$row_cap['modulo']); ?>