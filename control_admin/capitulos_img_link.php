<?php 

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);

$diapositiva = new Capitulo();
$diapo = $diapositiva->getOne($id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts1.php");?>


    
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
     
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Ponencias Links </h1>

          <?php
          
          if (empty($diapositiva->row['video'])) { ?>
         
       <iframe src="http://player.vimeo.com/video/<?php echo $diapositiva->row[0]['video']?>?api=1" width="220" height="110" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
      <?php  } ?>
        <h2>Agregar Link</h2>
        <div class="box">
         <div>
         <form action="capitulos_img_link_add.php?id=<?php echo $id?>" method="post">
          <label><span>Url: </span><input type="text" name="url" id="url" /></label>
          <label><span>Desde seg: </span><input type="text" name="desde" id="desde" /> seg</label>
          <label><span>Hasta seg: </span><input type="text" name="hasta" id="hasta" /> seg</label>

          <label><span>Ancho: </span><input type="text" name="ancho" id="ancho" /> %</label>
          <label><span>Alto: </span><input type="text" name="alto" id="alto" /> %</label>
         
          <label><span>&nbsp;</span><input type="submit" value="Enviar"/></label>
         </form>
       </div>
        </div>
        <div id="imagenes1">
		
		    <?php include('capitulos_img1_link.php') ;?>
       
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
