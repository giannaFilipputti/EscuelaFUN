<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id_usuario = $_POST['id_usuario'];

$data = json_decode(stripslashes($_POST['data']));

foreach($data as $curso){

    $query = "INSERT INTO com_cursos_registro (curso,usuario) VALUES ($curso,$id_usuario)";

    $cont = $db->run($query);
}

$success = ["success" => $id_usuario];
echo json_encode($success);

?>