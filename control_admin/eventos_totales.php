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
        <h2>Reuniones registradas</h2>
        <div class="der">
          
        </div>
        <br /><br />        <?php
          //$sql = "SELECT *, 'a' AS ordenar FROM com_eventos WHERE  ORDER BY fecha";
		  
		  //$diahoy = date('Y-m-d');
		 
		  $msqldes1 = "SELECT com_eventos.id, com_eventos.lugar, com_eventos.ciudad, com_eventos.fecha, com_eventos.delegados FROM com_eventos INNER JOIN com_alumnos_exam ON com_eventos.id = com_alumnos_exam.evento WHERE com_eventos.fecha <= '".$diahoy."' AND estado = 1";
		 
		
		   
	
	   
	   $msqldes1 .= " GROUP BY com_eventos.id ORDER BY fecha";
	   
	   
	   //echo $msqldes1;
	      $NroRegistrosc=mysql_num_rows(mysql_query($msqldes1));
	   
          $result = mysql_query($msqldes1);
		  
		  echo "Total eventos: ".$NroRegistrosc;
        ?>
    <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center">
        <tr>
        <td align="center" width="20%">Lugar</td>
        <td align="center" width="20%">Fecha</td>
        <td align="center" width="20%">Delegado</td>
        <td align="center" width="20%">Invitados</td>
        <td align="center" width="10%">Acciones</td>
        </tr>
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
        <td align="left"><?php echo $row['lugar'];?><br /><strong><?php echo $row['ciudad'];?></strong> </td>
        <td align="left"><?php echo date("d-m-Y H:i",strtotime($row['fecha']));?></td>
        <td align="left"><?php echo $losdelegados;?></td>
        <td align="center"><a href="eventos_invitados.php?id=<?=$row['id'];?>">Invitados</a><br />
                           <a href="eventos_asistentes.php?id=<?=$row['id'];?>">Asistentes</a>
        </td>
        <td align="center"><a href="eventos_mod.php?id=<?=$row['id'];?>"><img border="0" alt="Modificar" src="body/modif.gif" /></a>&nbsp;<a href="eventos_elim.php?id=<?=$row['id'];?>" onClick="return confirm('Esta seguro de borrar este evento?');"><img border="0" alt="Eliminar" src="body/elim.gif"></a><a href="eventos_ponentes.php?id=<?php echo $row['id'];?>"><img src="body/ponente.png" alt="Ponentes" title="Ponentes"/></a>&nbsp;
          <a href="evento_estadisticas.php?evento=<?php echo $row['id'];?>"><img src="body/estadistica.png" alt="Estadistica examenes" title="Estadistica examenes"/></a></td>
         
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
