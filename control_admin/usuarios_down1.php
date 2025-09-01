<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'Spreadsheet/Excel/Writer.php';
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send('regitrados.xls');

//$worksheet->setInputEncoding('UTF8');

// Creating a worksheet
$worksheet = $workbook->addWorksheet('Usuarios');


// The actual data
$worksheet->write(0, 0, 'Apellido 1');
$worksheet->write(0, 1, 'Apellido 2');
$worksheet->write(0, 2, 'Nombre');
$worksheet->write(0, 3, 'Email');
$worksheet->write(0, 4, 'Fecha Registro');
$worksheet->write(0, 5, 'Profesion');
$worksheet->write(0, 6, 'Especialidad');
$worksheet->write(0, 7, 'Provincia');
/*$worksheet->write(0, 8, 'Lugar de trabajo');
$worksheet->write(0, 9, 'Telefono');
$worksheet->write(0, 10, 'No. colegiado');
$worksheet->write(0, 11, 'Edad');
$worksheet->write(0, 12, 'CP');*/
$worksheet->write(0, 8, 'Mailing EISAI');
$worksheet->write(0, 9, 'Mailing TBH');
$worksheet->write(0, 10, 'Datos cedidos');

$usuario = new Usuario();

foreach ($_GET as $key => $value) {
	if ($key != 'pag') {
		$listvar .=  $key . "=" . $value . "&";
	}
	if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
		$listvaro .=  $key . "=" . $value . "&";
	}
}
if (empty($_GET['orden'])) {
	$orden = 'ape1';
} else {
	if (empty($_GET['tiporden'])) {
		$orden = $_GET['orden'];
	} else {
		$orden = $_GET['orden'] . " DESC";
	}
}

//estos valores los recibo por GET
if (isset($pag)) {
	$RegistrosAEmpezar = ($pag - 1) * $usuario->limit;
	$PagAct = $pag;
	//echo "aqui vemos";
	//caso contrario los iniciamos
} else {
	$RegistrosAEmpezar = 0;
	$PagAct = 1;
}


if (!empty($_GET['email'])) {
	$email = $_GET['email'];
}
if (!empty($_GET['nombre'])) {
	$nombre = $_GET['nombre'];
}
if (!empty($_GET['apellido'])) {
	$apellido = $_GET['apellido'];
}


$email = "";
$nombre = "";
$apellido = "";


$usuario->getAll($orden, $email, $nombre, $apellido);


$NroRegistros = $usuario->total_results;


$cantproductos = $RegistrosAEmpezar + $usuario->limit;
if ($cantproductos > $NroRegistros) {
	$cantproductos = $NroRegistros;
}

$PagAnt = $PagAct - 1;
$PagSig = $PagAct + 1;
$PagUlt = $NroRegistros / $usuario->limit;

//verificamos residuo para ver si llevará decimales
$Res = $NroRegistros % $usuario->limit;

if ($Res > 0)  $PagUlt = floor($PagUlt) + 1;
$fila = 2;

foreach ($usuario->row as $Elem) {

	$perfil = new Perfil();
	$perfil->getOne($Elem['perfil']);
	$perfil0 ="";
	$perfil1 ="";
	if (!empty($perfil->row[0]['id'])) {
		$perfil1 = $perfil->row[0]['perfil'];
	}

	if ($Elem['perfil'] == 'ME' && $Elem['especialidad'] != 0) {

		$especialidad = new Especialidad();
		$especialidad->getOne($Elem['especialidad']);

		if (!empty($especialidad->row[0]['id'])) {
			$perfil0 = $especialidad->row[0]['especialidad'];
		}
	}

	$pro = "";

	if (!empty($Elem['provincia'])) {

		$provincia = new Provincia();
		$provincia->getOne($Elem['provincia'], $Elem['pais']);

		if (!empty($provincia->row[0]['id'])) {
			$pro = $provincia->row[0]['provincia'];
		}
	}
	$p = "";
	if (!empty($Elem['pais'])) {
		$pais = new Pais();
		$pais->getOneByCod($Elem['pais']);
		 
		if (!empty($pais->row[0]['id'])) {
			$p = $pais->row[0]['pais'];
		}
	}
	$fecha = strtotime($Elem['fecreg']);
	
	$mailing1 = "";
	if ($Elem['mailing1'] == 1) {
		$mailing1 = "S";
	} else {
		$mailing1 = "N";
	}
	$datos = "";
	if ($Elem['datoscedidos'] == 1) {
		$datos = "S";
	} else {
		$datos = "N";
	}

	$examen = array();
	$acceso = array();
	$modulos = array();

	$col1 = 11;
	$mod = new Modulo();
	$mod->getAll();
	foreach ($mod->row as $ElemMod) {

		$modulos[] = $ElemMod['id'];

		$worksheet->write(0, $col1, utf8_decode('Examen ' . $ElemMod['titulo']));
		$col1++;
		$worksheet->write(0, $col1, utf8_decode('Acceso ' . $ElemMod['titulo']));

		$examen[$ElemMod['id']] = "";
		$exam = new UsuarioExam();
		$exam->getOne($Elem['id'],$ElemMod['id']);
		if (!empty($exam->row)) {
			$modUsu = new Modulo();
			$modUsu->getUsuarioModulo($ElemMod['id'],$Elem['id']);
			if (!empty($modUsu->row)) {
				$fechaacc = strtotime($modUsu->row[0]['fecin']);
				$acceso[$ElemMod['id']] = date('d-m-Y', $fechaacc);
			}
			if ($exam->row[0]['estado'] == 0) {
				$examen[$ElemMod['id']] = "Examen No Finalizado";
			} else if ($exam->row[0]['aprobado'] == 1) {
				$examen[$ElemMod['id']] = "Examen Aprobado";
			} else {
				$examen[$ElemMod['id']] = "Examen Suspendido";
			}
		} else {
			$examen[$ElemMod['id']] = "Examen No Iniciado";
		}
		$col1++;
	}


	$worksheet->write($fila, 0, utf8_decode($Elem['ape1']));
	$worksheet->write($fila, 1, utf8_decode($Elem['ape2']));
	$worksheet->write($fila, 2, utf8_decode($Elem['nombre']));
	$worksheet->write($fila, 3, $Elem['email']);
	$worksheet->write($fila, 4, date('d-m-Y', $fecha));
	$worksheet->write($fila, 5, utf8_decode($perfil1));
	$worksheet->write($fila, 6, utf8_decode($perfil0));
	$worksheet->write($fila, 7, utf8_decode($pro));
	$worksheet->write($fila, 8, $Elem['mailing']);
	$worksheet->write($fila, 9, $mailing1);
	$worksheet->write($fila, 10, $datos);

	$col = 11;
	foreach ($modulos as $Elem) {
		$worksheet->write($fila, $col, $examen[$Elem]);
		$col++;
		$worksheet->write($fila, $col, $acceso[$Elem]);
		$col++;
	}
	$fila++;
}


// Let's send the file
$workbook->close();
