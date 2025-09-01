<? include("../includes/conn.php");
include("auto.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
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
      <div id="submenu"><!-- DESDE AQUI SUBMENU --><a href="productos_add.php"><img src="body/pestanas_r1_c2.jpg" border="0"></a><a href="productos.php"><img src="body/pestanas_r1_c3.jpg" border="0"></a><a href="productos_bus.php"><img src="body/pestanas_r1_c4.jpg" border="0"></a><a href="categorias.php"><img src="body/pestanas_r1_c5.jpg" border="0"></a>
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Opciones Personales </h1>
        <?php

$ref =  $_GET['ref'];

$result = mysql_query("SELECT * FROM com_users WHERE login = '$login'",$link) or die("el error es porque: ".mysql_error());
$row = mysql_fetch_array($result);

?>
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
