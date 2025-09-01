<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

require 'vendor/autoload.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;


define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
			define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');
			define('PATH_TO_ATTACH_FILE', __FILE__);

            
$page = "registro";
$scripts = "none";
//include('head.php');
//$idVideo = Recursos::getOne($video);
$resp = Capitulo::videoTrack($user, $video, $porcentaje, $segundos, $segundos_cap, $segundos_mod, $segundos_cur, $id_mod, $id_cur);
//$eventos = $prox->row[0];
//print_r($eventos);
//echo $eventos['link_zoom'];


$avance_cur = $resp['curso'];

//$avance_cur = 30;

//$avance_cur = $resp['curso'];

 // se inserta en el mailing list
    // API credentials from https://login.sendpulse.com/settings/#api
			
    $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
			
  
     $bookID = $mailing_curso;
     $emails = array(
        array(
            'email' => $authj->rowff['email'],
            'variables' => array(
                'phone' => $authj->rowff['telefono'],
                'ID' => $authj->rowff['id'],
                'Ape1' => $authj->rowff['ape1'],
                'Ape2' => $authj->rowff['ape2'],
                'Genero' => $authj->rowff['genero'],
                'Region' => Region::getRegion($authj->rowff['region']),
                'porcentaje' => $avance_cur
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

echo json_encode($resp);
