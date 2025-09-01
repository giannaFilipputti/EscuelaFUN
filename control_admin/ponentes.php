<? include("../includes/conn.php");

include("../includes/extraer_variables.php");
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
        <h1>Delegado</h1>
        <h2>Delegados registrados</h2>
        <?
          $sql = "SELECT * FROM com_users WHERE tipo = 'delegado' ORDER BY nombre";
          $result = mysql_query($sql);
    ?>
    <table>
     <thead>
        <tr>
        <td width="30%">Nombre</td>
        <td width="30%">Email</td>
        <td width="25%">Gerente</td>
        
        <td width="15%">Elim</td>
        </tr>
      </thead>
        <? while ($row = mysql_fetch_array($result)) {
		  
		  $msqldes1 = "SELECT id FROM com_eventos WHERE delegados LIKE '%*".$row['id']."*%'";
		  //echo $msqldes1;
		  //$resultdes1 = mysql_query($msqldes1);
		  $hay_eve = mysql_num_rows(mysql_query($msqldes1));
		  
		  
		  $sql_p = "SELECT * FROM com_gerentes wHERE id =".$row['gerente']. " LIMIT 1";
          $result_p = mysql_query($sql_p);
		  $row_p = mysql_fetch_array($result_p);
		  
                ?>
                <tr>
        <td><?=$row['nombre'];?></td>
        <td><?=$row['email'];?></td>
        <td><?=$row_p['nombre'];?></td>
        
        <td><a href="ponentes_mod.php?id=<?=$row['id'];?>"><img border="0" alt="Modificar" src="body/modif.png" /></a>&nbsp;<?php if ($hay_eve == 0) { ?><a href="ponentes_elim.php?id=<?=$row['id'];?>" onClick="return confirm('Esta seguro de borrar este usuario?');"><img border="0" alt="Eliminar" src="body/elim.png"></a>&nbsp;<?php } ?></td>
         
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
