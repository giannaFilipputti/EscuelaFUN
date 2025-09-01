<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$usuExam = new UsuarioExam();

$exam = new Examen();

$listvar = "";
$listvaro = "";
foreach ($_GET as $key => $value) {
	if ($key != 'pag') {
		$listvar .=  $key . "=" . $value . "&";
	}
	if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
		$listvaro .=  $key . "=" . $value . "&";
	}
}


if (!empty($modulo)) {
	$usuExam->modulo = $modulo;
}

if (!empty($datepicker)) {
	$usuExam->datepicker = $datepicker;
}

if (!empty($datepicker1)) {
	$usuExam->datepicker1 = $datepicker1;
}

if (!empty($aprobado)) {
	$usuExam->aprobado = $aprobado;
}
$usuExam->getAll();

$shtml = "Capitulo/Curso,Alumno,Email,Codigo,Estado,Inicio,Fin\n";
if (!empty($usuExam->row)) {
	foreach ($usuExam->row as $Elem) {

		$sql_pre = "SELECT * FROM com_exam_preg WHERE modulo=" . $Elem['modulo'] . " ORDER BY orden";

		$exam->getByModulo($Elem['modulo']);

		$NroRegistrosc = count($exam->row);

		$porcentaje = round(($Elem['nota'] * 100) / $NroRegistrosc);

		$mod = new Modulo();
		$curso = new Curso();
		$usuario = new Usuario();
		$mod->getOne($Elem['modulo']);
		$cursoId = $mod->row[0]['curso'];
		$curso->getOne($mod->row[0]['curso']);
		$usuario->getOne($Elem['alumno']);

		$curso = html_entity_decode($mod->row[0]['titulo'] . " / " . $curso->row[0]['titulo']);
		$alumno = $usuario->row[0]['ape1'] . " " . $usuario->row[0]['ape2'] . "- " . $usuario->row[0]['nombre'];
		$email = $usuario->row[0]['email'];
		$codusuario = $usuario->row[0]['codusuario'];
		$estado = "";
		if ($Elem['estado'] == 0) {
			$estado .= "No Finalizado";
		} else {
			$estado .= "Finalizado (" . $porcentaje . "% - ";
			if ($Elem['aprobado'] == 0) {
				$estado .= "NO ";
			}
			$estado .= "Aprobado)";
		}
		$fecfin = "";
		if ($Elem['estado'] == 1) {
			if ($Elem['fecfin'] < '2014-09-20') {
				$fecfin = '2014-11-03 01:00:00';
			} else {
				$fecfin = $Elem['fecfin'];
			}
			$datetime1 = new DateTime($Elem['fecini']);
			$datetime2 = new DateTime($Elem['fecfin']);
			$interval = $datetime1->diff($datetime2);
			$duracion = $interval->format('%a');
		} else {
			$duracion = "-";
		}
		$shtml .= str_replace(",", "-", $curso) . "," . html_entity_decode(str_replace(",", "-", $alumno)) . "," . str_replace(",", "-", $email) . "," . str_replace(",", "-", $codusuario) . "," . str_replace(",", "-", $estado) . "," . $Elem['fecini'] . "," . $fecfin . "," . $duracion . "\n";
	}
}
header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=resultados.csv");
echo $shtml;
