<?php 

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$acred = new Acreditaciones();
$acred->eliminar($id,$ref,$curso);



header("Location: modulos_acred.php?id=".$ref."&ref=".$curso); ?>