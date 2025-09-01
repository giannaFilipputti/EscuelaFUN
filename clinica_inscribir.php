<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";

require 'vendor/autoload.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;


define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');
define('PATH_TO_ATTACH_FILE', __FILE__);

$datos = Alumno::getDatos($authj->rowff['id']);

/*
if($authj->rowff['cambiopass'] == 0){

    header("location: misdatos_pass.php");
        
}*/

$curs = new Presenciales();
$cursos = $curs->getOne($id);

if ($authj->rowff['pais'] != 19) {
    $precio_curso = $cursos[0]['precio1'];
}
else if ($authj->rowff['tipouser'] == 2) {
    $precio_curso = $cursos[0]['precio2'];
} else if ($authj->rowff['tipouser'] == 3) {
    $precio_curso = $cursos[0]['precio3'];
} else {
    $precio_curso = $cursos[0]['precio'];
}

$estado = 0;
$fecini = Null;
$fecfin = Null;
if ($precio_curso == 0) {
    $estado = 1;

    if ($fechoy >= $cursos[0]['fecha']) {
        $fecini = $fechoy;
    } else {
        $fecini = $cursos[0]['fecha'];
    }

    //echo $acred_hasta;
    $acred_hasta1 = strtotime($fecini . "+ ".$cursos[0]['plazo']." days");
    $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
    $fecfin = $acred_hasta;


}


$curs->preinscribir($id, $authj->rowff['id'], $estado, $authj->rowff['tipouser'], 0, $fecini, $fecfin);

/*
if ($estado == 1) {
    

            $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

           
            $bookID = $cursos[0]['mailingID'];
            $emails = array(
                array(
                    'email' => $datos['email'],
                    'variables' => array(
                        'phone' => '',
                        'ID' => $datos['id'],
                        'Nombre' => $datos['nombre'],
                        'Ape1' => $datos['ape1'],
                        'Ape2' => $datos['ape2'],
                        'Genero' => $datos['genero'],
                        'DNI' => $datos['dni'],
                        'Region' => Region::getRegion($datos['region']),
                        'porcentaje' => '0',
                        'Cursos' => $cursos[0]['titulo'],
                    )
                )
            );
           
            $SPApiClient->addEmails($bookID, $emails);

            $SPApiClient = Null;

           
}*/


header("Location: clinicas.php");

?>