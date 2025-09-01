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
        <h1>Gerentes</h1>
        <div class="box">
        <h2>Agregar gerente</h2>
         <?php if ($error == 1) { ?>
        <div class="roja">Email ya registrado</div>
        <?php } ?>
        <form method="POST" action="gerentes_add.php">
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20"></label>
        <label><span>Zona: </span>
          <input type="text" name="zona" size="20"></label>
        <label><span>Director: </span>
          <select name="director">
          <?
          $sql_p = "SELECT * FROM com_directores ORDER BY nombre";
          $result_p = mysql_query($sql_p);
		  while ($row_p = mysql_fetch_array($result_p)) {
    ?>
            <option value="<?php echo $row_p['id']?>"><?php echo $row_p['nombre']?></option>
            <?php } ?>
          </select></label>
       
          
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
        </div>
        
        
        <h2>Delegados registrados</h2>
        <?
          $sql = "SELECT * FROM com_gerentes ORDER BY id";
          $result = mysql_query($sql);
		  
		 
    ?>
    <table>
     <thead>
        <tr>
        <td width="30%">Nombre</td>
        <td width="25%">Zona</td>
        <td width="30%">Director</td>
        
        <td width="15%">Elim</td>
        </tr>
      </thead>
        <? while ($row = mysql_fetch_array($result)) {
		  $sqlg = "SELECT * FROM com_users WHERE gerente = ".$row['id']. " LIMIT 1";
          $resultg = mysql_query($sqlg);
		  
		  
		  $sqld = "SELECT * FROM com_directores WHERE id = ".$row['director']. " LIMIT 1";
          $resultd = mysql_query($sqld);
		  $rowd = mysql_fetch_array($resultd);
		  
                ?>
                <tr>
        <td><?=$row['nombre'];?></td>
        <td><?=$row['zona'];?></td>
        <td><?=$rowd['nombre'];?></td>
        
        <td><a href="gerentes_mod.php?id=<?=$row['id'];?>"><img border="0" alt="Modificar" src="body/modif.png" /></a>&nbsp;<?php if ($rowg = mysql_fetch_array($resultg)) { ?><?php } else { ?><a href="gerentes_elim.php?id=<?=$row['id'];?>" onClick="return confirm('Esta seguro de borrar este usuario?');"><img border="0" alt="Eliminar" src="body/elim.png"></a>&nbsp;<?php } ?></td>
         
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
