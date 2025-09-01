<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n3.php");



	  
	  $delegado = '';
for ($i=0;$i<count($delegados);$i++)    
{     
$delegado .=  "*" . $delegados[$i];    
} 

$delegado .=  "*";

	  $fechai = $fecha ." ".$hora.":".$minuto;
  $sqlp = "UPDATE com_eventos SET lugar= '". $lugar ."', direccion= '". $direccion ."', ciudad= '". $ciudad ."', fecha = '". $fechai ."', delegados = '". $delegado ."' WHERE id = ".$id."";

  $result = mysql_query ($sqlp,$link) ;



header("Location: eventos.php"); ?>