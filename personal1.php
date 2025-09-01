<?php
$page = "personal";
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';


if ($id != $authj->rowff['id']) {
    header("Location: personal.php");
    die();
}

if (empty($origen)) {
    $origen = "index.php";
}

/*
$telf_alumno      = $_POST['telf_alumno'];
$region_alumno      = $_POST['region_alumno'];
*/

$db = Db::getInstance();

$sql_valida = "SELECT email FROM com_registro_2022 WHERE email='$email_alumno'";
$cont_valida = $db->run($sql_valida);

/*if ($cont_valida >= 1) {

    $error = ["error" => "ERROR: El email ya se encuentra registrado."];
    echo json_encode($error);

}else{*/

    

    if (validateDate($fecnac_alumno)) {

    } else {
        $fecnac_alumno = Null;
    }

    if (empty($region_alumno)) {
        $region_alumno = 0;
    }

    if (empty($tipo_alumno)) {
        $tipo_alumno = 0;
    }

       // echo $fecnac_alumno;

   
        $bind = array(
            ':id_usuario' => $authj->rowff['id'],
            ':pais' => $pais_alumno,
            ':telefono' => $telf_alumno,
            ':genero' => $genero_alumno,
            ':fecnac' => $fecnac_alumno,
            ':club' => $club_alumno,
            ':region' => $region_alumno,
            ':tipouser' => $tipo_alumno
            );

            if (!empty($usu_password)) {
                $pass = sha1(md5(trim($usu_password)));
                $bind[':pass'] = $pass;
                $sql_pass = "UPDATE com_registro SET pais = :pais, telefono = :telefono, genero = :genero, club = :club, region = :region, pass = :pass, fecnac = :fecnac, tipouser = :tipouser, cambiopass = 1 WHERE id = :id_usuario";
                
            } else {
                $sql_pass = "UPDATE com_registro SET pais = :pais, telefono = :telefono, genero = :genero, club = :club, region = :region, fecnac = :fecnac, tipouser = :tipouser WHERE id = :id_usuario";

            }

           // print_r($fecnac_alumno);
        $cont_pass = $db->run($sql_pass, $bind);


        $curs = new Curso();
        $cursos = $curs->getCursosPreinscritos($authj->rowff['id']);

        $getPrecio = Alumno::getPrecio($tipo_alumno, $pais_alumno);
            $contarCursos = 0;

            $cursos_ins = 0;

        foreach ($cursos as $Elem) {
            if ($Elem[$getPrecio]==0) {
                Curso::activarCurso($Elem['idC'], $authj->rowff['id'], $tipo_alumno, $Elem[$getPrecio]);
                $cursos_ins++;
            } else {
                $contarCursos++;
            }

        }

        if ($contarCursos > 0) {
            $origen = "curso_basket.php";

        } else if ($cursos_ins > 0) {
            $origen = "cursos.php?ins=".$cursos_ins;

        }

        header("Location: ".$origen);

//}

?>