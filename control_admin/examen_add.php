<?php 

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
// CONTENIDO PAGINA

$exam = new Examen();
$exam->modulo = $modulo;
$exam->num = $numero;
$exam->getAll($modulo);
$capitulo = 0;




// if (!empty($exam->row)) {
// 	//echo "entra aqui";
// 	$orden1 = 1;
// 	$orden2 = 2;
// 	$orden3 = 3;
// 	$orden4 = 4;
// 	$orden5 = 5;
// 	$orden6 = 6;
// 	$orden7 = 7;
// 	$orden8 = 8;
// 	$orden9 = 9;
// 	$orden10 = 10;
// 	$orden11 = 11;
// 	$orden12 = 12;
// 	$orden13 = 13;
// 	$orden14 = 14;
// 	$orden15 = 15;
	
// 	 }
// 	 $orden1 = 1;
// 	$orden2 = 2;
// 	$orden3 = 3;
// 	$orden4 = 4;
// 	$orden5 = 5;
// 	$orden6 = 6;
// 	$orden7 = 7;
// 	$orden8 = 8;
// 	$orden9 = 9;
// 	$orden10 = 10;
// 	$orden11 = 11;
// 	$orden12 = 12;
// 	$orden13 = 13;
// 	$orden14 = 14;
// 	$orden15 = 15;

  $exam->agregar($modulo,$capitulo,$pagina,$numero,$pregunta,$exp_resp,$video,$mod_ref);

$contador = 1;
while ($contador <= $cant) {
	
	$var1 = "respuesta".$contador;
	$var2 = "correcta".$contador;
	$respuesta = ${$var1};
	$correcta = ${$var2};

	
	if (empty($correcta)) {
	  $correcta = 0;
     }	  
	
	if (!empty($respuesta)) {
	 $exam->agregarRespuesta($respuesta,$correcta);
		}
	
	
	$contador = $contador + 1;
	}
	

  header("Location: examen.php?id=".$modulo."&ref=".$curso."&mod_ref=".$mod_ref); 
 
?>