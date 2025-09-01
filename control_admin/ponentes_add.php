<? include("../includes/conn.php");

include("../includes/extraer_variables.php");
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
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Delegados</h1>
        <div class="box">
        <h2>Agregar delegado</h2>
         <?php if ($error == 1) { ?>
        <div class="roja">Email ya registrado</div>
        <?php } ?>
        <form method="POST" action="ponentes_add1.php">
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20"></label>
        <label><span>Email: </span>
          <input type="text" name="email" size="20"></label>
         <label><span>Gerente: </span>
          <select name="director">
          <?
          $sql_p = "SELECT * FROM com_gerentes ORDER BY nombre";
          $result_p = mysql_query($sql_p);
		  while ($row_p = mysql_fetch_array($result_p)) {
    ?>
            <option value="<?php echo $row_p['id']?>"><?php echo $row_p['nombre']?></option>
            <?php } ?>
          </select></label>
       
          
        
       
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
