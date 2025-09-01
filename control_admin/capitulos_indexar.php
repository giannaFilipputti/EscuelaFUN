<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$capitulo = new Capitulo();
$capitulo->getOne($id);

// $sql_cap = "SELECT * FROM com_cursos_mod_cap WHERE id=" . $id . "";
// $result_cap = mysql_query($sql_cap);
// $row_cap = mysql_fetch_array($result_cap);

$mod = new Modulo();
$mod->getOne($capitulo->row[0]['modulo']);

// $sql_mod = "SELECT * FROM com_cursos_mod WHERE id=" . $row_cap['modulo'] . "";
// $result_mod = mysql_query($sql_mod, $link);
// $row_mod = mysql_fetch_array($result_mod);

$curso = $mod->row[0]['curso'];

$pagina = new Pagina();
$pagina->getAll($id);
$indexador = new Indexador();

$texto_limpio = "";
// $sql_1 = "SELECT * FROM com_capitulo_contenidos WHERE capitulo = " . $id . " ORDER BY orden";
// $result_1 = mysql_query($sql_1);

foreach ($pagina->row as $Elem) {
	$texto_limpio .= " " . strip_tags($Elem['contenido']);
}

$indexador->getAll($Elem['id'], $capitulo->tabla);

// $sql_ind = "SELECT * FROM com_indexador WHERE tabla='com_cursos_mod_cap' AND id_tabla = " . $id . "";
// $result_ind = mysql_query($sql_ind);

$texto = $texto_limpio . " " . $Elem['titulo'] . " " . $Elem['titulo_eng'] . " " . $Elem['autor'] . " " . $Elem['resena_autor'] . " " . $Elem['revista'] . " " . $Elem['tema'];
if (!empty($indexador->row)) {
	foreach ($indexador->row as $ElemIndexa) {
		$indexador->modificar($texto, $curso, $id);
	}
} else {
	$tabla = "com_cursos_mod_cap";
	$indexador->agregar($capitulo->row[0]['id'], $tabla, $texto, $curso);
}


header("Location: capitulos.php?id=" . $ref . "&ref=" . $curso);
