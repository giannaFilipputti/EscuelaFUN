<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';



$acred = new Acreditaciones();
$acred->modificar($id, $creditos, $no_acred, $horas, $periodo, $acred_desde, $acred_hasta);	  



header("Location: modulos_acred.php?id=".$modulo."&ref=".$ref); ?>