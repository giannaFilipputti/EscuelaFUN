<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($ref);

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
        <div class="der"><a href="modulos_encuesta_resp.php?modulo=<?php echo $modulo;?>&ref=<?php echo $ref;?>">Volver</a></div>
        <?php
        $encuesta = new Modulo();
        $encuesta->getOneEncuesta($id);
        
        $usuario = new Usuario();
        $usuario->getOne($encuesta->row[0]['alumno']);

    ?>
    <div class="bloque espaciado">
           
           <div>
           	<div>Usuario: <?php echo $usuario->row[0]['ape1'].", ".$usuario->row[0]['nombre'];?></div>
           	<div>Email: <?php echo $usuario->row[0]['email'];?></div>
           	<div>Fecha: <?php echo $encuesta->row[0]['fecha'];?></div>
           </div>
            
             <table width="100%" cellpadding="2" cellspacing="0" border="1">
              <tr>
                <td width="75%">Pregunta</td>
                <td width="25%"><strong>Respuesta</strong></td>
              </tr>
              <tr>
                <td class="tith"><span class="labelp2">¿Crees que el curso ha sido útil para ampliar tus conocimientos en epilepsia?</span></td>
                <td><?php echo $encuesta->row[0]['p1'];?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">¿Crees que los casos clínicos presentados son de interés para la práctica clínica?</span></td>
                <td><?php echo $encuesta->row[0]['p2'];?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">¿Crees que el formato interactivo del curso y la presencia de videos del autor son de utilidad para mejorar la comprensión de los casos clínicos?</span></td>
                <td><?php echo $encuesta->row[0]['p3'];?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">¿Crees que las preguntas del examen era suficientemente claras?</span></td>
                <td><?php echo $encuesta->row[0]['p4'];?></td>
              </tr>
              
              
              <tr>
                <td class="tith"><span class="labelp2">¿Recomendarías este curso a otros profesionales sanitarios?</span></td>
                <td><?php echo $encuesta->row[0]['p5'];?></td>
              </tr>
              
              <tr>
                <td class="tith" colspan="2"><span class="labelp2">¿Qué consideras que podríamos mejorar en este curso?</span></td>
              </tr>
              
              <tr>
                <td class="tith" colspan="2"><?php echo $encuesta->row[0]['p6'];?></td>
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
