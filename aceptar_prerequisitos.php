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
require_once 'lib/auth.php';






/*
print_r($cursos);
echo "<br>";*/

$curs = New Curso();

$cursoId = $curs->getOne($curso);

$inscrito = Curso::getInscritoCurso($curso, $usuario);

$data4 = array(
    'validprerequisitos' => 1

);


$nota_adic = "";
if ($inscrito[0]['estadopago'] ==2) {
    $data4['estado'] = '1';
    $nota_adic = "Ya está confirmada su inscripción en el curso";

    if ($fechoy >= $cursoId['fecha']) {
        $data4['fecini'] = $fechoy;
    } else {
        $data4['fecini'] = $cursoId['fecha'];
    }

    //echo $acred_hasta;
    $acred_hasta1 = strtotime($data4['fecini'] . "+ ".$cursoId[0]['plazo']." days");
    $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
    $data4['fecfin'] = $acred_hasta;

} else {
    $nota_adic = "Si aún no has realizado el pago, puedes ingresar a la plataforma para formalizar la inscripción de tu curso y asegurar tu cupo.<br><br>";
}

Curso::aceptarPrerequisitos($curso, $usuario, $data4);






    $datos = Alumno::getDatos($usuario);

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
    Se han validado sus pre-requisitos para el curso <br>" . $cursoId['titulo'] . ".<br><br>";

    $nota .= $nota_adic;

    $nota .= "</font><br><br>
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
    

    $mail->SMTPDebug = 0;
    // 0 = no output, 1 = errors and messages, 2 = messages only.

    $mail->Host = $mailhost;
    if (!empty($mailsecure)) {
        $mail->SMTPSecure = $mailsecure;
    }
    if (!empty($mailport)) {
        $mail->Port = $mailport;
    }


    $mail->CharSet = 'UTF-8';

    $mail->From = $mailemail;


    $mail->FromName = $mailfrom;

    $mail->Subject = "Pre-requisitos validados";

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




// AQUI TERMINA EL CODIGO
header("Location: reporte_cursos.php?id=".$curso."&estado=".$estadoref);



