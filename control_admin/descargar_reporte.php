<?php  /*error_reporting(E_ALL);
 ini_set("display_errors", 1);*/
include("../includes/conn.php");
include("auto.php");
include("../includes/extraer_variables.php");

function download($url,$nombre){

            $file= $url;
            //$filename= basename($file);
			$filename= $nombre;
            $type = '';
             
            if (is_file($file)) {
                $size = filesize($file);
                if (function_exists('mime_content_type')) {
                    $type = mime_content_type($file);
                } else if (function_exists('finfo_file')) {
                    $info = finfo_open(FILEINFO_MIME);
                    $type = finfo_file($info, $file);
                    finfo_close($info);
                }
                if ($type == '') {
                    $type = "application/force-download";
                }
                // Set Headers
                header("Content-Type: $type");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . $size);
                // Download File
                ob_end_clean();
                flush();
                readfile($file);
            } else {
                echo $file.' no es un archivo.';
            }
        
}  



 
// echo "test2";
 
	if ($tipo == 'encuesta') {
		$f = "excel/encuesta".$id.".xlsx";
		$sql = "SELECT * FROM com_cursos_mod WHERE id=".$modulo."";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
		$nombre = "CEN_encuesta_".urls_amigables($row['titulo']).".xlsx";
		
	} else {  
	  
	$f = "excel/estadisticas".$id.".xlsx";
		$nombre = "CEN_estadisticas".$id.".xlsx";
	}
	
 
       download($f, $nombre);
	
	 



?>