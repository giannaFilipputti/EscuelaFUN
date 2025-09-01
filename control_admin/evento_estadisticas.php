<? include("../includes/conn.php");
include("auto.php");
include("../includes/extraer_variables.php");
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
        <h1>Estadísticas</h1>
        <h2>Exámenes realizados</h2>
        <?
          $sql = "SELECT * FROM com_cursos ORDER BY id";
          $result = mysql_query($sql);
		  while ($row = mysql_fetch_array($result)) {
    ?>
   
    <?php $sql_mod = "SELECT * FROM com_cursos_mod WHERE curso = ".$row['id']." ORDER BY orden";
          $result_mod = mysql_query($sql_mod);
		  while ($row_mod = mysql_fetch_array($result_mod)) { 
		  
		  $sql_pre = "SELECT * FROM com_alumnos_exam WHERE modulo=".$row_mod['id']." AND estado = 1 AND evento =".$evento;		   
           $NroRegistrosc=mysql_num_rows(mysql_query($sql_pre));
		   
		   $sql_pre0 = "SELECT * FROM com_alumnos_exam WHERE modulo=".$row_mod['id']." AND estado = 1 AND aprobado = 0 AND evento =".$evento;	   
           $NroRegistros0=mysql_num_rows(mysql_query($sql_pre0));
		   
		   $sql_pre1 = "SELECT * FROM com_alumnos_exam WHERE modulo=".$row_mod['id']." AND estado = 1 AND aprobado = 1 AND evento =".$evento;		   
           $NroRegistros1=mysql_num_rows(mysql_query($sql_pre1));
		   ?>
         
         <h2><?php echo $row_mod['titulo']?></h2>
    
    
    <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
        <td align="center" width="40%">Realizados</td>
        <td align="center" width="35%">Aprobados</td>
        <td align="center" width="25%">No Aprobados</td>
        </tr>
        
                <tr>
        <td align="center"><a href="resultados_bus1.php?modulo=<?php echo $row_mod['id'] ?>&evento=<?php echo $evento?>"><?php echo $NroRegistrosc;?></a></td>
        <td align="center"><a href="resultados_bus1.php?modulo=<?php echo $row_mod['id'] ?>&aprobado=1&evento=<?php echo $evento?>"><?php echo $NroRegistros1;?></a></td>
        <td align="center"><a href="resultados_bus1.php?modulo=<?php echo $row_mod['id'] ?>&aprobado=0&evento=<?php echo $evento?>"><?php echo $NroRegistros0;?></a></td>
        
         
      </tr>
                  
        </table>
    <br /><br />
    <? }
	
	} ?>
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
