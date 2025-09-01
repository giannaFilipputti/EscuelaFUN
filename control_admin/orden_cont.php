<?php
include_once("../includes/conn.php");
$result = $_REQUEST["table-6"];
$id = $_REQUEST["id"];

//echo "Aqui".$id."<br>";
 $sql = "SELECT * FROM com_contenidos WHERE curso = ".$id." ORDER BY orden";
 $result0 = mysql_query($sql,$link);
 $contador = 1;
  while ($row = mysql_fetch_array($result0)) { 
    $valorden[$contador] = $row['orden'];
	$contador = $contador + 1;
  }
  
  
 $contador = 1;
foreach($result as $value) {
	 //echo "$value - <br/>";
	 if (!empty($value)) {
		 
	 
	 $sql = "UPDATE com_contenidos SET orden = '". $valorden[$contador] ."' WHERE id = ".$value."";
	// echo "$sql - <br/>";
     $result0 = mysql_query ($sql,$link) or die("el error es en el insert: ".mysql_error());
	 $contador = $contador + 1;
	 }
	
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
?>


