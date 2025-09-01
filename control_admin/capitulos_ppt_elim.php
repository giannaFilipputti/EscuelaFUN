<?php include("../includes/conn.php");
include ("auto.php");

include_once("../includes/extraer_variables.php");

$sql = "UPDATE com_cursos_mod_cap SET ppt = '0', ppt_ext = '' WHERE id = ".$id."";
//echo $sql;
$result = mysql_query ($sql,$link);

$result1e = mysql_query("SELECT * FROM com_cursos_mod_cap WHERE id=".$id."",$link) or die("el error es 2: ".mysql_error());
               
                  $rowe = mysql_fetch_array($result1e);
                 
				
				
				
	            $targetFile1 =  "ppt_".urls_amigables(cortar_string ($rowe['titulo'], 15))."_".$id .".".$rowe['ppt_ext'];
				
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