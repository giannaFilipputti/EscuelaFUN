<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id_curso = $_POST['id_curso'];
$id_modulo = $_POST['id_modulo'];
$id_capitulo = $_POST['id_capitulo'];
$nombre_tarea = $_POST['nombre_tarea'];
$descripcion_tarea = $_POST['descripcion_tarea'];
$fecha_entrega_tarea = $_POST['fecha_entrega_tarea'];
$comentario_tarea = $_POST['comentario_tarea'];
$fecha_creacion = date('Y-m-d');

$query = "INSERT INTO com_tareas (curso,modulo,capitulo,nombre,descripcion,fecha_entrega,fecha_creacion,comentario)
               VALUES ($id_curso,$id_modulo,$id_capitulo,'$nombre_tarea','$descripcion_tarea','$fecha_entrega_tarea','$fecha_creacion','$comentario_tarea')";
$db->run($query);

?>