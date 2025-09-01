<? include_once("../includes/conn.php");
include("auto.php");
include_once("../includes/extraer_variables.php");


$sql = "SELECT * FROM com_foco WHERE id=".$id."";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);



$sql_ind = "SELECT * FROM com_indexador WHERE tabla='com_foco' AND id_tabla = ".$row['id']."";
$result_ind = mysql_query($sql_ind);
$row_ind = mysql_fetch_array($result_ind);


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

<script type="text/javascript">






</script>

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
        <h1>Texto para la busqueda de archivo FOCO: <?php echo $row['nombre'];?></h1>
        <div class="box">
        <h2>Agregar texto para buscador</h2>
        
        <form action="foco_texto1.php?id=<?php echo $id;?>&ref=<?php echo $ref;?>" method="post">
         <textarea id="contenido" name="contenido" rows="5" cols="50"><?php echo $row_ind['texto']?></textarea>
        
        
            
       
         
		<div class="botonup"><input type="submit" /></div>
       
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
