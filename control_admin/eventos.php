<?php include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
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
        <h1>Reuniones</h1>
        <div class="der">
          <form action="eventos.php" method="get">
          Filtrar: <select name="filtro">
                     <option value=""<?php if (empty($filtro)) { ?> selected="selected"<?php } ?>>Todos</option>
                     <option value="p"<?php if ($filtro == 'p') { ?> selected="selected"<?php } ?>>Próximos eventos</option>
                     <option value="a"<?php if ($filtro == 'a') { ?> selected="selected"<?php } ?>>Eventos pasados</option>
                   </select>
                   <input type="submit" value="Filtrar" name="bt_fil" />
          </form>
        </div>
        <br /><br />        <?php
          //$sql = "SELECT *, 'a' AS ordenar FROM com_eventos WHERE  ORDER BY fecha";
		  $sql_sufijo = "";
		  if ($rowff['nivel'] < 3) {
		   
		    $sql_sufijo = " AND delegados LIKE '%*".$rowff['id']."*%'";
		   
		   
		   } 
	   
		  //$diahoy = date('Y-m-d');
		  $msqldes1 = "SELECT id, lugar, ciudad, fecha, delegados, ordenar, clave FROM (";
		  
		  if (empty($filtro) or $filtro == 'p') { 
		  $msqldes1 .= "SELECT id, lugar, ciudad, fecha, delegados, 'a' AS ordenar, clave FROM com_eventos WHERE fecha > '".$diahoy."'".$sql_sufijo;
		  }
		  
		   if (empty($filtro)) { 
		  $msqldes1 .= " UNION ";
		   }
		   if (empty($filtro) or $filtro == 'a') { 
		  $msqldes1 .= " SELECT id, lugar, ciudad, fecha, delegados, 'Z' AS ordenar, clave FROM com_eventos WHERE fecha <= '".$diahoy."'".$sql_sufijo;
		   }
		
		   
	   $msqldes1 .= ") AS t1";
	   
	   $msqldes1 .= " GROUP BY id ORDER BY ordenar, fecha";
	   
	   
	   //echo $msqldes1;
	   
          $result = mysql_query($msqldes1);
        ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
       <thead>
        <tr>
          <td width="20%">Lugar</td>
          <td width="20%">Fecha</td>
          <td width="20%">Delegado</td>
          <td width="15%">Invitados</td>
          <td width="15%">Acciones</td>
        </tr>
        </thead>
        <? while ($row = mysql_fetch_array($result)) {
			
			$porciones = explode("*", $row['delegados']);
			$losdelegados = '';
			
			foreach ($porciones as $s) {
				if (!empty($s)) {
				$sql_u = "SELECT * FROM com_users WHERE id =".$s;
                $result_u = mysql_query($sql_u);
		        $row_u = mysql_fetch_array($result_u);
				$losdelegados .= $row_u['nombre']."<br>"; 
				}
				
			}
			
			 
			 
		   ?>
                <tr class="<?php if (date("Y-m-d",strtotime($row['fecha'])) == $diahoy) { ?>ev_hoy<?php } else if (date("Y-m-d",strtotime($row['fecha'])) < $diahoy) { ?>ev_pass<?php } else { ?>ev_futuro<?php } ?>">
        <td><?php echo $row['lugar'];?><br /><strong><?php echo $row['ciudad'];?></strong><?php if ($rowff['nivel'] >= 4) { ?><br /><?php echo $row['clave'];?><?php } ?> </td>
        <td><?php echo date("d-m-Y H:i",strtotime($row['fecha']));?></td>
        <td><?php echo $losdelegados;?></td>
        <td><?php if ($rowff['nivel'] > 2) { ?><a href="eventos_invitados.php?id=<?=$row['id'];?>">Invitados</a><br /><?php } ?>
                           <a href="eventos_asistentes.php?id=<?=$row['id'];?>">Asistentes</a>
        </td>
        <td>
        <?php if ($rowff['nivel'] > 2) { ?>
        <?php if (date("Y-m-d",strtotime($row['fecha'])) >= $diahoy or $rowff['nivel'] == 4) { ?><a href="eventos_mod.php?id=<?=$row['id'];?>"><img border="0" alt="Modificar" src="body/modif.png" /></a>&nbsp;<a href="eventos_elim.php?id=<?=$row['id'];?>" onClick="return confirm('Esta seguro de borrar este evento?');"><img border="0" alt="Eliminar" src="body/elim.png"></a><?php } ?><a href="eventos_ponentes.php?id=<?php echo $row['id'];?>"><img src="body/ponente.png" alt="Ponentes" title="Ponentes"/></a>&nbsp;
          <a href="evento_estadisticas.php?evento=<?php echo $row['id'];?>"><img src="body/estadistica.png" alt="Estadistica examenes" title="Estadistica examenes"/></a>&nbsp;
          <?php if ($rowff['nivel'] >= 4) { ?><br /><a href="eventos_logs.php?evento=<?php echo $row['id'];?>"><img src="body/log.png" alt="Log incidencias" title="Log incidencias"/></a><?php } ?>
          <?php } ?>
          </td>
         
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
