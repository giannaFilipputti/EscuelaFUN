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

include('lib/class/phpqrcode/qrlib.php');

	 // require_once 'lib/auth.php';
//include("cursoPDO.php");

function datoApi($valor) {
	return $valor;
}


$curs = New Presenciales();

if (!empty($orden)) {
    $mod->orden = $orden;
}

if (!empty($tiporden)) {
    $mod->tiporden = $tiporden;
}


if (!empty($pagi)) {
    $mod->pag = $pagi;
}





$cursos = $curs->getAll();

foreach ($cursos as $Elem) {

    
$tempDir = $_SERVER['DOCUMENT_ROOT'] . "/qr/";

$codeContents = 'https://fechida.c-pulpro.com/clinica_asistencia.php?clinica='.$Elem['id'];


// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
$fileName = 'qr_clinica_'.$Elem['id'].'.png';

$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = "/qr/" . $fileName;
$urlRelativeFilePath1 = "qr/" . $fileName;

// generating
//if (!file_exists($pngAbsoluteFilePath)) {
QRcode::png($codeContents, $pngAbsoluteFilePath,QR_ECLEVEL_L,10,2);
//}

$qrClinica =  $urlRelativeFilePath1;
?>
<img src="<?php echo $qrClinica?>"><br>
<?php echo $Elem['titulo']?><br><br><br>
<?php

}




?>
