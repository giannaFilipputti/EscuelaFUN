<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once 'Spreadsheet/Excel/Writer.php';
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$workbook = new Spreadsheet_Excel_Writer();
$mod = new Modulo();
$mod->getOne($id);
$mrow = $mod->row[0];

$workbook->send('encuesta1.xls');

$worksheet = $workbook->addWorksheet('Totales');


$mod->getAllEncuesta($id, 0, 0);
$tp1 = count($mod->row);

$format_title = $workbook->addFormat();
$format_title->setBold();
$format_title->setBorder(1);


$format = $workbook->addFormat();
$format->setBorder(1);
$format->setTextWrap();

$worksheet->setMargins(0.75);


$worksheet->write(1, 1, '');
$worksheet->write(2, 1, 'Encuesta del ' . utf8_decode($mrow['titulo']));
$worksheet->write(3, 1, 'Total respuestas ' . $tp1);
$worksheet->write(5, 1, 'Pregunta',$format_title);
$worksheet->write(5, 2, '1',$format_title);
$worksheet->write(5, 3, '2',$format_title);
$worksheet->write(5, 4, '3',$format_title);
$worksheet->write(5, 5, '4',$format_title);
$worksheet->write(5, 6, '5',$format_title);

$worksheet->write(6, 1, utf8_decode('¿Crees que el curso ha sido útil para ampliar tus conocimientos sobre exploración neurológica?	'),$format);
$worksheet->write(7, 1, utf8_decode('¿Crees que las técnicas de exploración presentadas en los vídeos son de interés para la práctica clínica? '),$format);
$worksheet->write(8, 1, utf8_decode('¿Crees que el formato interactivo del curso y la presencia de vídeos demostrativos son de utilidad para mejorar la comprensión de las técnicas exploratorias? '),$format);
$worksheet->write(9, 1, utf8_decode('¿Crees que las preguntas del examen era suficientemente claras? '),$format);
$worksheet->write(10, 1, utf8_decode('¿Recomendarías este curso a otros profesionales sanitarios? '),$format);


$fila = 6;
for ($i = 1; $i < 6; $i++) {
	$columna = 2;

	for ($y = 1; $y < 6; $y++) {

		$mod->getAllEncuesta($id, 'p' . $i, $y);
		$worksheet->write($fila, $columna, $mod->total_results_encuesta,$format);
		$columna++;
	}
	$fila++;
}

$worksheet2 = $workbook->addWorksheet('Resp. por usuario');

$mod->getOneEncuesta($id);

$usuario = new Usuario();




$mod->getAllEncuestaByMod($id,"fecha");
$mod->starting_limit = "";
$mod->limit = "";
$fila = 2;
foreach ($mod->row as $Elem) {
	$usuario->getOne($Elem['alumno']);
	$usu = $usuario->row[0];
	$datedesde = new DateTime($usu['fecha']);

	$worksheet2->write($fila + 1, 1, utf8_decode('Usuario: ' . $usu['ape1'] . ", " . $usu['nombre']));
	$worksheet2->write($fila + 2, 1, 'Email: ' . $usu['email']);
	$worksheet2->write($fila + 3, 1, 'Fecha ' . $datedesde->format('d-m-Y'));
	$worksheet2->write($fila + 4, 1, 'Pregunta',$format_title);
	$worksheet2->write($fila + 4, 2, 'Respuesta',$format_title);
	$worksheet2->write($fila + 5, 1, utf8_decode('¿Crees que el curso ha sido útil para ampliar tus conocimientos sobre exploración neurológica?	'),$format);
	$worksheet2->write($fila + 6, 1, utf8_decode('¿Crees que las técnicas de exploración presentadas en los vídeos son de interés para la práctica clínica? '),$format);
	$worksheet2->write($fila + 7, 1, utf8_decode('¿Crees que el formato interactivo del curso y la presencia de vídeos demostrativos son de utilidad para mejorar la comprensión de las técnicas exploratorias? '),$format);
	$worksheet2->write($fila + 8, 1, utf8_decode('¿Crees que las preguntas del examen era suficientemente claras? '),$format);
	$worksheet2->write($fila + 9, 1, utf8_decode('¿Recomendarías este curso a otros profesionales sanitarios? '),$format);
	$worksheet2->write($fila + 10, 1, utf8_decode('¿Qué consideras que podríamos mejorar en este curso? '),$format );

	$worksheet2->write($fila + 5, 2, $Elem['p1'],$format );
	$worksheet2->write($fila + 6, 2, $Elem['p2'],$format );
	$worksheet2->write($fila + 7, 2, $Elem['p3'],$format);
	$worksheet2->write($fila + 8, 2, $Elem['p4'],$format);
	$worksheet2->write($fila + 9, 2, $Elem['p5'],$format);
	$worksheet2->write($fila + 10, 2, utf8_decode($Elem['p6']),$format);

	$fila = $fila + 12;
}

$worksheet->setColumn(1,1,70);
$worksheet2->setColumn(1,2,60);

$workbook->close();