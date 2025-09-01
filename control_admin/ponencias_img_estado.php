<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$diapo = new Diapositiva();
$diapo->getOne($id);

    // $sql_po = "SELECT id, ponencia FROM com_ponencias_ima WHERE id=".$id." ORDER BY orden";
	// $result_po = mysql_query($sql_po,$link);
	// $row_po = mysql_fetch_array($result_po);
$pagina = new Pagina();
$pagina->getOne($diapo->row[0]['ponencia']);

$capitulo = new Capitulo();
$capitulo->getOne($pagina->row[0]['capitulo']);



$mod = new Modulo();
$mod->getOne($capitulo->row[0]['modulo']);


$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

$diapoDesta = new PonenciaDestacado();

if ($st == 1) {
	
    $diapoDesta->getPonencia($id,$tipo);
	// $sql_des = "SELECT id FROM com_ponencias_destacados WHERE id_ima=".$id." AND tipo = '".$tipo."' LIMIT 1";
    // $result_des = mysql_query($sql_des);
    if (!empty($diapoDesta->row)) {
      
	} else {
        $diapoDestaBytipo = new PonenciaDestacado();
        $diapoDestaBytipo->getByTipo($tipo);
		// $result1e = mysql_query("SELECT orden_".$tipo." FROM com_ponencias_destacados ORDER BY orden_".$tipo." DESC LIMIT 1",$link) or die("el error es porque 35: ".mysql_error());
               if(count($diapoDestaBytipo->row) == 0) { 
                   $orden1 = 1;
               }
                else {
                  $orden1 = $diapoDestaBytipo->row[0]['orden_'.$tipo] + 1;
                }
                // echo $id;
		$diapoDestaBytipo->agregar($id,$tipo,$orden1,$curso->row[0]['id']);
		//    $result1 = mysql_query ("INSERT INTO com_ponencias_destacados (id_ima, tipo, orden_".$tipo.", curso) VALUES ('".$id."','".$tipo."','".$orden1."', '".$row_cur['id']."')",$link) or die("el error es en el insert: ".mysql_error());
	}
	
} else {
    $diapoDesta->eliminar($id,$tipo,$ref);
	//  $result = mysql_query ("DELETE FROM com_ponencias_destacados WHERE id_ima=".$id." AND tipo = '".$tipo."'",$link);
	}


  header("Location: ponencias_up.php?id=".$ref);  ?>