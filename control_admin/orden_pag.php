<?php
require_once '../lib/autoloader.class.php';
require_once '../lib/init.class.php';
require_once '../lib/authAdmin.php';

$result = $_REQUEST["table-6"];
$id = $_REQUEST["id"];

//echo "Aqui".$id."<br>";

$pagina = new Pagina();
$pagina->getAll($id);

 $contador = 1;
  foreach ($pagina->row as $Elem) { 
    $valorden[$contador] = $Elem['orden'];
	$contador = $contador + 1;
  }
  
  
 $contador = 1;
foreach($result as $value) {
	 //echo "$value - <br/>";
	 if (!empty($value)) {
		 
	 $pagina->modificarOrden($valorden[$contador],$value);
	 $contador = $contador + 1;
	 }
	
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
?>


