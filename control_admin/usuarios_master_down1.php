<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/
$_page = "intro";
require_once 'Spreadsheet/Excel/Writer.php';
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$workbook = new Spreadsheet_Excel_Writer();

$usuario = new Usuario();
// sending HTTP headers
$workbook->send('masterclass1.xls');

//$worksheet->setInputEncoding('UTF8');

// Creating a worksheet
$worksheet = $workbook->addWorksheet(utf8_decode('Usuarios'));


// The actual data
$worksheet->write(0, 0, 'Apellido 1');
$worksheet->write(0, 1, 'Apellido 2');
$worksheet->write(0, 2, 'Nombre');
$worksheet->write(0, 3, 'Email');
$worksheet->write(0, 4, 'Fecha Registro');
$worksheet->write(0, 5, 'Profesion');
$worksheet->write(0, 6, 'Especialidad');
$worksheet->write(0, 7, 'Pais');
$worksheet->write(0, 8, 'Provincia');

//$worksheet->write(0, 14, 'Preg 6');
/*$worksheet->write(0, 8, 'Lugar de trabajo');
$worksheet->write(0, 9, 'Telefono');
$worksheet->write(0, 10, 'No. colegiado');
$worksheet->write(0, 11, 'Edad');
$worksheet->write(0, 12, 'CP');*/

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
	$RegistrosAEmpezar = ($pag - 1) * $RegistrosAMostrar;
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

$usuario->getAlumnosMaster1($orden, $email, $nombre, $apellido);


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
	$perfil0 = "";
	if (!empty($perfil->row[0]['id'])) {
		$perfil1 = $perfil->row[0]['perfil'];
	}

	if ($Elem['perfil'] == 'ME' && $Elem['especialidad'] != 0) {

		$especialidad = new Especialidad();
		$especialidad->getOne($Elem['id']);

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
	if ($Elem['mailing1'] == 1) {
		$mailing1 = "S";
	} else {
		$mailing1 = "N";
	}

	if ($Elem['datoscedidos'] == 1) {
		$datos = "S";
	} else {
		$datos = "N";
	}

	$worksheet->write($fila, 0, utf8_decode($Elem['ape1']));
	$worksheet->write($fila, 1, utf8_decode($Elem['ape2']));
	$worksheet->write($fila, 2, utf8_decode($Elem['nombre']));
	$worksheet->write($fila, 3, utf8_decode($Elem['email']));
	$worksheet->write($fila, 4, date('d-m-Y', $fecha));
	$worksheet->write($fila, 5, utf8_decode($perfil1));
	$worksheet->write($fila, 6, utf8_decode($perfil0));
	$worksheet->write($fila, 7, utf8_decode($p));
	$worksheet->write($fila, 8, utf8_decode($pro));

	$fila++;
}

// Let's send the file
$workbook->close();
