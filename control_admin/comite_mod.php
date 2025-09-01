<? include_once("../includes/conn.php");
include("auto.php");
include_once("../includes/extraer_variables.php");



$sql_com = "SELECT * FROM com_comite WHERE id=".$id."";
$result_com = mysql_query($sql_com);
$row_com = mysql_fetch_array($result_com);

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
<script type="text/javascript" src="<?php echo $baseURLcontrol;?>js/funciones.js"></script>



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
        <h1>Contenidos: <?php echo $row['titulo'];?></h1>
        <div class="box">
        <h2>Agregar Contenido al curso </h2>
        <form action="comite_mod1.php?id=<?php echo $id?>&ref=<?php echo $ref;?>" method="post">
        <label><span>Nombre: </span>
          <input type="text" name="titulo" id="titulo" size="20" value="<?php echo $row_com['nombre']?>"></label>
          
        <label><span>Descripcion: </span>&nbsp;</label>
         <textarea id="contenido" name="contenido" rows="5" cols="50"><?php echo $row_com['contenido']?></textarea>
         <label><span>&nbsp;</span>
          <input type="submit" /></label>
          
       </form>
       
        
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
