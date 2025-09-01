<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';


$id = $ifilter->process($_GET['id']);

$exam = new Examen();
$exam->deletePregunta($id,$ref);


// $result = mysql_query ("DELETE FROM com_exam_preg WHERE id = ".$id."",$link);
// $result = mysql_query ("DELETE FROM com_exam_resp WHERE pregunta = ".$id."",$link);


header("Location: examen.php?id=" . $ref."&ref=".$ref);
