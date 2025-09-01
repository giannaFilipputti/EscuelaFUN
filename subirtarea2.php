<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id_usuario = $_POST['id_usuario'];
$id_curso = $_POST['id_curso'];
$id_modulo = $_POST['id_modulo'];
$id_capitulo = $_POST['id_capitulo'];

if(isset($_FILES['files'])){

    for($i=0;$i<count($_FILES['files']['name']);$i++){
        
        foreach($_FILES['files'] as $v=>$file) {

            $errors = array();

            $nombre_ori = $_FILES["file"]["name"];


            $file_name = $id_usuario."_".$id_curso."_".$id_modulo."_".$id_capitulo."_".uniqid();
            $file_size = $_FILES['files']['size'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_ext = strtolower(end(explode('.',$_FILES['files']['name'][$i])));

            $nombre_archivo = $file_name.".".$file_ext;

            $extensions = array("php","php5","exe");

            if(in_array($file_ext,$extensions) === false){
                
                if(move_uploaded_file($file_tmp, "uploads/tareas/" . $nombre_archivo)){

                    $fecha_subida = date("Y-m-d h:i:s");

                    $query = "INSERT INTO com_tareas_archivos (usuario,curso,modulo,capitulo,ruta,nombre, fecha_subida)
                                VALUES ($id_usuario,$id_curso,$id_modulo,$id_capitulo,'uploads/tareas/$nombre_archivo',$nombre_ori,'$fecha_subida')";
                    $db->run($query);

                }

            }else{

                $informacion["respuesta"] = "error";
                echo json_encode($informacion);
                exit;

            }
        }
    }
}

?>