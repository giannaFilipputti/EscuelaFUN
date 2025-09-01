<?php 


require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);


$diapo = new Diapositiva();
$diapo->getLastOrdenIma($contenido);

if(!empty($diapo->row)){
    $orden = $diapo->row[0]['orden'] + 1;
}else{
    $orden = 1;
}
				
$diapo->agregar($contenido,$video,$orden);
				   
header("Location: ponencias_up.php?id=".$contenido); 
 
?>

