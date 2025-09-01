<?php

include('lib/class/phpqrcode/qrlib.php');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';


$tempDir = $_SERVER['DOCUMENT_ROOT'] . "/qr/";

$codeContents = 'https://fechida.c-pulpro.com/qrT.php?codigo=xxx';
$nameContents = $codigo;


// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
$fileName = 'qr_' . md5($nameContents) . '.png';

$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = "/qr/" . $fileName;
$urlRelativeFilePath1 = "qr/" . $fileName;

// generating
//if (!file_exists($pngAbsoluteFilePath)) {
    QRcode::png($codeContents, $pngAbsoluteFilePath);
//}

return $urlRelativeFilePath1;
//echo '<img src="'.$urlRelativeFilePath.'" />';