<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';

function download($url,$nombre){

    $file= 'modulos/'.$url;
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


//echo $id;




$mod = new Modulo();
$lades = $mod->getDescargaOne($id);
	

  $f = $lades[0]['modulo']."_".$lades[0]['id'].".".$lades[0]['ext'] ;

 /* $part_nombre = explode(".", $lareunion['nombre']);
  $laext = $part_nombre[(count($part_nombre)-1)];*/
    $nombre = urls_amigables($lades[0]['nombre']).".".$lades[0]['ext'];
 //$nombre = "nombre.pdf";
  
//echo $f;
//echo "<br>".$nombre;
download($f,$nombre);