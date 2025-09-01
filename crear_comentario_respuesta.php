<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$curso = $_POST['id_curso'];
$modulo = $_POST['id_modulo'];
$capitulo = $_POST['id_capitulo'];
$usuario = $authj->rowff['id'];
$comentario = $_POST['comentario'];
$fecha = date('Y-m-d H:i:s', strtotime('-3 hours'));
$id_comentario = $_POST['id_comentario'];

$query = "INSERT INTO com_comentarios (curso,modulo,usuario,comentario,fecha,respuesta)
               VALUES ($curso,$modulo,$usuario,'$comentario','$fecha',$id_comentario)";

$db->run($query);

?>