<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n3.php");



require('../includes/class.phpmailer.php');
require('../includes/class.smtp.php');
				
// CONTENIDO PAGINA
 $sql_ev = "SELECT * FROM com_eventos WHERE id = ".$id."";
          $result_ev = mysql_query($sql_ev);
		  $row_ev = mysql_fetch_array($result_ev);
		  
		  
	 $sql_ma = "SELECT * FROM com_mailformato WHERE id = 1 LIMIT 1";
          $result_ma = mysql_query($sql_ma);
		  $row_ma = mysql_fetch_array($result_ma);
		   $formato = $row_ma['codigo'];
		  
		  
          $sql_user = "SELECT * FROM com_invitados WHERE evento = ".$id." ORDER BY email";
          $result_user = mysql_query($sql_user);
    
           while ($row_user = mysql_fetch_array($result_user)) {
			
		 
		  
		  $sql_del = "SELECT * FROM com_users WHERE id = ".$row_user['delegado'];
          $result_del = mysql_query($sql_del);
		  $row_del = mysql_fetch_array($result_del);
		  
		
		  
		  $phrase  = $formato;
$healthy = array("XXXIDXXX", "XXXNOMBREXXX", "XXXFECHAXXX", "XXXSEDEXXX", "XXXDIRECCIONXXX", "XXXDELEGADOXXX", "XXXEMAILDELXXXX");
$yummy   = array($row_user['id'], htmlentities($row_user['nombre']." ".$row_user['apellido'], ENT_QUOTES, "UTF-8"), date_format(date_create($row_ev['fecha']), 'd-m-Y H:i'),  htmlentities($row_ev['lugar'], ENT_QUOTES, "UTF-8"), htmlentities($row_ev['direccion'], ENT_QUOTES, "UTF-8"), htmlentities($row_del['nombre'], ENT_QUOTES, "UTF-8"), $row_del['email']);

$newphrase = str_replace($healthy, $yummy, $phrase);
		  






  $nota = $newphrase;
 
  
  
$mail = new PHPMailer();



$mail->IsSMTP(); 

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


$mail->AddReplyTo($row_del['email'], $row_del['nombre']);



$mail->FromName = "PRACTICA Y CLINICA";

$mail->Subject = "INVITACION PRACTICA Y CLINICA";

$mail->AltBody = "INVITACION PRACTICA Y CLINICA"; 

$mail->MsgHTML($nota);


		
		$mail->AddAddress($row_user['email'],$row_user['nombre']." ".$row_user['apellido']);
		//$mail->AddAddress('gianna@gsx7.com',$row_user['nombre']);
	
        //$mail->AddBCC('gianna@gsx7.com', 'test');

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

$sql00 = "UPDATE com_invitados SET invitacion = '". $edoresultado ."' WHERE id = ".$row_user['id'];
   $result00 = mysql_query ($sql00,$link) or die("el error es en el insert: ".mysql_error());


		   }
header("Location: eventos_invitados.php?id=".$id); 
 
?>

