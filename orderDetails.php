<?php require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) ){
	$paymentID = $_GET['paymentID'];
        $payerID = $_GET['payerID'];
        $token = $_GET['token'];
        $pid = $_GET['pid'];
		
		$datos = "paymentID = ".$_GET['paymentID']." payerID = ".$_GET['payerID']." token = ".$_GET['token']." pid = ".$_GET['pid'];
	
					
        

        $response['status'] = 2;

    $elUser = $pid;

    $elUser1 = $authj->rowff['id'];

    $data4 = array(
        'estadopago' => 2,
        'floworder' => $paymentID,
        'respuesta' => $datos,
        'idpago' => $elUser

    );


    $data5 = array(
        'estadopago' => 2,
        'floworder' => $paymentID,
        'respuesta' => $datos

    );


    $curs = new Curso();
    $cursos = $curs->getCursosPreinscritos($elUser1);




                                $arrPre = array();
                                $total = 0;
                                $cursosT = "";
                                foreach ($cursos as $Elem) {
                                    $cursosT .= $Elem['titulo']."<br>";
                                    $prerequisitos = Curso::validPrerequisitos($Elem['idC'], $elUser1);
                                    $data4['estado'] = '0';
                                    if ($response['status'] == 2) {
                                        if (($Elem['acred_pre']==1 && $prerequisitos['estado']==1) || $Elem['acred_pre']==0) { 
                                            $data4['estado'] = '1';
                                        }
                                        
                                        Curso::actualizarPago($Elem['idC'],$elUser1, $data4, $elUser);
                                    }
                                }


                               /* $chequeo = "empezamos";
                    $file = fopen("archivo.txt", "w");

    fwrite($file, $chequeo." idpago ".$elUser." . usuario".$elUser1);

    fclose($file);*/


                                


                                Curso::actualizarPagoG( $elUser,$elUser1, $data5);


    //$db4->update('com_pagos', $data4, 'id = :id', array(':id' => $elUser));



   


    // envia el email 
    if ($response['status'] == 2) {

        $datos = Alumno::getDatos($elUser1);

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
        El pago para de la inscripción del (los) curso(s) <br>" . $cursosT . "<br> fue procesado, el numero de confirmación es:" . $response['flowOrder']."<br><br>";



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


        $mail->FromName = "PULPRO";

        $mail->Subject = $app_title;

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


           
         
    } else {
        header('Location:index.php');
    } 