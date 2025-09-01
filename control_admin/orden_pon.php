<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$result = $_REQUEST["table-6"];
$id = $_REQUEST["id"];

//echo "Aqui".$id."<br>";
$diapo = new Diapositiva();
$diapo->getAll($id);
$diapo->orden = "orden";

 $contador = 1;
  foreach ($diapo->row as $Elem) { 
    $valorden[$contador] = $Elem['orden'];
	$contador = $contador + 1;
  }
  
  
 $contador = 1;
foreach($result as $value) {
	 //echo "$value - <br/>";
	 if (!empty($value)) {
		 
		$diapo->modificarOrden($valorden[$contador],$value);
	// echo "$sql - <br/>";
	 $contador = $contador + 1;
	 }
	
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
?>


