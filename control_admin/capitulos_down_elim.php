<?php include("../includes/conn.php");
include ("auto.php");

include_once("../includes/extraer_variables.php");

$sql = "UPDATE com_cursos_mod_cap SET pdf = '0' WHERE id = ".$id."";
//echo $sql;
$result = mysql_query ($sql,$link);

$result1e = mysql_query("SELECT * FROM com_cursos_mod_cap WHERE id=".$id."",$link) or die("el error es 2: ".mysql_error());
               
                  $rowe = mysql_fetch_array($result1e);
                 
				
				
				
	            $targetFile1 =  substr(urls_amigables($rowe['titulo']),0,230)."_".$id ."_".$tipo.".pdf";
				
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