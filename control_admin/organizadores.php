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
        <h2>Perfil travel registrados</h2>
        <?
          $sql = "SELECT * FROM com_users WHERE tipo = 'organizador' ORDER BY nombre";
          $result = mysql_query($sql);
    ?>
    <table>
     <thead>
        <tr>
        <td width="35%">Nombre</td>
        <td width="35%">Email</td>
        
        <td width="30%">Elim</td>
        </tr>
      </thead>
        <? while ($row = mysql_fetch_array($result)) {
		  
		  
                ?>
                <tr>
        <td><?=$row['nombre'];?></td>
        <td><?=$row['email'];?></td>
        
        <td><a href="organizadores_mod.php?id=<?=$row['id'];?>"><img border="0" alt="Modificar" src="body/modif.png" /></a>&nbsp;<a href="organizadores_elim.php?id=<?=$row['id'];?>" onClick="return confirm('Esta seguro de borrar este usuario?');"><img border="0" alt="Eliminar" src="body/elim.png"></a>&nbsp;</td>
         
      </tr>
                  <? } ?>
        </table>
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
