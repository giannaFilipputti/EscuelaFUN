<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once('api_zoom/jwt.php');

require_once 'lib/autoloader.class.php';

require_once 'lib/init.class.php';

require 'vendor/autoload.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');
define('PATH_TO_ATTACH_FILE', __FILE__);

//require_once '../lib/authAdmin.php';

//$codigo ="83490073117";
//$evento = 23;
$curso = 28;


$codigo = "88979953947";




$reporte = new Curso();
$report = $reporte->reporteAlumnos_3($curso, $estado);



// Creating a workbook


//$worksheet->setInputEncoding('UTF8');

// Creating a worksheet

// Access the environment variables
$clientId  = 'M4A7N3gbSAyqe5pNyPnsrw';

$clientSecret  = 'uX4jH4WF9N4IYieNerEl7S5PoJszIeC9';
$accountId = 'whL4DPnDTYiPO9fbTNZ85A';
$oauthUrl = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $accountId;  // Replace with your OAuth endpoint URL

function getAccessToken()
{
    global $clientSecret, $clientId, $oauthUrl;


    try {
        // Create the Basic Authentication header
        $authHeader = 'Basic ' . base64_encode($clientId . ':' . $clientSecret);
        echo "authHeader: " . $authHeader .  PHP_EOL;
        // Initialize cURL session
        $ch = curl_init($oauthUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $authHeader));

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check if the request was successful (status code 200)
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            // Parse the JSON response to get the access token
            $oauthResponse = json_decode($response, true);
            $accessToken = $oauthResponse['access_token'];
            return $accessToken;
        } else {
            echo 'OAuth Request Failed with Status Code: ' . $httpCode . PHP_EOL;
            echo $response . PHP_EOL;
            return null;
        }

        // Close cURL session
        curl_close($ch);
    } catch (Exception $e) {
        echo 'An error occurred: ' . $e->getMessage() . PHP_EOL;
        return null;
    }
}

$token = getAccessToken();

echo "TOKEN:<br>";

print_r($token);
echo "FIN TOKEN:<br>";

//SecondPage($useremail,$token);
$id_pw_found = 1;


$hashLenght = 6;
// Array con los elementos que se emplean para crear un HASH ALEATORIO
$tokensArray = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
// Función para generar una cadena pseudo-aleatoria con semilla de tiempo
function createhash($tokens, $length)
{
    $hashcode = "";
    for ($c = 0; $c < $length; $c++) {
        srand((float)microtime() * 100000000000);
        $pass = $tokens[rand(0, count($tokens) - 1)];
        $hashcode = $hashcode . $pass;
    }
    return $hashcode;
}


/*$worksheet->write(1, 0, 'John Smith');
$worksheet->write(1, 1, 30);
$worksheet->write(2, 0, 'Johann Schmidt');
$worksheet->write(2, 1, 31);
$worksheet->write(3, 0, 'Juan Herrera');
$worksheet->write(3, 1, 32);*/
$fila = 0;

echo "Codigo" . $codigo . "<br><br>";

foreach ($report as $Elem) {

    //$objPHPExcel->createSheet();





    //$porciones = explode(" ", $pizza);
    if (empty($Elem['joinurl']) or $Elem['joinurl'] == 'x') {

        echo "Entra " . $Elem['region'] . " - " . $Elem['id'] . " " . $Elem['ape1'] . " " . $Elem['email'] . "<br>";

        $arr = array('email' => trim($Elem['email']), 'first_name' => $Elem['nombre'], 'last_name' => $Elem['ape1'] . " " . $Elem['ape2']);



        $data = json_encode($arr);
        $curl = curl_init();
        $user = 'lezama@pulpro.com';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/meetings/" . $codigo . "/registrants",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $token,
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            print_r($response);

            $obj = json_decode($response);

            $joinurl = $obj->{'join_url'};

            $reporte->updateJoinURL($Elem['id'], $curso, $joinurl);


            /*$file = fopen("botones/1_".$Elem['id'].".txt", "w");

            fwrite($file, $joinurl);

            fclose($file);*/

            echo $joinurl;

            echo "<br>";
        }
    } else {
        $joinurl = $Elem['joinurl'];
    }

    if (empty($Elem['clave'])) {
        $ingreso = "no";
    } else {
        $ingreso = "si";
    }

    //if ($Elem['id'] == 2157) {

    $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

    /*
			 * Example: Get Mailing Lists
			 */
    //var_dump($SPApiClient->listAddressBooks());

    /*
			 * Example: Add new email to mailing lists
			 */
    $bookID = 1592651;
    $emails = array(
        array(
            'email' => $Elem['email'],
            'variables' => array(
                'joinurl' => $joinurl
            )
        )
    );
    $additionalParams = array(
        'joinurl' => $joinurl,
    );
    // With confirmation
    $respuesta = $SPApiClient->addEmails($bookID, $emails);
    $SPApiClient = Null;

    print_r($respuesta);
    echo "<br><br>";
    //}



    /* se termina de guardar en el mailing list*/




    unset($arr);

    $fila++;

    echo "entro";
}

echo $fila;
    

// Let's send the file
