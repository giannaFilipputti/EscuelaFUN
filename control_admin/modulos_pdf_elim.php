<?php include("../includes/conn.php");
include_once("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n4.php");



$sql = "UPDATE com_cursos_mod SET pdf = '0' WHERE id = ".$id."";
//echo $sql;
$result = mysql_query ($sql,$link);

$result1e = mysql_query("SELECT * FROM com_cursos_mod WHERE id=".$id."",$link) or die("el error es 2: ".mysql_error());
               
                  $rowe = mysql_fetch_array($result1e);
                 
				
				
				
	            $targetFile1 =  "M_".$id .".pdf";
				
$carpeta = "../pdf/";
	      $f = $carpeta.$targetFile1;
	     // echo $f;
		 
if(file_exists($f)) 
{ 
//echo "encontro el archivo";
unlink($f);
//print "El archivo fue borrado"; 
} 

header("Location: ".$_SERVER['HTTP_REFERER'] ); ?>