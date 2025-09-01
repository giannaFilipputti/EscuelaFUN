<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$id = $_POST["id"];
$dni = $_POST["dni"];
$email = $_POST["email"];

$db = Db::getInstance();

$sql = "UPDATE com_registro set dni = '$dni', email = '$email' WHERE id = $id";

$db->run($sql);

$sql_1 = "UPDATE com_registro SET pass = LEFT(dni,length(dni)-2) WHERE id = $id";

$db->run($sql_1);

$sql_2 = "UPDATE com_registro SET pass = sha1(md5(pass)) WHERE id = $id";

$db->run($sql_2);

$arreglo = array("data" => "Dni de alumno actualizado");

echo json_encode($arreglo);

?>