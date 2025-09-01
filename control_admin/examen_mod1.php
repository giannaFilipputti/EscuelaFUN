<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

// CONTENIDO PAGINA

$exam = new Examen();
$exam->modificar($pagina, $numero, $pregunta, $exp_resp, $video, $id, $ref);

$contador = 1;

while ($contador <= $cant) {

	$var1 = "respuesta" . $contador;
	$var2 = "correcta" . $contador;
	$var3 = "laid" . $contador;

	$respuesta = ${$var1};
	$correcta = ${$var2};
	$laid = ${$var3};
	if ($correcta == 1) {
		$correcta = 1;
	} else {
		$correcta = 0;
	}

	if (!empty($respuesta)) {

		if (!empty($laid)) {
			$exam->modificarRespuesta($respuesta, $correcta, $laid, $ref);
		} else {
			$exam->agregarRespuesta($id, $respuesta, $correcta);
		}
	} else {
		if (!empty($laid)) {
			$exam->deleteRespuesta($laid, $ref);
		}
	}


	$contador = $contador + 1;
}


 header("Location: examen.php?id=" . $ref."&ref=".$ref);
