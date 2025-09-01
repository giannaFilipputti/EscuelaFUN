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
      <?
          $sql_al = "SELECT * FROM com_alumnos WHERE id = ". $alumno ."";
          $result_al = mysql_query($sql_al);
		  $row_al = mysql_fetch_array($result_al);
		  $fechoy1 = date('Y-m-d')." 00:00:00";
    ?>
        <h1>Reuniones</h1>
        <h2>Reunión del usuario: <?php echo $row_al['ape1']." ".$row_al['ape2'].", ".$row_al['nombre']?></h2>
        <?
          $sql = "SELECT * FROM com_alumnos_eventos WHERE alumno = ". $alumno ." AND evento = ".$evento." LIMIT 1";
          $result = mysql_query($sql);
		  if ($row = mysql_fetch_array($result)) {
			 $id_registro = $row['id'];
			 $sqler = "SELECT * FROM com_eventos WHERE id = ". $row['evento'] ." LIMIT 1";
              $resulter = mysql_query($sqler);
		      if ($rower = mysql_fetch_array($resulter)) {
				  if ($rower['fecha'] < $fechoy1) {
					   $evento_ant = 1;
					   $evento_antn = $rower['lugar']." ".date("d-m-Y H:i",strtotime($rower['fecha']));	
					   $evento_antv = $rower['id'];			  
				  }
		      }
			 
		  } else {
		     $id_registro = "no";
		  }
    ?> <div class="box">
        <h2>Reasignar reunión al Usuario</h2>
         <form action="usuarios_eventos_reasignar.php" method="post">
           <input type="hidden" name="id_registro" value="<?php echo $id_registro;?>" />
           <input type="hidden" name="alumno" value="<?php echo $alumno;?>" />
            <label><span>Reunión: </span>
           <select name="evento">
           <?php if ($evento_ant == 1) { ?>
           <option value="<?php echo $evento_antv;?>" selected="selected"><?php echo $evento_antn;?></option>
           <?php } ?>
             <?php $fechoy1 = date('Y-m-d')." 00:00:00";
			 
			 $sql_ev = "SELECT * FROM com_eventos WHERE fecha >= '".$fechoy1."' ORDER BY fecha DESC";
          $result_ev = mysql_query($sql_ev);
		  while ($row_ev = mysql_fetch_array($result_ev)) {?>
             <option value="<?php echo $row_ev['id']?>"<?php if ($row['evento'] == $row_ev['id']) { ?> selected="selected"<?php } ?>><?php echo $row_ev['lugar']." ".date("d-m-Y H:i",strtotime($row_ev['fecha']))?></option>
          <?php } ?>
           </select></label>
           <!--
           <label><span>Delegado: </span>
           <select name="delegado" id="delegado">
           <option value="0"></option>
             <?php 
			 
			 $sql_del = "SELECT * FROM com_users WHERE tipo = 'delegado' ORDER BY nombre";
          $result_del = mysql_query($sql_del);
		  while ($row_del = mysql_fetch_array($result_del)) {?>
             <option value="<?php echo $row_del['id']?>"<?php if ($row['delegado'] == $row_del['id']) { ?> selected="selected"<?php } ?>><?php echo $row_del['nombre']?></option>
          <?php } ?>
           </select></label>-->
           <label><span>&nbsp;</span><input type="submit" /></label>
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
