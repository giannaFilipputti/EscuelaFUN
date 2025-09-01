<?php include("../includes/conn.php");
include("auto.php");
include("../includes/extraer_variables.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
      
        <h1>Exámenes</h1>
        <?php
		foreach ($_GET as $key => $value) 
       { 
         if ($key != 'pag') {
	       $listvar .=  $key."=".$value."&";
         }
        if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
           $listvaro .=  $key."=".$value."&";
         }
  
        }


          $sql = "SELECT com_alumnos_exam.* FROM com_alumnos_exam INNER JOIN com_alumnos_resp ON com_alumnos_exam.id = com_alumnos_resp.id_exam_mod WHERE com_alumnos_resp.pregunta = 27 AND com_alumnos_resp.correcta = 0 AND com_alumnos_exam.aprobado <> 1 AND com_alumnos_exam.alumno <> 1";
		  
		  if (!empty($modulo)) {
			   $sql .= "modulo = ". $modulo ." AND ";
		  }
		  
		  if (!empty($datepicker)) {
			   $sql .= "fecfin >= '". $datepicker ."' AND ";
		  }
		  
		  if (!empty($datepicker1)) {
			  $datepicker1 = $datepicker1 . " 23:59:30";
			   $sql .= "fecfin <= '". $datepicker1 ."' AND ";
		  }
		  
		  if (!empty($aprobado)) {
			  if ($aprobado == 2) {
				  $aprobado = 0;
				  }
			   $sql .= "aprobado = ". $aprobado ." AND ";
		  }
		  
		  $sql .= " ORDER BY com_alumnos_exam.alumno";
		  //echo $sql;
          $result = mysql_query($sql,$link) or die("el error es porque: ".mysql_error());
    ?>
    <div style="text-align:right; padding:10px"><a href="resultados_bus_csv.php?<?php echo $listvaro?>">Descargar CSV</a></div>
    <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
        <td align="center" width="25%">Capítulo / Curso</td>
        <td align="center" width="25%">Alumno</td>
        <td align="center" width="15%">Estado</td>
        <td align="center" width="20%">Inicio / Fin</td>
        <td align="center" width="15%">Ver Respuestas</td>
        </tr>
        <?php while ($row = mysql_fetch_array($result)) {
			
			$sql_pre = "SELECT * FROM com_exam_preg  WHERE modulo=".$row['modulo']." ORDER BY orden1";
		   
           $result_pre = mysql_query($sql_pre,$link);
           $NroRegistrosc=mysql_num_rows(mysql_query($sql_pre));
		   
		   $porcentaje = round(($row['nota'] * 100) / $NroRegistrosc);
		   
			$sql_cap = "SELECT * FROM com_cursos_mod WHERE id = ". $row['modulo'] ."";
            $result_cap = mysql_query($sql_cap);
			$row_cap = mysql_fetch_array($result_cap);
			
			$sql_cur = "SELECT * FROM com_cursos WHERE id = ". $row_cap['curso'] ."";
            $result_cur = mysql_query($sql_cur);
			$row_cur = mysql_fetch_array($result_cur);
			
			$sql_al = "SELECT * FROM com_alumnos WHERE id = ". $row['alumno'] ."";
            $result_al = mysql_query($sql_al);
			$row_al = mysql_fetch_array($result_al);
		  
		  
                ?>
                <tr>
        <td align="left"><?php if ($row_cur['examen'] == 1) {?><?php echo $row_cur['titulo'];?><?php } else { ?><?php echo $row_cap['titulo'];?> (<?php echo $row_cur['titulo'];?>)<?php } ?></td>
        <td align="left"><?php echo utf8_encode($row_al['ape1']." ".$row_al['ape2'].", ".$row_al['nombre'])?><br /><?php echo $row_al['email'];?>
        <br /><?php echo $row_al['codusuario'];?>
        </td>
        
        <td align="left"><?php if ($row['estado'] == 0) {?>No Finalizado<?php } else { ?>
		Finalizado (Nota: <?php echo $row['nota']?><br><?php echo $porcentaje?>% - <?php if ($row['aprobado'] == 0) {?>NO<?php } ?> Aprobado)
		<?php } ?>
                
        </td>
        <td align="left"><?php echo $row['fecini'];?> <br /><?php if ($row['estado'] == 1) {
			echo $row['fecfin'];
		} ?></td>
        <td align="center"><?php if ($row['estado'] == 1) { ?><a href="usuarios_examenes.php?id=<?php echo $row['alumno'];?>">Ver examenes</a><?php } ?></td>
         
      </tr>
                  <?php } ?>
        </table>
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
