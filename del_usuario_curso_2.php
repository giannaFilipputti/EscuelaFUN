<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id_usuario = $_POST['id_usuario'];

$data = json_decode(stripslashes($_POST['data']));

foreach($data as $curso){

    $query = "DELETE FROM com_cursos_registro WHERE curso = $curso AND usuario = $id_usuario";

    $cont = $db->run($query);
}

$success = ["success" => $id_usuario];
echo json_encode($success);

?>