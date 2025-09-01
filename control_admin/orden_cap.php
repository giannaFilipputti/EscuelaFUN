<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$resultv = $_REQUEST["table-6"];
$id = $_REQUEST["id"];

//echo "Aqui".$id."<br>";
$capitulo = new Capitulo();
$capitulo->getAll($id);

 $contador = 1;
  foreach ($capitulo->row as $Elem) { 
    $valorden[$contador] = $Elem['orden'];
	$contador = $contador + 1;
  }
  
  
 $contador = 1;
foreach($resultv as $value) {
	 //echo "$value - $contador <br/>";
	 if (!empty($value)) {
		 
	 $capitulo->modificarOrden($valorden[$contador],$value);

	 $contador = $contador + 1;
	 }
	
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
?>


