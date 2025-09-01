<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");
include("auto_n3.php");
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
        <h1>Directores</h1>
        <div class="box">
        <h2>Modificar director</h2>
        <?  $id = $_GET['id'];
		    $sql = "SELECT * FROM com_directores WHERE id=".$id." LIMIT 1";
            $result = mysql_query($sql);
			$row = mysql_fetch_array($result);
		 ?>
          <?php if ($error == 1) { ?>
        <div class="roja">No se puede actualizar el Email ya está registrado</div>
        <?php } ?>
        <form method="POST" action="directores_mod1.php?id=<?php echo $id;?>">
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20" value="<?php echo $row['nombre']?>"></label>
        <label><span>Email: </span>
          <input type="text" name="zona" size="20" value="<?php echo $row['zona']?>"></label>
        
       
        
       
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
