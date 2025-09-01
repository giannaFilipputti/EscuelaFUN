<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$result = $_REQUEST["table-6"];
$id = $_REQUEST["id"];

$mod = new Modulo();
$mod->getModByCurso($id);


//echo "Aqui".$id."<br>";




//  $sql = "SELECT * FROM com_cursos_mod WHERE curso = ".$id." ORDER BY orden";
//  $result0 = mysql_query($sql,$link);
 $contador = 1;


foreach($mod->row as $Elem){
	$valorden[$contador] = $Elem['orden'];
	$contador = $contador + 1;
}


  
 $contador = 1;
foreach($result as $value) {
	
	 if (!empty($value)) {
		 
	 $mod->modificarOrden($valorden[$contador],$value);

	 $contador = $contador + 1;
	 }
	
}
echo "<span class='roja'>Orden Actualizado</span><br><br>";
?>


