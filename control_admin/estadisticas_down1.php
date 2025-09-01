<?php
require_once 'Spreadsheet/Excel/Writer.php';
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';


$workbook = new Spreadsheet_Excel_Writer();

$alumnos = new Usuario();
$especialidad = new Especialidad();
$provincia = new Provincia();
$pais = new Pais();
$mod = new Modulo();
$usuExam = new UsuarioExam();
$mod->getAll();
$workbook->send('encuesta1.xls');

$worksheet = $workbook->addWorksheet('Alumnos examinados');

$worksheet->write(0, 0, 'Apellidos');
$worksheet->write(0, 1, 'Nombre');
$worksheet->write(0, 2, 'Email');
$worksheet->write(0, 3, 'Fecha ultimo acceso plataforma');

$alumnos->getAll('ape1', "", "", "");

$columna = 4;
foreach ($mod->row as $m) {
	$worksheet->write(0, $columna, utf8_decode($m['titulo']));
	$worksheet->write(1, $columna, utf8_decode('Examen Estado'));
	$worksheet->write(1, $columna + 1, utf8_decode('Fecha finalizacion'));
	$worksheet->write(1, $columna + 2, utf8_decode('Diploma'));

	$worksheet->setMerge(0, $columna, 0, $columna + 2);
	$columna = $columna + 3;
}

$fila = 2;

foreach ($alumnos->row as $alu) {
	if (strpos($alu['email'], 'esteve.es') === false and strpos($alu['email'], 'tba.es')  === false and strpos($alu['email'], 'tbhealthcare.es') === false and strpos($alu['email'], 'eisai.net') === false and strpos($alu['email'], 'esteve.com') === false) {
		$perfil = new Perfil();

		$perfil->getOne($alu['perfil']);
		if (!empty($perfil->row[0]['id'])) {
			$perfil1 = $perfil->row[0]['perfil'];
		}

		if ($alu['perfil'] == 'ME' && $alu['especialidad'] != 0) {

			$especialidad->getOne($alu['id']);

			if (!empty($especialidad->row[0]['id'])) {
				$perfil = $especialidad->row[0]['especialidad'];
			}
		}

		$pro = "";

		if (!empty($alu['provincia'])) {

			$provincia->getOne($alu['provincia'], $alu['pais']);

			if (!empty($provincia->row[0]['id'])) {
				$pro = $provincia->row[0]['provincia'];
			}
		} else {
			$pais->getOneByCod($alu['pais']);

			if (!empty($pais->row['id'])) {
				$pro = $pais->row['pais'];
			}
		}

		$fecha = strtotime($alu['fecreg']);

		$worksheet->write($fila, 0, utf8_decode($alu['ape1'] . " " . $alu['ape2']));
		$worksheet->write($fila, 1, utf8_decode($alu['nombre']));
		$worksheet->write($fila, 2, $alu['email']);
		$worksheet->write($fila, 3, date('d-m-Y', $fecha));

		$columna = 4;

		for ($i = 1; $i < 5; $i++) {

			$usuExam->getOne($alu['id'], $i);

			$usuIntentos = $usuExam->getintentos($alu['id'], $i);

			$color = "";
			$estadoE = "";
			$dipE = "";
			$fechaF = "";
			if (!empty($usuExam->row[0]['id'])) {
				if ($usuExam->row[0]['estado'] == 1) {

					if ($usuExam->row[0]['aprobado'] == 1) {
						$estadoE = "Aprobado";
						$color = "2DB200";
					} else {
						$estadoE = "Suspendido";
						$color = "FF0000";

					}

					if ($usuExam->row[0]['desc_diploma'] == 1) {
						$dipE = "SI";
					} else {
						$dipE = "NO";
					}
					$fechaF = $usuExam->row[0]['fecfin'];
				} else {
					$color = "000000";
					$estadoE = "Iniciado";
					$dipE = "NO";
					$fechaF = "-";

				}
			} else {
				$color = "000000";
				$estadoE = "-";
				$dipE = "-";
				$fechaF = "-";

			}
			$worksheet->write($fila, $columna, $estadoE);
			$worksheet->write($fila, $columna + 1, $fechaF);
			$worksheet->write($fila, $columna + 2, $dipE);
			$columna = $columna + 3;

		}

		$fila++;
	}
}


$workbook->close();
