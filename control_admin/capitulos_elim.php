<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$capitulo = new Capitulo();
$capitulo->eliminar($id,$curso,$ref);


// $result = mysql_query ("DELETE FROM com_cursos_mod_cap WHERE id = ".$id."",$link);

$pagina = new Pagina();
$pagina->getAll($id);

// $sql_1 = "SELECT * FROM com_capitulo_contenidos WHERE capitulo = ".$id." ORDER BY orden";
// $result_1 = mysql_query($sql_1);

// chen
// foreach ($pagina->row as $Elem) { 

//     $ponencia = new Ponencia();
//     $ponencia->eliminar($id,$curso,$ref);

// }	

// $pagina->eliminar($id,$curso,$ref);

// echo "DELETE FROM com_capitulo_contenidos WHERE capitulo = ".$id.""."<br>";
// $result = mysql_query ("DELETE FROM com_capitulo_contenidos WHERE capitulo = ".$id."",$link);





header("Location: capitulos.php?id=".$ref."&ref=".$curso); ?>