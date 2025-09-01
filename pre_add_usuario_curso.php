<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
//require_once 'lib/auth.php';

$nombre_alumno      = $_POST['nombre_alumno'];
$rut_alumno         = $_POST['rut_alumno'];
$email_alumno       = $_POST['email_alumno'];
$apepat_alumno      = $_POST['apepat_alumno'];
$apemat_alumno      = $_POST['apemat_alumno'];
$telf_alumno      = $_POST['telf_alumno'];
$region_alumno      = $_POST['region_alumno'];

$db = Db::getInstance();

$sql_valida = "SELECT email FROM com_registro_2022 WHERE email='$email_alumno'";
$cont_valida = $db->run($sql_valida);

/*if ($cont_valida >= 1) {

    $error = ["error" => "ERROR: El email ya se encuentra registrado."];
    echo json_encode($error);

}else{*/

    if (empty($region_alumno)) {
        $region_alumno = 0;
    }

    if (empty($tipo_alumno)) {
        $tipo_alumno = 0;
    }

    $dni = $rut_alumno;
    if (empty($dni)) {
        $dniP = $dni_alumno;
    } else {
        $dni0 = explode("-", $dni);
        $dniP = $dni0[0];
    }

    $sql = "INSERT INTO com_registro_2022 
        SET nombre='$nombre_alumno', dni='$rut_alumno', dni1='$dni_alumno', email='$email_alumno', ape1='$apepat_alumno', ape2='$apemat_alumno', pais='$pais_alumno', region='$region_alumno', telefono='$telf_alumno', club='$club_alumno', genero='$genero_alumno', fecnac='$fecnac_alumno', tipouser='$tipo_alumno'";
    //echo $sql;
    $cont = $db->run($sql);

    if ($cont == 0) {
    
        $error = ["error" => $cont->error];
        echo json_encode($error);

    } else {

        $data = json_decode(stripslashes($_POST['data']));

        $id_usuario = $db->lastInsertId();

        $sql_pass = "UPDATE com_registro_2022 SET pass = :dniP WHERE id = :id_usuario";
        $bind = array(
            ':id_usuario' => $id_usuario,
            ':dniP' => $dniP
            );
        $cont_pass = $db->run($sql_pass, $bind);

        $sql_encrypt = "UPDATE com_registro_2022 SET pass = sha1(md5(pass)) WHERE id = :id_usuario";
        $bind1 = array(
            ':id_usuario' => $id_usuario
            );
        $cont_encrypt = $db->run($sql_encrypt, $bind1);
        
        foreach($data as $curso){

            $query = "INSERT INTO com_cursos_registro_2022 (curso,usuario) VALUES ($curso,$id_usuario)";

            $cont = $db->run($query);
        }

        $success = ["success" => $id_usuario];
        echo json_encode($success);

    }

//}

?>