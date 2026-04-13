<?php require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

require 'vendor/autoload.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');

if (!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid'])) {
    $paymentID = $_GET['paymentID'];
    $payerID   = $_GET['payerID'];
    $token     = $_GET['token'];
    $pid       = $_GET['pid'];

    $datos_log = "paymentID = " . $_GET['paymentID'] . " payerID = " . $_GET['payerID'] . " token = " . $_GET['token'] . " pid = " . $_GET['pid'];

    include('config_paypal.php');

    // 1. Obtener access token de PayPal
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, PayPalBaseUrl . "oauth2/token");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, PayPalClientId . ":" . PayPalSecret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    $tokenResult = curl_exec($ch);
    curl_close($ch);
    $tokenData   = json_decode($tokenResult, true);
    $accessToken = $tokenData['access_token'] ?? '';

    // 2. Consultar estado del pago con el paymentID recibido por GET
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, PayPalBaseUrl . "payments/payment/" . $paymentID);
    curl_setopt($ch2, CURLOPT_HEADER, false);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $accessToken,
        "Content-Type: application/json"
    ));
    $paymentResult = curl_exec($ch2);
    curl_close($ch2);
    $paymentData = json_decode($paymentResult, true);

    $paypalState  = $paymentData['state'] ?? '';
    $paypalAmount = $paymentData['transactions'][0]['amount']['total'] ?? '';

    // 2 = confirmado, 3 = error (igual que confirm.php)
    $response['status']    = ($paypalState === 'approved') ? 2 : 3;
    $response['flowOrder'] = $paymentID;
    $response['amount']    = $paypalAmount;

    $elUser  = $pid;
    $elUser1 = $authj->rowff['id'];

    $fechoy = date('Y-m-d H:i:s');

    $data4 = array(
        'estadopago' => $response['status'],
        'floworder'  => $paymentID,
        'respuesta'  => $datos_log,
        'idpago'     => $elUser
    );

    $data5 = array(
        'estadopago' => $response['status'],
        'floworder'  => $paymentID,
        'respuesta'  => $datos_log
    );

    $curs   = new Curso();
    $cursos = $curs->getCursosPreinscritos($elUser1);
    $datos  = Alumno::getDatos($elUser1);

    $arrPre  = array();
    $total   = 0;
    $cursosT = "";

    foreach ($cursos as $Elem) {
        $cursosT      .= $Elem['titulo'] . "<br>";
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

                $acred_hasta1    = strtotime($data4['fecini'] . "+ " . $Elem['plazo'] . " days");
                $data4['fecfin'] = date("Y-m-d H:i:s", $acred_hasta1);
            }

            Curso::actualizarPago($Elem['idC'], $elUser1, $data4, $elUser);

            // Agregar a Sendpulse
            try {
                $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
                $bookID = $Elem['mailingID'];
                $emails = array(
                    array(
                        'email'     => $datos['email'],
                        'variables' => array(
                            'phone'      => $datos['telefono'],
                            'ID'         => $datos['id'],
                            'Nombre'     => $datos['nombre'],
                            'Ape1'       => $datos['ape1'],
                            'Ape2'       => $datos['ape2'],
                            'Genero'     => $datos['genero'],
                            'DNI'        => $datos['dni'],
                            'Region'     => Region::getRegion($datos['region']),
                            'porcentaje' => '0',
                            'Cursos'     => $Elem['titulo'],
                        )
                    )
                );
                $SPApiClient->addEmails($bookID, $emails);
                $SPApiClient = null;
            } catch (Exception $eSP) {
                file_put_contents(__DIR__ . '/paypal_log.txt', date('Y-m-d H:i:s') . " SENDPULSE_ERROR: " . $eSP->getMessage() . "\n", FILE_APPEND);
            }
        }
    }

    Curso::actualizarPagoG($elUser, $elUser1, $data5);

    // Enviar email de confirmación
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

        $nota .= "<br>El monto cancelado es: USD$ " . $response['amount'] . " <br><br>
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
        $mail->Host = $mailhost;
        if (!empty($mailsecure)) {
            $mail->SMTPSecure = $mailsecure;
        }
        if (!empty($mailport)) {
            $mail->Port = $mailport;
        }
        $mail->From     = $mailemail;
        $mail->FromName = "PULPRO";
        $mail->Subject  = $app_title;
        $mail->AltBody  = $app_title;
        $mail->IsHTML(true);
        $mail->MsgHTML($nota);
        $mail->addReplyTo('info@pulpro.com', 'Capacitaciones Pulpro');
        $mail->AddAddress($datos['email'], $datos['email']);
        $mail->AddBCC('filipputti@pulpro.com', 'test');
        $mail->SMTPAuth = true;
        $mail->Username = $maillogin;
        $mail->Password = $mailpass;
        $mail->Send();
    }

    header('Location: cursos.php');
    exit;

} else {
    header('Location: index.php');
    exit;
}
