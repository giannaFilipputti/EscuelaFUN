<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id_usuario = $_POST['id_usuario'];

$data = json_decode(stripslashes($_POST['data']));

foreach($data as $curso){

    $query_select = "SELECT GROUP_CONCAT(id) as id_cursos FROM com_cursos_mod WHERE curso = $curso";
    $db->run($query_select);
    
    $result = $db->fetchAll($query_select);
    
    foreach($result as $row) {
        
        $id_cursos = $row['id_cursos'];
    
    }

    $query = "UPDATE com_cursos_mod_cap SET profesor = $id_usuario WHERE modulo IN ($id_cursos)";
    $db->run($query);
}

$success = ["success" => $id_usuario];
echo json_encode($success);

?>