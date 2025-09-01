<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$curso = $_POST['id_curso'];
$modulo = $_POST['id_modulo'];
$usuario = $authj->rowff['id'];
$comentario = $_POST['comentario'];
$fecha = date('Y-m-d H:i:s', strtotime('-3 hours'));

$query = "INSERT INTO com_comentarios (curso,modulo,usuario,comentario,fecha,principal)
               VALUES ($curso,$modulo,$usuario,'$comentario','$fecha',1)";

$db->run($query);

?>