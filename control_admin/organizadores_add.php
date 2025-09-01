<? include("../includes/conn.php");
include_once("../includes/extraer_variables_seg.php");
include("auto.php");
include("auto_n4.php");
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
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Perfil travel</h1>
        <div class="box">
        <h2>Agregar perfil travel</h2>
        <?php if ($error == 1) { ?>
        <div class="roja">Email ya registrado</div>
        <?php } ?>
        <form method="POST" action="organizadores_add1.php">
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20"></label>
        <label><span>Email: </span>
          <input type="text" name="email" size="20"></label>
        
        <label><span>Password: </span>
          <input type="text" name="password" size="20"></label>
          
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
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
