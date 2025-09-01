<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
<script type="text/javascript">
$(document).ready(function() {
  
  
  $('#img_upload').uploadify({
    'uploader'  : '/plugins/uploadify/uploadify.swf',
    'script'    : '/NEURO/uploads/imagen.php',
    'cancelImg' : '/plugins/uploadify/cancel.png',
    'folder'    : '/NEURO/uploads/imagenes/',
    'auto'      : true,
	'multi'       : false,
	'buttonText'  : 'Agregar Imagen',
	'scriptData'  : {'contenido':<?=$id?>},
	
	'onComplete' : function(event, queueID, fileObj, response, data) {
      $.post("ponencias_imagen.php?id=<?=$id?>",   function(data1){            
       /// Ponemos la respuesta de nuestro script en el párrafo recargado  
      $("#imagenes1").html(data1);      }); 
	  //alert("Successfully uploaded: "+response);
    }
	
	
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
      <div id="submenu"><!-- DESDE AQUI SUBMENU --><a href="ponencias_add.php"><img src="body/pestanas_r1_c2.jpg" border="0"></a><a href="ponencias.php"><img src="body/pestanas_r1_c3.jpg" border="0"></a><a href="ponencias_bus.php"><img src="body/pestanas_r1_c4.jpg" border="0"></a><a href="categorias.php"><img src="body/pestanas_r1_c5.jpg" border="0"></a>
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Ponencias </h1>
        <h2>Agregar Imagen</h2>
       <div class="box">
       <div><input id="img_upload" name="img_upload" type="file" /></div>
        <br class="clearfloat" />
        <div id="imagenes1"><?php include('ponencias_imagen.php') ;?>
        </div>
        
       
       </div>
            
            
    <br /><br />

    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
