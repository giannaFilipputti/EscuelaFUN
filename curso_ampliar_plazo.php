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



if ($authj->rowff['labor'] < 6)  {
	header("Location: index.php");	
	die();
}


/*
print_r($cursos);
echo "<br>";*/

$curs = New Curso();

$cursoId = $curs->getOne($curso);

$inscrito = Curso::getInscritoCurso($curso, $id);

$data4 = array();


$nota_adic = "";
if ($tipo ==1) {
   $plazo = 15;
} else if ($tipo ==2) {
    $plazo = $cursoId[0]['plazo'];
}


    //echo $acred_hasta;
    $acred_hasta1 = strtotime($fechoy . "+ ".$plazo." days");
    $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
    $data4['fecfin'] = $acred_hasta;



Curso::ampliarPlazo($curso, $id, $data4);







// AQUI TERMINA EL CODIGO
header("Location: reporte_cursos.php?id=".$curso."&estado=".$estadoref);



