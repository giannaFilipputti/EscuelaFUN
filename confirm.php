<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

/**
 * Pagina del comercio para redireccion del pagador
 * A esta página Flow redirecciona al pagador pasando vía POST
 * el token de la transacción. En esta página el comercio puede
 * mostrar su propio comprobante de pago
 */
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
//require_once 'lib/auth.php';

require("lib/class/FlowApi.class.php");

require 'vendor/autoload.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;


define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');
define('PATH_TO_ATTACH_FILE', __FILE__);


function arrayToHTMLAttributes($aData_ = array())
{

    // Define un array temporal
    $aAttributes = array();

    // Recorre el array de entrada
    foreach ($aData_ as $sKey => $mValue_) {

        $aAttributes[] = $sKey . '="' . $mValue_ . '"';
    }

    // Une todos los elementos del aray temporal
    return ' ' . implode(' ', $aAttributes);
}



try {
    //Recibe el token enviado por Flow
    if (!isset($_POST["token"])) {
        throw new Exception("No se recibio el token", 1);
    }
    $token = filter_input(INPUT_POST, 'token');
    $params = array(
        "token" => $token
    );
    //Indica el servicio a utilizar
    $serviceName = "payment/getStatus";
    $flowApi = new FlowApi();
    $response = $flowApi->send($serviceName, $params, "GET");


    $db4 = Db::getInstance();
    $db5 = Db::getInstance();

    //print_r($response);

    $respuesta = arrayToHTMLAttributes($response);


    $fechoy = date('Y-m-d H:i:s');



    $elUser = $response['optional']['idpago'];

    $elUser1 = $response['optional']['usuario'];

    $data4 = array(
        'estadopago' => $response['status'],
        'floworder' => $response['flowOrder'],
        'respuesta' => $respuesta,
        'idpago' => $elUser

    );


    $data5 = array(
        'estadopago' => $response['status'],
        'floworder' => $response['flowOrder'],
        'respuesta' => $respuesta

    );


    $curs = new Curso();
    $cursos = $curs->getCursosPreinscritos($elUser1);

    $datos = Alumno::getDatos($elUser1);


    $arrPre = array();
    $total = 0;
    $cursosT = "";
    foreach ($cursos as $Elem) {
        $cursosT .= $Elem['titulo'] . "<br>";
        $prerequisitos = Curso::validPrerequisitos($Elem['idC'], $elUser1);
        $data4['estado'] = '0';
        if ($response['status'] == 2) {
            if (($Elem['acred_pre'] == 1 && $prerequisitos['estado'] == 1) || $Elem['acred_pre'] == 0) {
                $data4['estado'] = '1';
                
                if ($fechoy >= $Elem['fecha']) {
                    $data4['fecini'] = $fechoy;
                } else {
                    $data4['fecini'] = $Elem['fecha'];
                }

                //echo $acred_hasta;
                $acred_hasta1 = strtotime($data4['fecini'] . "+ ".$Elem['plazo']." days");
                $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
                $data4['fecfin'] = $acred_hasta;
            }

            Curso::actualizarPago($Elem['idC'], $elUser1, $data4, $elUser);

            // se inserta en el mailing list
            // API credentials from https://login.sendpulse.com/settings/#api

            $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

            
            $bookID = $Elem['mailingID'];
            $emails = array(
                array(
                    'email' => $datos['email'],
                    'variables' => array(
                        'phone' => $datos['telefono'],
                        'ID' => $datos['id'],
                        'Nombre' => $datos['nombre'],
                        'Ape1' => $datos['ape1'],
                        'Ape2' => $datos['ape2'],
                        'Genero' => $datos['genero'],
                        'DNI' => $datos['dni'],
                        'Region' => Region::getRegion($datos['region']),
                        'porcentaje' => '0',
                        'Cursos' => $Elem['titulo'],
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
        }
    }


    $chequeo = "empezamos";
    $file = fopen("archivo.txt", "w");

    fwrite($file, $chequeo . " idpago " . $elUser . " . usuario" . $elUser1);

    fclose($file);





    Curso::actualizarPagoG($elUser, $elUser1, $data5);


    //$db4->update('com_pagos', $data4, 'id = :id', array(':id' => $elUser));






    // envia el email 
    if ($response['status'] == 2) {

        

        require('includes/class.phpmailer.php');
        require('includes/class.smtp.php');


        $nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
<tr>
 <td valign=\"top\" align=\"center\"><img src=\"" . $app_url . "img/logo.png\" alt=\"" . $apptitle . "\" width=\"266\" /></td>
</tr>
<tr>
 <td valign=\"top\" align=\"left\">
	 <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
	 <tr>
	   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
	 
	   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br><br>
		Estimado/a  " . $datos['nombre'] . " " . $datos['ape1'] . " " . $datos['ape2'] . " <br /><br />
        El pago para de la inscripción del (los) curso(s) <br>" . $cursosT . "<br> fue procesado, el numero de confirmación es:" . $response['flowOrder'] . "<br><br>";



        $nota .= "<br>El monto cancelado es: " . $response['amount'] . " <br><br>
		.</font><br><br>
		 </font>
		</td>
	   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
	 </tr>
	 
	
	 
	 <tr>
	   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
	   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
	   Muchas gracias por su participacion.<br><br>

Cordialmente,<br><br>
Alianza FECHIDA - Capacitaciones Pulpro
<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
		</font>



		</td>
	   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
	 </tr>

	 </table>
 </td>
</tr>

</table>";

        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';

        $mail->SMTPDebug = 0;
        // 0 = no output, 1 = errors and messages, 2 = messages only.


        /* Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP*/
        $mail->Host = $mailhost;
        if (!empty($mailsecure)) {
            $mail->SMTPSecure = $mailsecure;
        }
        if (!empty($mailport)) {
            $mail->Port = $mailport;
        }




        $mail->From = $mailemail;


        $mail->FromName = $mailfrom;

        $mail->Subject = "Pago Procesado";

        $mail->AltBody = $app_title;
        $mail->IsHTML(true);

        $mail->MsgHTML($nota);

        /* Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. admin@domitienda.com  */
        //echo $usu_email."<br>".$mailemail."<br>".$maillogin."<br>".$mailpass."<br>".$mailhost;

        $mail->addReplyTo('info@pulpro.com', 'Capacitaciones Pulpro');

        $mail->AddAddress($rowff1[0]['email'], $rowff1[0]['email']);
        $mail->AddBCC('filipputti@pulpro.com', 'test');

        $mail->SMTPAuth = true;


        $mail->Username = $maillogin;
        $mail->Password = $mailpass;

        if (!$mail->Send()) {
            //echo "no se envio";
            //header("Location: gracias.php?err=1");
        } else {
            //echo "si se envio";
            // header("Location: gracias.php");
        }
        //header("Location: gracias.php?act=transferencia");


    }


    // termina de enviar el email


    //print_r($response);
    // header("Location: cursos.php");
} catch (Exception $e) {
    echo "Error: " . $e->getCode() . " - " . $e->getMessage();
}
