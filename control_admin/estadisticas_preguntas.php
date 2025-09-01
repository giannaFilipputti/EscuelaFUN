<? include("../includes/conn.php");
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
        <h1>Estadisticas</h1>
        <?php 
          $sql_1 = "SELECT * FROM com_cursos_mod WHERE id = '". $modulo ."'";
          $result_1 = mysql_query($sql_1);
		  if ($row_1 = mysql_fetch_array($result_1)) {
			  
			  
		  
		  
		 
		  
		  
			   
		     $sql_nj = "SELECT * FROM com_alumnos_exam WHERE modulo = ".$modulo." AND estado = 1";
             $result_nj = mysql_query($sql_nj);
		     $exam_total = mysql_num_rows($result_nj); 
			   
              ?> 
            <h2><?php echo $row_1['titulo']?></h2>
                 
                  <?php
		
		 
			$sql_men3 = "SELECT * FROM com_exam_preg WHERE modulo=".$modulo."";
			
			//echo $sql_men3;
		   
		   $sql_men31 = $sql_men3." ORDER BY orden";
		   $result_men3 = mysql_query($sql_men31,$link);
           
			?>
           
            <div class="usuarios" style="float:left; width:20%;">Total participantes: <?php echo $exam_total;?></div>
            <div class="centrado" style="float:left; width:60%;">Para ver las respuestas razonadas haz click encima del número de la pregunta</div>
            <br class="clearfloat" />
            
            <br />
            
            <div style="float:left; width:7%; padding:3px 0;">PREG</div>
            <div style="float:left; width:8%; padding:3px 0;">CORRECTAS</div>
            <div style="float:left; width:85%;  padding:3px 0;">&nbsp;</div>
            <br class="clearfloat" />
           
           
           
            <?php
  
           $contador = 0;
		    while ($row_men3 = mysql_fetch_array($result_men3)) { 
			 $contador = $contador + 1;
			 
			  $sql_men4 = "SELECT com_alumnos_resp.* FROM com_alumnos_resp INNER JOIN com_alumnos_exam on com_alumnos_exam.alumno = com_alumnos_resp.alumno WHERE com_alumnos_resp.pregunta=".$row_men3['id']." AND correcta = 1 GROUP BY com_alumnos_resp.id";
			  
			  //echo $sql_men4;
              $result_men4 = mysql_query($sql_men4,$link);
			  
			  while ($row_men4 = mysql_fetch_array($result_men4)) { 
			  //echo $row_men4['id']."-";
			  
			  }
              //$row_men4 = mysql_fetch_array($result_men4);
			  $resp_total = mysql_num_rows($result_men4); 
			  $proc_total = ($resp_total * 100) / $exam_total;
			  
			  if ($proc_total == 0) {
				  
				  $proc_total = 1;
				  
				  }
			  
			  //echo $resp_total;
			 
			 
			 
		   ?>
           
           
           <div style="float:left; width:7%; padding:3px 0;"><a href="ponente_res_preg.php?evento=<?php echo $evento?>&modulo=<?php echo $modulo?>&moduloo=<?php echo $moduloo?>&preg=<?php echo $row_men3['id'] ?>"><?php echo $contador?></a></div>
            <div style="float:left; width:8%; padding:3px 0;">(<?php echo $resp_total;?>)</div>
            <div style="float:left; width:85%;  padding:3px 0;"><div style="width:<?php echo $proc_total; ?>%; background:#00B737;">&nbsp;</div></div>
            <br class="clearfloat" />
           
          
           <?php
		   
		   }?>
           
         <div class="div7" style="float:left; width:3%; padding:3px 0;">&nbsp;</div>
          <div class="div7" style="float:left; width:5%; padding:3px 0;">&nbsp;</div>
            <div style="float:left; width:92%;  padding:3px 0;">
              <div style="float:left; width:13%; text-align:left">0%</div>
              <div style="float:left; width:12%; text-align: right">25%</div>
              <div style="float:left; width:25%; text-align: right">50%</div>
              <div style="float:left; width:25%; text-align: right">75%</div>
              <div style="float:left; width:25%; text-align: right">100%</div>
              <br class="clearfloat" />
              <div class="centrado negrita">% de respuestas correctas</div>
            </div>
         
         
          <?php } ?>
         
          
          
          <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
