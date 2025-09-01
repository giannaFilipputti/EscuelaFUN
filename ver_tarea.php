<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id_curso = $_POST['id_curso'];
$id_modulo = $_POST['id_modulo'];
$id_capitulo = $_POST['id_capitulo'];

$sql = "SELECT nombre,descripcion,fecha_entrega,comentario 
          FROM com_tareas 
         WHERE curso = $id_curso AND modulo = $id_modulo AND capitulo = $id_capitulo 
         LIMIT 1";

$cont = $db->run($sql);

if ($cont == 0) {
   
    $data[] = array();
    echo json_encode($data);

} else {
    
    $db = Db::getInstance();
    $data = $db->fetchAll($sql);
    echo json_encode($data);
    
}

?>