<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/src/Exception.php';
require 'includes/src/PHPMailer.php';
require 'includes/src/SMTP.php';

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once("includes/recaptchalib.php");
require_once 'lib/auth_off.php';

	 // require_once 'lib/auth.php';
//include("cursoPDO.php");

function datoApi($valor) {
	return $valor;
}


# Our new data

# Create a connection

if ($action == 'cemail') {



}
else if ($action == 'cpass') {
	
	$login = $_COOKIE["admin_idm"];

	$db = Db::getInstance();
	$sql = "SELECT * FROM com_registro WHERE id = :id LIMIT 1";
	$bind = array(
		':id' => $login
	);

	$cont = $db->run($sql, $bind);

	if ($cont > 0) {
		$db1 = Db::getInstance();
		$rowff1 = $db1->fetchAll($sql, $bind);
		$pass1 = sha1(md5(trim($usu_pass)));
		$pass2 = sha1(md5(trim($usu_password)));

		if ($rowff1[0]['pass'] != $pass1) {
			header("Location: misdatos_pass.php?err=1");

		} else {
			$db = Null;

			$db = Db::getInstance();
			$data = array(
                'pass' => $pass2,
                'telefono' => $_POST['telefono'],
				'cambiopass' => '1'
			);
			$db->update('com_registro', $data, 'id = :id', array(':id' => $login));
			header("Location: misdatos_pass.php?act=OK");
			}


	} else {
		header("Location: login.php");

	}



}
else if ($action == 'forgot') {

     $db = Db::getInstance();
				$sql = "SELECT * FROM com_registro WHERE email = :email LIMIT 1";
    			$bind = array(
        		':email' => $usu_email
    			);

				$cont = $db->run($sql, $bind);

	if ($cont > 0) {

            $db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			foreach($rowff1 as $rowff) {
                $idm = $rowff['id'] ;
			   $ape1 = $rowff['ape1'] ;
			   $nombre = $rowff['nombre'] ;
               $email = $rowff['email'] ;
                        }

                         $clave = uniqid();

                        $db3 = Null;
                        $db3 = Db::getInstance();
			$data3 = array(
        	'clave' => $clave,
        	'usuario' => $idm,
        	'fecha' => date('Y-m-d H:i:s')

		);
    	$db3->insert('com_passrecover', $data3);
		$elid = $db3->lastInsertId();
		
	
			  $nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
        <tr>
         <td valign=\"top\" align=\"center\"></td>
        </tr>
        <tr>
         <td valign=\"top\" align=\"left\">
             <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
              Apreciado/a  ".$nombre." ".$ape1."<br><br>

				Hemos recibido tu solicitud de recuperar tu contrase&ntilde;a en nuestros servicios.<br>
				Para obtener una nueva contrase&ntilde;a debes hacer clic sobre el siguiente enlace.<br>
				<a href=\"".$app_url."recover_pass.php?id=".$idm."&unique=".$clave."\">Modificar clave</a>
				<br><br> </font>
                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>

             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />

Si no puedes acceder a trav&eacute;s del enlace de arriba, copia la siguiente direcci&oacute;n:<br><br>
<a href=\"".$app_url."recover_pass.php?id=".$idm."&unique=".$clave."\">".$app_url."recover_pass.php?id=".$idm."&unique=".$clave."</a><br><br>

Muchas gracias por tu participacion.<br><br>

Cordialmente,<br><br>
".$titulo_app."
<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
                </font>




                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>

             </table>
         </td>
        </tr>

        </table>";
		
		$titulo_email = "Recuperacion de clave de acceso - ".$titulo_app;
			  
	


		 $mail = new PHPMailer();

$mail->IsSMTP();

$mail->SetLanguage("en");
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
$mail->FromName = $titulo_app;



    $mail->addAddress($email,$email);
    //$mail->AddBCC('gianna@tba.es', 'test');
    //$mail->AddBCC('filipputti@pulpro.com', 'contacto');
    $mail->addReplyTo('info@pulpro.com', 'Pulpro');

    $mail->isHTML(true);
    $mail->SMTPAuth = true;


$mail->Username = $maillogin;
$mail->Password = $mailpass;
$mail->CharSet = 'UTF-8';
                                // Set email format to HTML

    $mail->Subject = $titulo_email;
    $mail->Body    = $nota;

    if(!$mail->send()) {
        /*$app->flash("error", "We're having trouble with our mail servers at the moment.  Please try again later, or contact us directly by phone.");
        error_log('Mailer Error: ' . $mail->errorMessage());
        $app->halt(202);
		die();*/
    } else {
        header("Location: forgot.php?act=OK");
    }



        } else {
            header("Location: forgot.php?err=1");
        }

}

	// MODIFICAR LO DATOS DE USUARIO
	else if ($action == 'modificar') {
	// aqui empieza el registro en el servicio

	//$dev_OK = 'registroOK.php';
	$dev_OK = 'misdatos.php?status=OK&tipo=modif';
	$dev_KO = 'misdatos.php?status=KO';


    
    if ($mailing != 'N') {
		$mailing = "S";
		}
   //print_r($fields);



                    $db = Null;

	$db = Db::getInstance();
			$data = array(
        	'ape1' => $usu_ape1,
			'ape2' => $usu_ape2,
			'codusuario' => $usu_codusuario,
			'nombre' => $usu_nombre,
			'dni' => $usu_dni,
			'perfil' => $usu_codperfil,
			'especialidad' => $usu_codespecialidad,
				'numcolegiado' => $usu_numcolegiado,
				'pais' => $usu_codpais,
				'provincia' => $usu_codprovestado,
				'poblacion' => $usu_codpoblacion,
				'ciudad' => $usu_ciudad,
				'direccion' => $usu_direccion,
				'cp' => $usu_cp,
				'telefono' => $usu_telefono,
				'fax' => $usu_fax,
				'empresa' => $usu_empresa,
                                'fecmod' => $fechoy,
				'mailing' => $mailing
		);
                       // print_r($data);
		 $db->update('com_alumnos', $data, 'id = :id', array(':id' => $id));
	/*$sqlup = "UPDATE com_alumnos SET ape1 = '". noFiltro($usu_ape1) ."', ape2 = '". noFiltro($usu_ape2) ."', email = '". noFiltro($usu_email) ."', nombre = '". noFiltro($usu_nombre) ."', dni = '". noFiltro($usu_dni) ."', perfil = '".noFiltro($usu_codperfil)."', especialidad = '".noFiltro($usu_codespecialidad)."', numcolegiado = '".noFiltro($usu_numcolegiado)."', pais = '".noFiltro($usu_codpais)."', provincia = '".noFiltro($usu_codprovestado)."', poblacion = '".noFiltro($usu_codpoblacion)."', ciudad = '".noFiltro($usu_ciudad)."', direccion = '".noFiltro($usu_direccion)."', cp = '".noFiltro($usu_cp)."', telefono = '".noFiltro($usu_telefono)."', fax = '".noFiltro($usu_fax)."', empresa = '".noFiltro($usu_empresa)."',  servicio= '1' WHERE codusuario = '".noFiltro($usu_codusuario)."'";
		//echo $sqlup;
				  $resultup = mysql_query ($sqlup,$link) or die ("hay un error en la consulta1 ".mysql_error());*/

	header("Location: ".$dev_OK);

	// aqui termina el registro en el servicio
	}
	// TERMINA MODIFICAR LOS DATOS DE USUARIO
else if ($action == 'registro') {

$response   = isset($_POST["g-recaptcha-response"]) ? $_POST['g-recaptcha-response'] : null;
$privatekey = "6LfesOQUAAAAAPs54uLBrPIHUYbbagl0b0yGgqDN";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
    'secret' => $privatekey,
    'response' => $response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
));

if (!empty($curso)) {
    $Cur = New Curso();
    $CurOne = $Cur->getOne($curso);
}

if (!empty($clinica)) {
    $Cur = New Presenciales();
    $CurOne = $Cur->getOne($clinica);
}

$resp = json_decode(curl_exec($ch));
curl_close($ch);

//if ($resp->success) {

	// primero revisamos que el email NO exista
	$db = Db::getInstance();
				$sql = "SELECT * FROM com_registro WHERE email = :email LIMIT 1";
    			$bind = array(
        		':email' => $email_alumno
    			);

				$cont = $db->run($sql, $bind);

	if ($cont == 0) {
	// SI NO EXISTE REGISTRAMOS

          $dev_OK = 'login.php?act=rOK';
		$dev_KO = 'registro.php?err=1';
	  // empieza el registro de usuario
	  if ($mailing != 'N') {
		$mailing = "S";
		}
	$pass1 = sha1(md5(trim($usu_password)));

      if (empty($usu_codespecialidad)) {
		  $usu_codespecialidad=0;
	  }

	  if (empty($usu_ciudad)) {
                $usu_ciudad = 'valor 1';
	  }



        $clave00 = uniqid();
		$pass1 = sha1(md5(trim($password_alumno)));

		/*  $sql = "INSERT INTO com_registro SET nombre='$nombre_alumno', dni='$rut_alumno', email='$email_alumno', ape1='$apemat_alumno', ape2='$apepat_alumno', region='$region_alumno', telefono='$telf_alumno', genero='$genero_alumno', fecnac='$fecnac_alumno'";

    $cont = $db->run($sql); */
		
		  $db = Db::getInstance();
			$data = array(
        	'ape1' => $apepat_alumno,
			'ape2' => $apemat_alumno,
			'email' => $email_alumno,
			'nombre' => $nombre_alumno,
			'dni' => $rut_alumno,
			'pais' => $pais_alumno,
			'region' => $region_alumno,
				'telefono' => $telf_alumno,
				'club' => $club_alumno,
				'labor' => 0,
				'disciplina' => 0,
				'clave'=> $clave00,
				'fecha' => $fechoy,
				'pass' => $pass1,
				'uniqueid' => $clave00,
				'cambiopass' => 1,
				'genero' => $genero_alumno,
				'fecnac' => $fecnac_alumno,
            	'tipouser' => $tipo_alumno
		);
    	$db->insert('com_registro', $data);
    	$ide = $db->lastInsertId();

	
		
		if (!empty($curso)) {

			if ($pais_alumno != 19) {
				$precio_curso = $CurOne[0]['precio1'];
			}
			else if ($tipo_alumno == 2) {
				$precio_curso = $CurOne[0]['precio2'];
			} else if ($tipo_alumno == 3) {
				$precio_curso = $CurOne[0]['precio3'];
			} else {
				$precio_curso = $CurOne[0]['precio'];
			}


			$db_eve = Db::getInstance();
				$sql_eve = "SELECT * FROM com_cursos_registro WHERE curso = :curso AND usuario = :usuario LIMIT 1";
    			$bind_eve = array(
        		':curso' => $CurOne[0]['id'],
				':usuario' => $ide
    			);

				$cont_eve = $db_eve->run($sql_eve, $bind_eve);
				
				if ($cont_eve == 0) {
					$dbe = Db::getInstance();
					$datae = array(
						'curso' => $curso,
						'usuario' => $usuario
					);

					if ($precio_curso > 0) {
						$datae['estado'] = 0;
					} else {
						$datae['estado'] = 1;
					}
			
			
				$dbe->insert('com_cursos_registro', $datae);					
				}



				

				
				
				
				
				
		}

		if (!empty($clinica)) {

			if ($pais_alumno != 19) {
				$precio_curso = $CurOne[0]['precio1'];
			}
			else if ($tipo_alumno == 2) {
				$precio_curso = $CurOne[0]['precio2'];
			} else if ($tipo_alumno == 3) {
				$precio_curso = $CurOne[0]['precio3'];
			} else {
				$precio_curso = $CurOne[0]['precio'];
			}


			$db_eve = Db::getInstance();
				$sql_eve = "SELECT * FROM com_presenciales_registro WHERE curso = :curso AND usuario = :usuario LIMIT 1";
    			$bind_eve = array(
        		':curso' => $CurOne[0]['id'],
				':usuario' => $ide
    			);

				$cont_eve = $db_eve->run($sql_eve, $bind_eve);
				
				if ($cont_eve == 0) {
					$dbe = Db::getInstance();
					$datae = array(
						'curso' => $clinica,
						'usuario' => $ide,
						'fecha' => date('Y-m-d H:i:s')
					);

					if ($precio_curso > 0) {
						$datae['estado'] = 0;
					} else {
						$datae['estado'] = 1;
					}
			
			
				$dbe->insert('com_presenciales_registro', $datae);					
				}





		}

    	// se envia el email

    	require('includes/class.phpmailer.php');
        require('includes/class.smtp.php');
		
		if ($idiom == 'eng') {
			
			$nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
        
        <tr>
         <td valign=\"top\" align=\"left\">
             <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
              Dear  ".$usu_nombre." ".$usu_ape1."<br><br>
				Thank you for registering with PULPRO System.<br>
				To confirm your email, click the button below.
					.<br><br> </font>
                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>
			 
			 <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"center\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
<a href=\"".$app_url."registro_confirma.php?id=".$ide."&unique=".$clave00."\"><img src=\"".$app_url."img/confirmacion/boton_eng.png\" alt=\"Pulpro System\" width=\"281\" height=\"54\" /></a><br><br>
                </font>
                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>
             
             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />

If the button does not work for some reason, copy the following url into your browser:<br><br>
<a href=\"".$app_url."registro_confirma.php?id=".$ide."&unique=".$clave00."\">".$app_url."registro_confirma.php?id=".$ide."&unique=".$clave00."</a><br><br>";

if (!empty($usu_evento)) {
$nota .= "
<font size=\"3\" color=\"#000000\" face=\"Arial, sans-serif\"><b>
You are already registered for the event: ".$rowff1_eve[0]['titulo']."<br>
On the day of the event you must access the Pulpro event system with your login and password: <a href=\"".$app_url."login.php?evento=".$rowff1_eve[0]['friendly_url']."\">".$app_url."login.php?evento=".$rowff1_eve[0]['friendly_url']."</a> .</b></font><br><br>";
}

$nota .= "Best regards.<br><br><br>
Pulpro System
<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
                </font>


				<table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
             <tr>
			 <td width=\"290\">&nbsp;</td>
			 <td width=\"290\" align=\"right\"><img src=\"".$app_url."img/logopulpro.png\" alt=\"Pulpro\" height=\"50\" /></td>
			 
			 </tr>
			 </table>

                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>

             </table>
         </td>
        </tr>

        </table>";
		$titulo_email = "Confirm your Pulpro System account";
								
				} else {

$nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
        
        <tr>
         <td valign=\"top\" align=\"left\">
             <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
              Apreciado/a  ".$nombre_alumno." ".$apepat_alumno."<br><br>
				Hemos recibido su solicitud de registro en ".$app_title.".<br>
				Para confirmar su registro definitivo debe hacer clic sobre el siguiente enlace.
				<br><br> </font>
                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>
			 
			 <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"center\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
<a href=\"".$app_url."registro_confirma.php?id=".$ide."&unique=".$clave00."\"><img src=\"".$app_url."img/confirmacion/boton.png\" alt=\"Pulpro System\" width=\"281\" height=\"54\" /></a><br><br>
                </font>
                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>
             
             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />

Si no puede acceder a trav&eacute;s del enlace de arriba, copie la siguiente direcci&oacute;n:<br><br>
<a href=\"".$app_url."registro_confirma.php?id=".$ide."&unique=".$clave00."\">".$app_url."registro_confirma.php?id=".$ide."&unique=".$clave00."</a><br><br>";

if (!empty($curso)) {
$nota .= "
<font size=\"3\" color=\"#000000\" face=\"Arial, sans-serif\"><b>
Adicionalmente le confirmamos que ya está pre-inscrito para participar en el Curso: ".$CurOne[0]['titulo']."<br><br>";
}

if (!empty($clinica)) {
	$nota .= "
	<font size=\"3\" color=\"#000000\" face=\"Arial, sans-serif\"><b>
	Adicionalmente le confirmamos que ya está inscrito para participar en : ".$CurOne[0]['titulo']."<br><br>";
	}

$nota .= "Muchas gracias por su participacion.<br><br>

Cordialmente,<br><br>
Pulpro
<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
                </font>


				<table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
             <tr>
			 <td width=\"290\">&nbsp;</td>
			 <td width=\"290\" align=\"right\"><img src=\"".$app_url."img/logopulpro.png\" alt=\"Pulpro\" height=\"50\" /></td>
			 
			 </tr>
			 </table>

                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>

             </table>
         </td>
        </tr>

        </table>";
		$titulo_email = "Confirmacion de Registro";
		}

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


$mail->FromName = "Pulpro System";

$mail->Subject = $titulo_email;

$mail->AltBody = $titulo_email;
$mail->IsHTML(true);

$mail->MsgHTML($nota);

/* Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. admin@domitienda.com  */


		$mail->AddAddress($email_alumno,$email_alumno);
        //$mail->AddBCC('gianna@tba.es', 'test');

$mail->SMTPAuth = true;


$mail->Username = $maillogin;
$mail->Password = $mailpass;

if(!$mail->Send()) {

   //header("Location: gracias.php?err=1");
} else {
  // header("Location: gracias.php");
}

    	// se termina de enviar el email



	     header("Location: ".$dev_OK);

	} else {
		// el email ya existe en la base de datos en la plantilla login debe mostrar error de email existente
		header("Location: login.php?err=6");

	}
	
/*} else {
    header("Location: registro.php?err=7");
}*/

// termina el registro de usuario
}


?>
