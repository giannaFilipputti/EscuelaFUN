<?php
include_once("../includes/conn.php");
$result = $_REQUEST["table-6"];
$id = $_REQUEST["id"];
$tipo = $_REQUEST["tipo"];

//echo "Aqui".$id."<br>";
 $sql = "SELECT * FROM com_ponencias_destacados WHERE curso = ".$id." AND tipo = '".$tipo."' ORDER BY orden";
 
 $result0 = mysql_query($sql,$link);
 $contador = 1;
  while ($row = mysql_fetch_array($result0)) { 
    $valorden[$contador] = $row['orden_'.$tipo];
	$contador = $contador + 1;
  }
  
  
 $contador = 1;
foreach($result as $value) {
	 //echo "$value - <br/>";
	 if (!empty($value)) {
		 
	 
	 $sql = "UPDATE com_ponencias_destacados SET orden_".$tipo." = '". $contador ."' WHERE id = ".$value."";
	// echo "$sql - <br/>";
     $result0 = mysql_query ($sql,$link) or die("el error es en el insert: ".mysql_error());
	 $contador = $contador + 1;
	 }
	
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
?>


