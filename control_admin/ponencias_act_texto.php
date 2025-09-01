<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

extract($_GET);

$pagina = new Pagina();
$pagina->getOne($id);

$capitulo = new Capitulo();
$capitulo->getOne($pagina->row[0]['capitulo']);

$mod = new Modulo();
$mod->getOne($capitulo->row[0]['modulo']);


$curso = $mod->row[0]['curso'];

/*$sql_cur = "SELECT * FROM com_cursos_mod WHERE id=".$row_mod['curso']."";
          $result_cur = mysql_query($sql_cur,$link);
		  $row_cur = mysql_fetch_array($result_cur);*/


$diapo = new Diapositiva();
$diapo->getAll($id);
// $sql = "SELECT * FROM com_ponencias_ima WHERE ponencia=" . $id . " ORDER BY tiempo";
// //echo $sql;
// $result = mysql_query($sql, $link);




foreach ($diapo->row as $Elem) {


	$tiempo = $_POST['text_' . $Elem['id']];

	$tiempo_limpio = strip_tags($tiempo);

	$diapo->modificarTexto(addslashes($tiempo),addslashes($tiempo_limpio),$Elem['id']);
	
	// $sql1 = "UPDATE com_ponencias_ima SET texto_html = '" . addslashes($tiempo) . "', texto = '" . addslashes($tiempo_limpio) . "' WHERE id = " . $row['id'] . "";

	//echo $sql1."<br>";

	// $result1 = mysql_query($sql1, $link) or die("el error es en el insert 49: " . mysql_error());


	$sqlhh = "SELECT * FROM com_ponencias_ima WHERE id=" . $row['id'] . "";

	$oneDiapo = new Diapositiva();
	$oneDiapo->getOne($Elem['id']);
	// $resulthh = mysql_query($sqlhh, $link);
	// $rowhh = mysql_fetch_array($resulthh);

	$texto = $oneDiapo->row[0]['comentario_limpio'] . '/n/n' . $oneDiapo->row[0]['texto'];




	$sqlhg = "SELECT * FROM com_indexador WHERE id_tabla=" . $rowhh['id'] . " AND tabla = 'com_ponencias_ima'";

	//echo $sqlhg."<br>";

	$indexador = new Indexador();
	$indexador->getAll($oneDiapo->row[0]['id'], $oneDiapo->tabla);

	$texto =  $Elem['comentario_limpio'] . " " . $texto ;

	if (!empty($indexador->row)) {
		foreach ($indexador->row as $ElemIndexa) {
			$indexador->modificarTexto($texto, $curso,$pagina->row[0]['titulo'], $ElemIndexa['id']);
		}
	} else {
		$tabla = "com_ponencias_ima";
		// echo $oneDiapo->row[0]['id'];
		if ($oneDiapo->row[0]['nombre'] != null) {
			$indexador->agregarTexto($oneDiapo->row[0]['id'], $oneDiapo->tabla, $texto, $oneDiapo->row[0]['nombre'],$curso,$pagina->row[0]['titulo']);
			
		}
	}

}

header("Location: ponencias_texto.php?id=" . $id);
