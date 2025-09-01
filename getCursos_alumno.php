<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();

$id = $_POST['id'];

if($id == ""){

    $sql1 = "SELECT GROUP_CONCAT(modulo) as modulos FROM com_cursos_mod_cap WHERE profesor != 0";
    $cont1 = $db->run($sql1);
    $row1 = $db->fetchAll($sql1);
    $modulos = $row1[0]['modulos'];

    if ($cont1 == 0 || (empty($modulos))) {

        $sql = "SELECT id,titulo FROM com_cursos";

        $cont = $db->run($sql);
    
        if ($cont == 0) {
        
            $data['data3'][] = "";
            echo json_encode($data);
            $id_cursos = "0";
    
        } else {
            
            $data['data3'] = $db->fetchAll($sql);
            echo json_encode($data);
            
        }

    }else{

        $row = $db->fetchAll($sql1);
        $modulos = $row[0]['modulos'];

        $sql2 = "SELECT GROUP_CONCAT(curso) as cursos FROM com_cursos_mod WHERE id IN($modulos)";
        $db->run($sql2);

        $row2 = $db->fetchAll($sql2);
        $cursos = $row2[0]['cursos'];

        $sql3 = "SELECT id,titulo FROM com_cursos_2022 WHERE id NOT IN($cursos)";
        $cont2 = $db->run($sql3);

        if($cont2 == 0){

            $data['data3'][] = "";
            echo json_encode($data);

        }else{

            $data['data3'] = $db->fetchAll($sql3);
            echo json_encode($data);

        }

    }

}else{

    $sql = "SELECT com_cursos_2022.id,com_cursos_2022.titulo
    FROM com_cursos_2022 
    JOIN com_cursos_registro ON com_cursos_registro.usuario = $id
    WHERE com_cursos_registro.curso = com_cursos_2022.id
    GROUP BY com_cursos_2022.id";

    $cont = $db->run($sql);

    if ($cont == 0) {
    
        $data['data1'][] = "";
        $id_cursos = "0";

    } else {
        
        $data['data1'] = $db->fetchAll($sql);

        $sqll = "SELECT GROUP_CONCAT(com_cursos_registro.curso) AS id_cursos FROM com_cursos_registro WHERE usuario = $id";
        $db->run($sqll);
        $result = $db->fetchAll($sqll);

        foreach($result as $row) {
            
            $id_cursos = $row['id_cursos'];
        
        }
        
    }

    $sql_2 = "SELECT com_cursos_2022.id,com_cursos_2022.titulo FROM com_cursos_2022 WHERE id NOT IN ($id_cursos)";

    $cont_2 = $db->run($sql_2);

    if ($cont_2 == 0) {

        $resultado["data2"][] = "";

    }else{

        $resultado['data2'] = $db->fetchAll($sql_2);

    }

    if(empty($data["data1"])):

        echo json_encode($resultado);
    
    endif;
    
    if(empty($resultado["data2"])):
    
        echo json_encode($data);
    
    endif;
    
    if(!empty($data["data1"]) && !empty($resultado['data2'])):
    
        $arreglo_final = array_merge($data,$resultado);
        
        echo json_encode($arreglo_final);
    
    endif;

}

?>