<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($id);

$mod = new Modulo();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<script>
  $(function() {
    $(".datepicker1").datepicker({
	     dateFormat:"yy/mm/dd",
		 showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date"
		});
  });
  </script>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
      
        <h2>Encuesta del modulo</h2>
        <div class="der"><a href="modulos_encuesta_resp.php?modulo=<?php echo $id;?>&ref=<?php echo $ref;?>">Ver respuestas</a></div>
        <div class="der"><a href="encuesta_down.php?id=<?php echo $id;?>&ref=<?php echo $ref;?>&modulo=<?php echo $id;?>">Descargar</a></div>
       <?php

$mod->getAllEncuesta($id,0,0);
$tp1 = count($mod->row);

$mod->getAllEncuesta($id,'p1','1');
$tp1r1 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p1','2');
$tp1r2 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p1','3');
$tp1r3 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p1','4');
$tp1r4 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p1','5');
$tp1r5 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p2','1');
$tp2r1 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p2','2');
$tp2r2 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p2','3');
$tp2r3 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p2','4');
$tp2r4 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p2','5');
$tp2r5 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p3','1');
$tp3r1 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p3','2');
$tp3r2 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p3','3');
$tp3r3 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p3','4');
$tp3r4 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p3','5');
$tp3r5 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p4','1');
$tp4r1 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p4','2');
$tp4r2 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p4','3');
$tp4r3 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p4','4');
$tp4r4 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p4','5');
$tp4r5 = count($mod->row)."<br>";


$mod->getAllEncuesta($id,'p5','1');
$tp5r1 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p5','2');
$tp5r2 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p5','3');
$tp5r3 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p5','4');
$tp5r4 = count($mod->row)."<br>";

$mod->getAllEncuesta($id,'p5','5');
$tp5r5 = count($mod->row)."<br>";


// $db1 = Db::getInstance();
// $bind = array('id'=>$id);

// $sql_p1 = "SELECT * FROM com_encuesta WHERE modulo=".$id."";		   
// $row = $db1->fetchAll($sql_p1,$bind);
// $tp1 = count($row);

// $sql_p1r1 = "SELECT * FROM com_encuesta WHERE modulo=".$id." AND p1 = '1'";		
// $row = $db1->fetchAll($sql_p1r1,$bind);
// $tp1r1=count($row);

    ?>
    <div class="bloque espaciado">
            <div class="p"><strong>Total respuestas: <?php echo $tp1;?></strong></div>
             <table width="100%" cellpadding="2" cellspacing="0" border="1">
              <tr>
                <td width="75%">Pregunta</td>
                <td width="5%"><strong>1</strong></td>
                <td width="5%"><strong>2</strong></td>
                <td width="5%"><strong>3</strong></td>
                <td width="5%"><strong>4</strong></td>
                <td width="5%"><strong>5</strong></td>
              </tr>
              <tr>
                <td class="tith"><span class="labelp1">¿Crees que el curso ha sido útil para ampliar tus conocimientos sobre exploración neurológica?</span></td>
                <td><?php echo $tp1r1;?></td>
                <td><?php echo $tp1r2;?></td>
                <td><?php echo $tp1r3;?></td>
                <td><?php echo $tp1r4;?></td>
                <td><?php echo $tp1r5;?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp1">¿Crees que las técnicas de exploración presentadas en los vídeos son de interés para la práctica clínica?</span></td>
                <td><?php echo $tp2r1;?></td>
                <td><?php echo $tp2r2;?></td>
                <td><?php echo $tp2r3;?></td>
                <td><?php echo $tp2r4;?></td>
                <td><?php echo $tp2r5;?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">¿Crees que el formato interactivo del curso y la presencia de vídeos demostrativos son de utilidad para mejorar la comprensión de las técnicas exploratorias?</span></td>
                <td><?php echo $tp3r1;?></td>
                <td><?php echo $tp3r2;?></td>
                <td><?php echo $tp3r3;?></td>
                <td><?php echo $tp3r4;?></td>
                <td><?php echo $tp3r5;?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">¿Crees que las preguntas del examen era suficientemente claras?</span></td>
                <td><?php echo $tp4r1;?></td>
                <td><?php echo $tp4r2;?></td>
                <td><?php echo $tp4r3;?></td>
                <td><?php echo $tp4r4;?></td>
                <td><?php echo $tp4r5;?></td>
              </tr>
              
              
              <tr>
                <td class="tith"><span class="labelp2">¿Recomendarías este curso a otros profesionales sanitarios?</span></td>
                <td><?php echo $tp5r1;?></td>
                <td><?php echo $tp5r2;?></td>
                <td><?php echo $tp5r3;?></td>
                <td><?php echo $tp5r4;?></td>
                <td><?php echo $tp5r5;?></td>
              </tr>
              
             </table>
           </div>
        
 
 
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
