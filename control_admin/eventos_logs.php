<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

$sql = "SELECT * FROM com_eventos WHERE id=".$evento;
          $result = mysql_query($sql);
		  $row = mysql_fetch_array($result);
		  
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
     
        <h1>Posibles incidencias ocurridas el dia del evento: <?php echo $row['lugar']?></h1>
        <h2>Clave del evento: <?php echo $row['clave']?></h2>
        
        
    
        <?
		//echo $row['fecha'];
		$coincidencia = "password=".$row['clave'];
		   $sql1 = "SELECT * FROM err_reg WHERE DATE(fecha) = '".date("Y-m-d",strtotime($row['fecha']))."' AND origen = 'examen' ORDER BY fecha";
		 //  echo $sql1;
		   
		   $NroRegistros=mysql_num_rows(mysql_query($sql1));
		  
		  
		  //$sql1 = "SELECT * FROM com_invitados WHERE evento = ".$id." ORDER BY email";
          $result1 = mysql_query($sql1, $link) or die("el error es porque: ".mysql_error());
    ?>
    <p>Registrados: <?php echo $NroRegistros;?> incidencias.</p>
    <table cellpadding="2" cellspacing="0" border="1" width="95%" align="center">
        <tr>
        <td align="center" width="20%">Variables</td>
        <td align="center" width="20%">Fecha</td>
        <td align="center" width="20%">IP</td>
        <td align="center" width="40%">Descripcion</td>
        </tr>
        <? while ($row1 = mysql_fetch_array($result1)) {
			
			$porciones = explode("&", $row1['variables']);
			
			//echo $porciones[1];
			$laclav = explode("=", $porciones[1]);
			
			$sqlr = "SELECT * FROM com_eventos WHERE clave='".$laclav[1]."' AND DATE(fecha) = '".date("Y-m-d",strtotime($row['fecha']))."' AND clave <> '".$row['clave']."'";
			//echo $sqlr;
            if (mysql_num_rows(mysql_query($sqlr))==0) {
			 
			 
		   ?>
                <tr>
        <td align="left"><span 
		<?php if(strpos( $row1['variables'], $coincidencia ) !== false)  { ?>style="color:#F00"<?php } ?>>
		<?php echo $row1['variables'];?></span></td>
        <td align="left"><?php echo date("d-m-Y H:i",strtotime($row1['fecha']));?></td>
        <td align="left"><?php echo $row1['ip'];?></td>
        <td align="left"><?php echo $row1['error'];?></td>
        
       
         
      </tr>
                  <?php }
                   } ?>
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
