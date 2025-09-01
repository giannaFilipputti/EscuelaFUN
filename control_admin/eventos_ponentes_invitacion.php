<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n3.php");

require('../includes/class.phpmailer.php');
require('../includes/class.smtp.php');
				



 $resulter = mysql_query("SELECT * FROM com_alumnos_eventos WHERE id = ". $id."",$link) or die("el error es porque41: ".mysql_error());
            // aqui va el codigo
	if ($rower = mysql_fetch_array($resulter)){
				  
				  
		  $sql_ev = "SELECT * FROM com_eventos WHERE id = ".$evento."";
          $result_ev = mysql_query($sql_ev);
		  $row_ev = mysql_fetch_array($result_ev);
		  
		  
	     $sql_ma = "SELECT * FROM com_mailformato LIMIT 1";
          $result_ma = mysql_query($sql_ma);
		  $row_ma = mysql_fetch_array($result_ma);
		   $formato = $row_ma['codigo_pon'];
		  
		  
         $sql_user = "SELECT * FROM com_alumnos WHERE id = ".$rower['alumno']." LIMIT 1";
          $result_user = mysql_query($sql_user);
    
          if ($row_user = mysql_fetch_array($result_user)) {
			  
			   $porciones = explode("*", $row_ev['delegados']);
			   $losdelegados = '';
			
			    $haydel = 0;
				foreach ($porciones as $s) {
				if (!empty($s)) {
					if ($haydel == 0) {
				      $sql_del = "SELECT * FROM com_users WHERE id = ".$s;
                      $result_del = mysql_query($sql_del);
				 
				     $haydel = 1;
					}
				}
				}
				
			
			

              $row_del = mysql_fetch_array($result_del);
		  
		
		  
		  $phrase  = $formato;
$healthy = array("XXXIDXXX", "XXXNOMBREXXX", "XXXFECHAXXX", "XXXSEDEXXX", "XXXDIRECCIONXXX", "XXXDELEGADOXXX", "XXXEMAILDELXXXX", "XXXEMAILXXX", "XXXIDEVENTOXXX");
$yummy   = array($row_user['id'], htmlentities($row_user['nombre']." ".$row_user['ape1'], ENT_QUOTES, "UTF-8"), date_format(date_create($row_ev['fecha']), 'd-m-Y H:i'),  htmlentities($row_ev['lugar'], ENT_QUOTES, "UTF-8"), htmlentities($row_ev['direccion'], ENT_QUOTES, "UTF-8"), htmlentities($row_del['nombre'], ENT_QUOTES, "UTF-8"), $row_del['email'], $row_user['email'], $row_ev['id']);

$newphrase = str_replace($healthy, $yummy, $phrase);


//echo $newphrase;
		  






  $nota = $newphrase;
 
  
  
$mail = new PHPMailer();



$mail->IsSMTP(); 

$mail->SMTPDebug = 1;                  
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



$mail->AddReplyTo($row_del['email'], $row_del['nombre']);

$mail->FromName = "PRACTICA Y CLINICA";

$mail->Subject = "INVITACION PRACTICA Y CLINICA";

$mail->AltBody = "INVITACION PRACTICA Y CLINICA"; 

$mail->MsgHTML($nota);


		
		$mail->AddAddress($row_user['email'], $row_user['nombre']." ".$row_user['ape1']);
		//$mail->AddAddress('gianna@gsx7.com',$row_user['nombre']);
	
        $mail->AddCC($row_del['email'], $row_del['nombre']);
		$mail->AddBCC('gianna@tba.es', 'test');

$mail->SMTPAuth = true;


$mail->Username = $maillogin;
$mail->Password = $mailpass; 

if(!$mail->Send()) {

 $resultado = 'Mensaje No Enviado: '. $mail->ErrorInfo;
 $edoresultado = 0;
} else {
   $resultado = 'Mensaje Enviado correctamente ';
   $edoresultado = 1;
 
}


			  }

		   }

			  // termina el email
	
if ($edoresultado == 1) {



header("Location: eventos_ponentes.php?id=".$evento."&err=1");
} else {
	
	echo $resultado;
	
	}?>