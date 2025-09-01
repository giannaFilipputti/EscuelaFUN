<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$result = $_REQUEST["table-6"];
$id = $_REQUEST["id"];

//echo "Aqui".$id."<br>";
$exam = new Examen();
$exam->getAll($id);
$valorden = array();
$contador = 1;
foreach ($exam->row as $Elem) {
	$valorden[$contador] = $contador;
	$contador = $contador + 1;
}


$contador = 1;
foreach ($result as $value) {
	//echo "$value - <br/>";
	if (!empty($value)) {

		$exam->modificarOrden($value, $valorden[$contador], $ref);

		$contador = $contador + 1;
	}
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
