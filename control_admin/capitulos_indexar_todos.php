<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->getOne($modulo);

$capitulo = new Capitulo();
$capitulo->getAll($modulo);

$pagina = new Pagina();

$indexador = new Indexador();

foreach ($capitulo->row as $Elem) {

	$texto_limpio = "";
	$curso = $mod->row[0]['curso'];

	$pagina->getAll($Elem['id']);

	foreach ($pagina->row as $ElemPagina) {
		$texto_limpio .= " " . strip_tags($ElemPagina['contenido']);
	}
	
	$indexador->getAll($Elem['id'],$capitulo->tabla);

	$texto = $texto_limpio . " " . $Elem['titulo'] . " " . $Elem['titulo_eng'] . " " . $Elem['autor'] . " " . $Elem['resena_autor'] . " " . $Elem['revista'] . " " . $Elem['tema'];
	if(!empty($indexador->row)){
		foreach($indexador->row as $ElemIndexa){
			$indexador->modificar($texto,$curso,$id);
		}
	}else{
		$tabla = "com_cursos_mod_cap";
		$nombre = "";
		$indexador->agregar($capitulo->row[0]['id'],$tabla,$texto,$curso,$nombre);
	}

}


header("Location: capitulos.php?id=" . $modulo."&ref=".$ref);
