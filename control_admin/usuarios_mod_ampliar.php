<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
// echo $fechoy;
$nuevo_venci = strtotime($fechoy."+ 15 days");
$fec_nuevo = date("Y-m-d H:i:s",$nuevo_venci);
$nuevo_ini = strtotime($fec_nuevo."- 90 days");
$fec_nuevoi = date("Y-m-d H:i:s",$nuevo_ini);

$usuExam = new UsuarioExam();

$usuExam->getOne($alumno,$modulo);

if ($usuExam->row[0]['forzar_cierre'] == 1 && $usuExam->row[0]['aprobado'] == 0) {
	$usuExam->ampliarFechaById($fec_nuevoi,$usuExam->row[0]['id']);
}
$usuExam->ampliarFecha($fec_nuevoi,$alumno,$modulo);

 header("Location: usuarios_examenes.php?id=" . $alumno);
