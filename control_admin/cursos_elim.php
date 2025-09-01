<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$curso = new Curso();

$curso->eliminar($id);