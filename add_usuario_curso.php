<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$nombre_alumno      = $_POST['nombre_alumno'];
$rut_alumno         = $_POST['rut_alumno'];
$email_alumno       = $_POST['email_alumno'];
$apepat_alumno      = $_POST['apepat_alumno'];
$apemat_alumno      = $_POST['apemat_alumno'];
$region_alumno      = $_POST['region_alumno'];

$db = Db::getInstance();

$sql_valida = "SELECT email FROM com_registro WHERE email='$email_alumno'";
$cont_valida = $db->run($sql_valida);

if ($cont_valida >= 1) {

    $error = ["error" => "ERROR: El email ya se encuentra registrado."];
    echo json_encode($error);

}else{

    $sql = "INSERT INTO com_registro SET nombre='$nombre_alumno', dni='$rut_alumno', email='$email_alumno', ape1='$apemat_alumno', ape2='$apepat_alumno', region='$region_alumno', telefono='$telf_alumno', genero='$genero_alumno', fecnac='$fecnac_alumno'";

    $cont = $db->run($sql);

    if ($cont == 0) {
    
        $error = ["error" => $cont->error];
        echo json_encode($error);

    } else {

        $data = json_decode(stripslashes($_POST['data']));

        $id_usuario = $db->lastInsertId();

        $sql_pass = "UPDATE com_registro SET pass = LEFT(dni,length(dni)-2) WHERE id = $id_usuario";
        $cont_pass = $db->run($sql_pass);

        $sql_encrypt = "UPDATE com_registro SET pass = sha1(md5(pass)) WHERE id = $id_usuario";
        $cont_encrypt = $db->run($sql_encrypt);
        
        foreach($data as $curso){

            $query = "INSERT INTO com_cursos_registro (curso,usuario) VALUES ($curso,$id_usuario)";

            $cont = $db->run($query);
        }

        $success = ["success" => $id_usuario];
        echo json_encode($success);

    }

}

?>