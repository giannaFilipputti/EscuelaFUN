<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$id_usuario = $_POST['id_usuario'];
$id_curso = $_POST['id_curso'];
$id_modulo = $_POST['id_modulo'];
$id_capitulo = $_POST['id_capitulo'];

$db = Db::getInstance();

$sql = "SELECT ANY_VALUE(com_tareas_archivos.fecha_subida) as fecha_subida,
               GROUP_CONCAT( concat( com_tareas_archivos.ruta) SEPARATOR ',') as ruta
        FROM com_registro
        JOIN com_cursos_registro on com_cursos_registro.usuario = com_registro.id AND com_cursos_registro.curso = $id_curso
        LEFT JOIN com_tareas_archivos on com_tareas_archivos.usuario = com_registro.id AND com_tareas_archivos.curso = $id_curso 
              AND com_tareas_archivos.modulo = $id_modulo AND com_tareas_archivos.capitulo = $id_capitulo
        WHERE com_tareas_archivos.usuario = $id_usuario
        GROUP BY com_tareas_archivos.usuario,com_registro.id";

$cont = $db->run($sql);

if ($cont == 0) {
   
    $arreglo = array("data" => "");

} else {
    
    $db = Db::getInstance();
    $arreglo["data"] = $db->fetchAll($sql);
    
}

echo json_encode($arreglo);

?>