
<?  /*error_reporting(E_ALL);
 ini_set("display_errors", 1);*/
include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

//echo "test1";
function download($url){

            $file= '../uploads/tutorial/'.$url;
            $filename= basename($file);
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



 

 //if ($rowff['tipo'] == 'delegado') {
	 
	if ($rowff['nivel'] == 3) {  
	   $f = "tutorial_travel.pptx";
	} else {
		$f = "tutorial.pptx";
		}
	
 
       download($f);
// }
	 

?>
