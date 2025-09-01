<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
if (empty($ex_unico)) {
	$ex_unico = 0;
}

$curso->modificar($id,$titulo, $fechoy,$bienvenida, $ex_unico ,$con , $zon);



// header("Location: cursos.php"); ?>