<?php
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$id = $modulo;

$mod = New Modulo();
$modulos = $mod->getOne($id);

//echo "Curso". $modulos[0]['curso'];
$curso = $modulos[0]['curso'];



$curs = new Curso();
$cursos = $curs->getOne($modulos[0]['curso']);
$profes = $curs->getDocentes($curso);

$inscrito = Curso::getInscritoCurso($curso, $authj->rowff['id']);

if ($inscrito[0]['estado'] != 1 and $authj->rowff['labor'] < 6) {
    header("location: cursos.php");
    die();
}

if (empty($inscrito[0]['fecini']) || empty($inscrito[0]['fecfin'])) {
    $data4 = array();
    if ($inscrito[0]['fecha'] >= $cursos[0]['fecha']) {
        $data4['fecini'] = $inscrito[0]['fecha'];
    } else {
        $data4['fecini'] = $cursos[0]['fecha'];
    }

    //echo $acred_hasta;
    $acred_hasta1 = strtotime($data4['fecini'] . "+ " . $cursos[0]['plazo'] . " days");
    $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
    $data4['fecfin'] = $acred_hasta;
    Curso::updateFechasInicio($inscrito[0]['id'], $authj->rowff['id'], $data4);
} else {

    $acred_hasta = $inscrito[0]['fecfin'];
}

$datetime1 = new DateTime($acred_hasta);
$datetime2 = new DateTime(date('Y-m-d H:i:s'));
$interval = $datetime1->diff($datetime2);

if ($interval->format('%R') == '-') {
    $duracion = $interval->format('%a');
} else {
    $duracion = '-';
}



                    $exam = new Examen();
                    $exam->curso = $modulos[0]['curso'];
					$exam->modulo = $id;
					$exam->capitulo = $capitulo;
					$exam->pagina = $pagina;
					$exam->alumno = $authj->rowff['id'];
				
					/* $cap = new Capitulo();
					$cap->getOne($exam->capitulo);*/
				
					// revisamos si vencio el plazo
					if ($exam->checkPlazo() == 1) {
						$plazo_vencido = 1;
						$estado_exam = $exam->getEstado();
					} else {
						$plazo_vencido = 0;
						//verificamos en que estado está el examen
						$estado_exam = $exam->getEstado();
						//echo  $estado_exam." - ".$exam->id;
						if ($estado_exam == 5) {
							// mostrar boton de iniciar examen
						} else if ($estado_exam == 1) {
							$exam->getPreg();
						} else if ($estado_exam == 2) {
							// mostrar pantalla de reiniciar examen
						} else if ($estado_exam == 3) {
							// mostrar encuesta
						} else if ($estado_exam == 4) {
							// mostrar resultados
						}
					}

                    $epr = array();

                    foreach ($profes AS $profe) {

                        $variable = "epr".$profe['id'];
                        $epr[$profe['id']] = ${$variable};

                    }

$exam->guardarEncuesta($ep1, $ep2,$ep3,$ep4, $ep5,$ep6, $ep7, $epr, $id, $curso, $authj->rowff['id']);

header("Location: inicio_examen.php?id=".$modulo."&curso=".$curso);
?>