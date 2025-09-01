<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$id = $_POST["id"];

$db = Db::getInstance();

$sql = "SELECT id,dni,email FROM com_registro WHERE id = $id";

$cont = $db->run($sql);

if ($cont == 0) {
   
    $arreglo = array("data" => "");

} else {
    
    $db = Db::getInstance();
    $data = $db->fetchAll($sql);
}

$arreglo["data"][] = $data;

echo json_encode($arreglo);

?>