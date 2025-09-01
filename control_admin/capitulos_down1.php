<? include("../includes/conn.php");
include("auto.php");
include("../includes/extraer_variables.php");

$sql1 = "SELECT * FROM com_cursos_mod_cap WHERE id=".$id."";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_array($result1);

$sql = "SELECT * FROM com_cursos_mod WHERE id=".$row1['id']."";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

$sql0 = "SELECT * FROM com_cursos WHERE id=".$row['curso']."";
$result0 = mysql_query($sql0);
$row0 = mysql_fetch_array($result0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
<link href="<?php echo $baseURL;?>plugins/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script>

</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <? include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <? include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Descarga del Capitulo: <?php echo $row1['titulo'];?> del Modulo: <?php echo $row['titulo'];?> del curso: <?php echo $row0['titulo'];?></h1>
        <div class="box">
        <input type="hidden" id="esp_titulo" value="1" />
        <h2>Agregar PDF de descarga al Modulo </h2>
        <form action="../pdf/noticias_up1.php?id=<?=$id?>" method="post" enctype="multipart/form-data">
	                
                         <label>Seleccione la imagen 1:  
                              <input name="myfile" type="file" size="30" />
                         </label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                        
                  
                     
            </form>
       
        
  <div id="imagenes"><? include('capitulos_descargas.php') ;?>
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
