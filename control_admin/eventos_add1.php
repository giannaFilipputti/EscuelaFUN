<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");

include ("auto.php");
include("auto_n3.php");




// CONTENIDO PAGINA
$delegado = '';
for ($i=0;$i<count($delegados);$i++)    
{     
$delegado .=  "*" . $delegados[$i];    
} 

$delegado .=  "*";

$tokensArray1 = array("1","2","3","4","5","6","7","8","9","0");



    $temp_ok = '';
	   while ($temp_ok != 'ok') {
        $inmu_clave = createhash($tokensArray1,5);
		$sqlrc = "SELECT * FROM com_eventos WHERE clave = '".$inmu_clave."'";
         if (mysql_num_rows(mysql_query($sqlrc)) == 0) {
			 	 $temp_ok = 'ok';
			 }
	  
	  
             } 
			 

$fechai = $fecha ." ".$hora.":".$minuto;
$sqlp = "INSERT INTO com_eventos (lugar, direccion, ciudad, fecha, delegados, clave) VALUES ('".$lugar."','".$direccion."','".$ciudad."','".$fechai."','".$delegado."','".$inmu_clave."')";
//echo $sqlp;
$result = mysql_query ($sqlp,$link) or die("el error es en el insert: ".mysql_error());
header("Location: eventos.php"); 
 
?>

