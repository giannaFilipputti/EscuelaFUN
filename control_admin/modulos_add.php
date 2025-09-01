<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

if (empty($solicitada)) {
  $solicitada = 0;
}

$mod = new Modulo();



$mod->getModOrden($curso);

$orden=$mod->row[0]['orden'];

// CONTENIDO PAGINA
if ($orden == 0) {
  $orden = 1;
} else {
  $orden = $orden + 1;
}

// if ($ex_unico == 1) {
//   $sqlp1 = "UPDATE com_cursos_mod SET examen_unico = '0' WHERE curso=" . $curso . "";
//   $result1 = mysql_query($sqlp1, $link);
// }

$mod->modificarExUnico($curso);

if (empty($acreditado)) {
  $acreditado = 0;
}
if (empty($ex_unico)) {
  $ex_unico = 0;
}


$mod->agregar( $curso,$titulo, $titulo_diploma , $subtitulo ,$descripcion, $intro,$video, $fechoy ,$orden , $porc_aprob, $preg_aprob, $preg_pag , $creditos, $no_acred, $horas, $periodo, $acred_desde,$acred_hasta,$acreditado,$solicitada, $ex_unico, $color, $cantpreg);


// $result = mysql_query("INSERT INTO com_cursos_mod (curso, titulo, titulo_diploma, subtitulo, descripcion, intro, video, estado, fecha, orden, porc_aprob, preg_aprob, preg_pag, creditos, no_acred, horas, periodo, acred_desde, acred_hasta, acreditado, solicitada, examen_unico, color) VALUES ('" . $curso . "','" . $titulo . "','" . $titulo_diploma . "','" . $subtitulo . "','" . $descripcion . "','" . $intro . "','" . $video . "','1','" . $fechoy . "','" . $orden . "','" . $porc_aprob . "','" . $preg_aprob . "','" . $preg_pag . "','" . $creditos . "','" . $no_acred . "','" . $horas . "','" . $periodo . "','" . $acred_desde . "','" . $acred_hasta . "','" . $acreditado . "','" . $solicitada . "','" . $ex_unico . "','" . $color . "')", $link) or die("el error es en el insert: " . mysql_error());
header("Location: modulos.php?id=" . $curso);
