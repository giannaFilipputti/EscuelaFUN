<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

$sql = "SELECT * FROM com_eventos WHERE id=".$id;
          $result = mysql_query($sql);
		  $row = mysql_fetch_array($result)
		  
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
      <div class="der divboton"><a href="eventos_asistentes_Madd.php?id=<?php echo $id;?>" class="botones">Agregar Usuarios a la reunión</a></div><br class="clearfloat" />
       <!-- <div class="der divboton"><a href="eventos_asistentes_add.php?id=<?php echo $id;?>" class="botones">Agregar Usuarios Demo</a></div><br class="clearfloat" />-->
        <div class="der divboton"><a href="usuarios.php" class="botones">Ver participantes generales</a>
        </div>
        <h1>Asistentes registrados  a reunión: <?php echo $row['lugar']?></h1>
        
        
    
        <?
		
		   $sql1 = "select com_alumnos.*, com_alumnos_eventos.tipo AS tipoz  from com_alumnos inner join com_alumnos_eventos on com_alumnos.id = com_alumnos_eventos.alumno WHERE com_alumnos_eventos.evento = ".$id. " ORDER BY com_alumnos.ape1";
		   
		   $NroRegistros=mysql_num_rows(mysql_query($sql1));
		  
		  
		  //$sql1 = "SELECT * FROM com_invitados WHERE evento = ".$id." ORDER BY email";
          $result1 = mysql_query($sql1, $link) or die("el error es porque: ".mysql_error());
    ?>
    <p>Resgistrados: <?php echo $NroRegistros;?> asistentes.</p>
    <table cellpadding="2" cellspacing="0" border="1" width="95%" align="center">
        <tr>
        <td align="center" width="15%">Apellido</td>
        <td align="center" width="15%">Nombre</td>
        <td align="center" width="15%">Email</td>
        <td align="center" width="15%">Tipo</td>
        <td align="center" width="15%">Fecha Registro</td>
        <td align="center" width="15%">Examen</td>
        <td align="center" width="10%">Modif</td>
        </tr>
        <? while ($row1 = mysql_fetch_array($result1)) {
			
			 
			 
		   ?>
                <tr>
        <td align="left"><?php echo fMayuscula($row1['ape1']." ".$row1['ape2']);?></td>
        <td align="left"><?php echo fMayuscula($row1['nombre']);?></td>
        <td align="left"><?php echo $row1['email'];?></td>
        <td align="left"><?php if ($row1['tipoz'] == 'Ponente') { echo $row1['tipoz']; } else { echo "Asistente"; }?></td>
        <td align="left"><?php echo date("d-m-Y H:i",strtotime($row1['fecreg']));?></td>
        <td align="left">
        
        <?php $sql_mod = "SELECT * FROM com_cursos_mod WHERE prueba = 0";
		        $result_mod = mysql_query($sql_mod);
				while ($row_mod = mysql_fetch_array($result_mod)) {
					
					$var_iniciado = "iniciado_".$row_mod['id'];
					$var_suspendido = "suspendido_".$row_mod['id'];
					$var_aprobado = "aprobado_".$row_mod['id'];
					$var_noiniciado = "noiniciado_".$row_mod['id'];
					
					 $sql_ex = "SELECT * FROM com_alumnos_exam WHERE alumno = ".$row1['id']. " AND modulo = ".$row_mod['id'];
				   $result_ex = mysql_query($sql_ex,$link) or die("el error es porque: ".mysql_error());
					?>
       
        
        
        <div align="center">
		<strong><?php echo $row_mod['caso'];?></strong>
		<?php if ($row_ex = mysql_fetch_array($result_ex)) {
				        if ($row_ex['estado'] == 0) { ?>
                        
                        <span class="azul">Iniciado</span>
                        <?php 						
						$$var_iniciado = $$var_iniciado + 1;
						?>
                        <?php } else { 
						         if ($row_ex['aprobado'] == 1) { ?>
                                 <span class="verde">Aprobado</span>
                                 <?php 						
						$$var_aprobado = $$var_aprobado + 1;
						?>
                                 <?php }  else { ?>
                                 <span class="roja">Suspendido</span>
                                 <?php 						
						$$var_suspendido = $$var_suspendido + 1;
						?>
               
                         <?php  } 
						 } ?>
              
              <?php } else { ?>
               No iniciado
               <?php 						
						$$var_noiniciado = $$var_noiniciado + 1;
						?>
              <?php } ?></div>
        
         <?php } ?>
         
        </td>
        <td align="center">
        <?php if(strpos( $row1['codusuario'], 'asistente' ) !== false )  { ?>
        <a href="eventos_asistentes_Mmod.php?id=<?php echo $row1['id'];?>&evento=<?php echo $id;?>"><img src="body/modif.png" /></a>
        <?php } ?> &nbsp;
        
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
