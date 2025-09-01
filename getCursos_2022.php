<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
//require_once 'lib/auth.php';

$db = Db::getInstance();

$sql = "SELECT id,titulo FROM com_cursos_2022 WHERE estado = 1 ORDER BY orden";

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