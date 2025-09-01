<?php 

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$capitulo = new Capitulo();
$capitulo->modificarEstado($st,$id);


header("Location: capitulos.php?id=".$ref."&ref=".$curso); ?>