<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->modificarEstado($st,$id);


header("Location: modulos.php?id=".$ref); ?>