<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$id = $_POST["id"];

$db = Db::getInstance();

$db4 = Db::getInstance();

$sql = "SELECT email, genero FROM generos";

$cont = $db->run($sql);

if ($cont == 0) {
   
    //$arreglo = array("data" => "");

} else {
    
    $db = Db::getInstance();
    $data = $db->fetchAll($sql);
    foreach ($data as $Elem) {


        echo "Genero: ".$Elem['genero']." , email: ".$Elem['email'];
                            $data4 = array(
                            'genero' => $Elem['genero']

                            );
                            
                            $db4->update('com_registro', $data4, 'email = :email', array(':email' => $Elem['email']));

    }
}



?>