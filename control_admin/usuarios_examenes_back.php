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
          $sql_al = "SELECT * FROM com_alumnos WHERE id = ". $id ."";
          $result_al = mysql_query($sql_al);
		  $row_al = mysql_fetch_array($result_al);
    ?>
        <h1>Examenes</h1>
        <h2>Examenes realizados por el usuario: <?php echo $row_al['ape1']." ".$row_al['ape2'].", ".$row_al['nombre']?></h2>
        <?
          $sql = "SELECT * FROM com_alumnos_exam WHERE alumno = ". $id ." ORDER BY fecini";
          $result = mysql_query($sql);
    ?>
    <table>
    <thead>
        <tr>
        <td width="30%">Capitulo / Curso</td>
        <td width="20%">Estado</td>
        <td width="30%">Inicio / Fin</td>
        <td width="20%">Ver Respuestas</td>
        </tr>
       </thead>
        <? while ($row = mysql_fetch_array($result)) {
			
			$sql_pre = "SELECT * FROM com_exam_preg WHERE modulo=".$row['modulo']." ORDER BY orden";
		   
           $result_pre = mysql_query($sql_pre1,$link);
           $NroRegistrosc=mysql_num_rows(mysql_query($sql_pre));
		   
		   $porcentaje = ($row['nota'] * 100) / $NroRegistrosc;
		   
			$sql_cap = "SELECT * FROM com_cursos_mod WHERE id = ". $row['modulo'] ."";
            $result_cap = mysql_query($sql_cap);
			$row_cap = mysql_fetch_array($result_cap);
			
			$sql_cur = "SELECT * FROM com_cursos WHERE id = ". $row_cap['curso'] ."";
            $result_cur = mysql_query($sql_cur);
			$row_cur = mysql_fetch_array($result_cur);
		  
		  
                ?>
                <tr>
        <td><?=$row_cap['titulo'];?> (<?=$row_cur['titulo'];?>)</td>
        
        <td><?php if ($row['estado'] == 0) {?>No Finalizado<?php } else { ?>
		Finalizado (<?php echo $porcentaje?>% - <?php if ($row['aprobado'] == 0) {?>NO<?php } ?> Aprobado)
		<?php } ?>
                
        </td>
        <td><?=$row['fecini'];?> <br /><?php if ($row['estado'] == 1) {
			echo $row['fecfin'];
		} ?></td>
        <td><?php if ($row['estado'] == 1) { ?><a href="usuarios_respuestas.php?id=<?=$row['id'];?>&alumno=<?php echo $id;?>&modulo=<?php echo $row['modulo'];?>">Ver Respuestas</a><?php } ?><br />
        <a href="usuarios_examenes_reset.php?id=<?=$row['id'];?>&alumno=<?php echo $id;?>&modulo=<?php echo $row['modulo'];?>"  onClick="return confirm('Se borrarán todas las preguntas del examen, y el resultado final, desea continuar?');">Reiniciar examen</a>
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
