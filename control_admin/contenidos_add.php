<?php include("../includes/conn.php");
include ("auto.php");

include("../includes/extraer_variables.php");


// CONTENIDO PAGINA
$result1e = mysql_query("SELECT orden FROM com_contenidos ORDER BY orden DESC LIMIT 1",$link) or die("el error es porque: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $orden = 1;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $orden = $rowe['orden'] + 1;
                }


$result = mysql_query ("INSERT INTO com_contenidos (curso, titulo, menu, fecha, contenido, estado, orden) VALUES ('".$curso."','".$titulo."','".$menu."','".$fechoy."','".$contenido."','1','".$orden."')",$link) or die("el error es en el insert: ".mysql_error());
header("Location: contenidos.php?id=".$curso); 
 
?>

