<?php
ini_set('display_errors', '1');
$page = 'modulo';

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

require 'vendor/autoload.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;


define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');
define('PATH_TO_ATTACH_FILE', __FILE__);

if ($pago == 4) {
}

$curs = new Curso();
$cursos = $curs->getCursosPreinscritos($authj->rowff['id']);

if (count($cursos) > 1 && $pago == 4) {
    header("Location: curso_basket.php?err=pago4-1");
    die();
}

$getPrecio = Alumno::getPrecio($authj->rowff['tipouser'], $authj->rowff['pais']);



$arrPre = array();
$total = 0;
$cursosT = "";
foreach ($cursos as $Elem) {
    $total = $total + $Elem[$getPrecio];
    if (!empty($cursosT)) {
        $cursosT .= "-";
    }
    $cursosT .= $Elem['idC'];
}

// echo $precio ." - ".$total;
if ($pago == 4) {

    $cod = new Codigo();
    $codg = $cod->getOne($codigo);
    if (empty($codg) or empty($codigo)) { 
        header("Location: curso_basket.php?err=pago4-3");
        die();

    }
    else if ($codg['usado'] == 1) {
        header("Location: curso_basket.php?err=pago4-2");
        die();
    } else {


        $total = 0;
        $idpago = Curso::registrarPago($authj->rowff['id'], $cursosT, $fechoy, $usu_tipo, $pago, $total);

        $data4 = array(
            'estadopago' => 2,
            'floworder' => $codigo,
            'idpago' => $idpago

        );

        $prerequisitos = Curso::validPrerequisitos($cursos[0]['idC'], $authj->rowff['id']);
        
        if (($cursos[0]['acred_pre'] == 1 && $prerequisitos['estado'] == 1) || $cursos[0]['acred_pre'] == 0) {
            $data4['estado'] = '1';

            if ($fechoy >= $cursos[0]['fecha']) {
                $data4['fecini'] = $fechoy;
            } else {
                $data4['fecini'] = $cursos[0]['fecha'];
            }
        
            //echo $acred_hasta;
            $acred_hasta1 = strtotime($data4['fecini'] . "+ ".$cursos[0]['plazo']." days");
            $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
            $data4['fecfin'] = $acred_hasta;


        }

        Curso::actualizarPago($cursos[0]['idC'], $authj->rowff['id'], $data4);

        // se inserta en el mailing list
        // API credentials from https://login.sendpulse.com/settings/#api

        $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());


        $bookID = $cursos[0]['mailingID'];
        $emails = array(
            array(
                'email' => $authj->rowff['email'],
                'variables' => array(
                    'phone' => $authj->rowff['telefono'],
                    'ID' => $authj->rowff['id'],
                    'Nombre' => $authj->rowff['nombre'],
                    'Ape1' => $authj->rowff['ape1'],
                    'Ape2' => $authj->rowff['ape2'],
                    'Genero' => $authj->rowff['genero'],
                    'DNI' => $authj->rowff['dni'],
                    'Region' => Region::getRegion($authj->rowff['region']),
                    'porcentaje' => '0',
                    'Cursos' => $cursos[0]['titulo'],
                )
            )
        );
        /* $additionalParams = array(
			   'joinurl' => $joinurl,
			);*/
        // With confirmation
        $SPApiClient->addEmails($bookID, $emails);

        $SPApiClient = Null;

        // termina de insertar en el mailing list

        $data5 = array(
            'estadopago' => 2,
            'floworder' => $codigo
    
        );

        Curso::actualizarPagoG($idpago, $authj->rowff['id'], $data5);

        $cod->codigoUsado ($cursos[0]['idC'], $authj->rowff['id']);
        header("Location: miscursos.php");



    }
} else if ($precio == $total) {

    $idpago = Curso::registrarPago($authj->rowff['id'], $cursosT, $fechoy, $usu_tipo, $pago, $total);


    if ($pago == 1) {

        foreach ($cursos as $Elem) {
            Curso::updateIDPagoTransf($authj->rowff['id'], $Elem['id'], $idpago);
        }
        Curso::enviarEmail($authj->rowff['id'], $fechoy, $total, 1);
        header("Location: curso_basket.php");
    } else if ($pago == 2) {
        header("Location: enlinea.php?idpago=" . $idpago);
    } else if ($pago == 3) {
        header("Location: curso_basket.php");
    } else {
        // devolver y pedir seleccionar tipo de pago

    }
} else {
    header("Location: curso_basket.php");
}

    //echo $modulo.", ".$fechoy.", ".$usu_tipo.", ".$usu_institucion;
