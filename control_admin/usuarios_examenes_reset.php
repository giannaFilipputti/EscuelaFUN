<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$usuario = new Usuario();
$usuario->getOne($alumno);

$mod = new Modulo();
$mod->getOne($modulo);


if (!empty($mod->row)) {

	$usuExam = new UsuarioExam();

	$exam = new Examen();
	$respuestas = "";
	$preg_aprob = $mod->row[0]['preg_aprob'];
	$usuExam->id = $id;
	$usuExam->getOne($alumno, $modulo);
	if (!empty($usuExam->row)) {
		$respuestas = "modulo:" . $usuExam->row[0]['modulo'] . "-nota:" . $usuExam->row[0]['nota'] . "-aprobado:" . $usuExam->row[0]['aprobado'] . "-estado:" . $usuExam->row[0]['estado'] . "-fecini:" . $usuExam->row[0]['fecini'] . "-fecfin:" . $usuExam->row[0]['fecfin'] . "<br>";

		$exam->getByModulo($modulo);

		$NroRegistrosc = count($exam->row);

		$porcentaje = ($usuExam->row[0]['nota'] * 100) / $NroRegistrosc;
		if ($usuExam->row[0]['nota'] >= $preg_aprob) {
			$pregfijo = '';
			$claseapro = 'verde';
		} else {
			$pregfijo = 'NO';
			$claseapro = 'roja';
		}


		foreach ($exam->row as $Elem) {

			$usuExam2 = new UsuarioExam();

			$usuExam2->id_exam_mod = $id;

			$usuExam2->getUsuarioRespuestaByPregunta($Elem['id'], $alumno);
			if (!empty($usuExam2->row)) {
				foreach ($usuExam2->row as $ElemResp) {
					// echo "<br>entra aqui <br>";

					$respuestas .= $Elem['id'] . "-" . $ElemResp['respuesta'] . "<br>";
		
				}
			}
		}
		$usuExam->eliminar($id);


		$usuExam->agregarBorrador($alumno, $authj->rowff['id'], $fechoy, $respuestas);
	} else {
	}
}


header("Location: usuarios_examenes.php?id=" . $alumno);
