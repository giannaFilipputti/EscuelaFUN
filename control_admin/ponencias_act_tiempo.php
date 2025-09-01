<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);

$diapo = new Diapositiva();
$diapo->orden = "tiempo";
$diapo->getAll($id);

//   $sql = "SELECT * FROM com_ponencias_ima WHERE ponencia=".$id." ORDER BY tiempo";
//   //echo $sql;
//   $result = mysql_query($sql,$link);


foreach ($diapo->row as $Elem) {

	$tiempo = $_POST['temp_' . $Elem['id']];
	$tiempo_limpio = strip_tags($tiempo);

	$diapo->modificar($tiempo, $tiempo_limpio, $id);

	$oneDiapo = new Diapositiva();
	$oneDiapo->getOne($Elem['id']);


	$texto = $oneDiapo->row[0]['comentario_limpio'] . '/n/n' . $oneDiapo->row[0]['texto'];
	$indexador = new Indexador();
	$indexador->getAll($oneDiapo->row[0]['id'], $oneDiapo->tabla);

	if (!empty($indexador->row)) {
		foreach ($indexador->row as $ElemIndexa) {
			$indexador->modificarDiapo($texto, $oneDiapo->row[0]['nombre'], $id);
		}
	} else {
		$tabla = "com_ponencias_ima";
		// echo $oneDiapo->row[0]['id'];
		if ($oneDiapo->row[0]['nombre'] != null) {
			$indexador->agregarDiapo($oneDiapo->row[0]['id'], $oneDiapo->tabla, $texto, $oneDiapo->row[0]['nombre']);
			
		}
	}

}

 header("Location: ponencias_up.php?id=" . $id);
