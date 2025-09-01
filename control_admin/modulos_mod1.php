<?php /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
	  
$mod = new Modulo();

  if (empty($acreditado)) {
	$acreditado = 0;
}
if (empty($ex_unico)) {
	$ex_unico = 0;
}

  if (empty($solicitada)) {
	$solicitada = 0;
}
$mod->modificar($titulo,$titulo_diploma,$subtitulo, $descripcion, $intro, $video, $porc_aprob, $preg_aprob,$preg_pag, $creditos, $no_acred, $horas, $periodo, $acred_desde, $acred_hasta, $acreditado , $solicitada, $ex_unico, $color, $id);
  // $sqlp = "UPDATE com_cursos_mod SET titulo = '". $titulo ."', titulo_diploma = '". $titulo_diploma ."', subtitulo = '". $subtitulo ."', descripcion = '". $descripcion ."', intro = '". $intro ."', video = '". $video ."', porc_aprob = '". $porc_aprob ."', preg_aprob = '". $preg_aprob ."', preg_pag = '". $preg_pag ."', creditos = '". $creditos ."', no_acred = '". $no_acred ."', horas = '". $horas ."', periodo = '". $periodo ."', acred_desde = '". $acred_desde ."', acred_hasta = '". $acred_hasta ."', acreditado = '". $acreditado ."', solicitada = '". $solicitada ."', examen_unico = '". $ex_unico ."', color = '". $color ."' WHERE id = ".$id."";
  
  //echo $sqlp;
  // $result = mysql_query ($sqlp,$link) or die("error".mysql_error());





header("Location: modulos.php?id=".$ref); ?>