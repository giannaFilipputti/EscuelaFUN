<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

/**
 * Pagina del comercio para redireccion del pagador
 * A esta página Flow redirecciona al pagador pasando vía POST
 * el token de la transacción. En esta página el comercio puede
 * mostrar su propio comprobante de pago
 * 
 * 
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
			


$getUltPago = Curso::getPagoOne($id);

$elUser1 = $getUltPago['usuario'];

//echo $getUltPago['cursos']."<br>";

//$cursos = explode("-", $getUltPago['cursos']);

/*
print_r($cursos);
echo "<br>";*/

$curs = new Curso();

if ($estado == 3) {
    $estadoC = 0;
} else {
    $estadoC = 2;
}

$data4 = array(
    'estadopago' => $estadoC,
    'floworder' => $response['flowOrder'],
    'idpago' => $id

);

$data5 = array(
    'estadopago' => $estado

);

$datos = Alumno::getDatos($elUser1);

$cursos = $curs->getAll_CursosPagos($getUltPago['id']);

foreach ($cursos as $Elem) {

    // echo $Elem."<br>";

    //$cursoId = $curs->getOne($Elem);

    //echo "Curso ID: ".$cursoId[0]['id']."<br>";

    $cursosT .= $Elem['titulo'] . "<br>";
    $prerequisitos = Curso::validPrerequisitos($Elem['id'], $elUser1);
    $data4['estado'] = '0';
    if ($estado == 2) {
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

        /*echo "Array 1 ".$cursoId[0]['id'].", ".$elUser1;
        print_r($data4);*/

        Curso::actualizarPago($Elem['id'], $elUser1, $data4);

        // se inserta en el mailing list
    // API credentials from https://login.sendpulse.com/settings/#api
			
			$SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
			
			/*
			 * Example: Get Mailing Lists
			 */
			//var_dump($SPApiClient->listAddressBooks());
			
			/*
			 * Example: Add new email to mailing lists
			 */
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


/*echo  "Array 2 ".$id.", ".$elUser1;
print_r($data5);*/
Curso::actualizarPagoG($id, $elUser1, $data5);


if ($estado == 2) {

    

    require('includes/class.phpmailer.php');
    require('includes/class.smtp.php');


    $nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
<tr>
<td valign=\"top\" align=\"center\"><img src=\"" . $app_url . "img/logo.png\" alt=\"" . $apptitle . "\" width=\"166\" /></td>
</tr>
<tr>
<td valign=\"top\" align=\"left\">
 <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
 <tr>
   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
 
   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br><br>
    Estimado/a  " . $datos['nombre'] . " " . $datos['ape1'] . " " . $datos['ape2'] . " <br /><br />
    El pago para de la inscripción del (los) curso(s) <br>" . $cursosT . "<br> fue procesado.<br><br>";



    $nota .= "<br>El monto cancelado es: " . $getUltPago['monto'] . "</font><br><br>
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
    $mail->addReplyTo('info@pulpro.com', 'Capacitaciones Pulpro');

    $mail->AddAddress($datos['email'], $datos['email']);
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

    //Funcion::inscribirMailingList ($listaid, $datos['email'], $datos['id'], $datos['ape1'], $datos['ape2'], $datos['nombre'], $datos['genero'], $datos['dni'], '0');

    

}

// AQUI TERMINA EL CODIGO
header("Location: reporte_pagos.php");
