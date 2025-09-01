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


            $db = Db::getInstance();
			$data = array(
				'curso' => $clinica,
                'tipo' => '2',
                'rut' => $rut_alumno,
                'email' => $email_alumno,
                'fecha' => date('Y-m-d h:i:s')

			);
			$db->insert('com_presenciales_asistencia', $data);
			//$this->id = $db->lastInsertId();


            header("Location: clinicas.php?asistencia=OK&rut=".$rut_alumno."&email=".$email_alumno);

# Our new data

# Create a connection




?>
