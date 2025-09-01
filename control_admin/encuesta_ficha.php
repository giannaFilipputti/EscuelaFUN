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
        <h1>Estadísticas</h1>
        <h2>Encuesta</h2>
       <div class="contenido boxed">
           <div style="text-align:right;"><a href="encuesta_users.php">Ver respuestas por usuarios</a></div>
           
           <div class="box result">
           
           <div class="preg_tit">Puntúe del 1 (valoración mínima) al 5 (valoración máxima) los siguientes aspectos:</div>
           <div class="preg_stit">Pregunta 1</div>
           <div class="preg_preg"></div>
           
            <?php $sql_p1 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND user = ".$id;
			//echo $sql_p1;	
		   $result_p1 = mysql_query($sql_p1,$link);
		   $row_p1 = mysql_fetch_array($result_p1);	
		   
		   
		   $sql_p2 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND user = $id";	
		   $result_p2 = mysql_query($sql_p2,$link);
		   $row_p2 = mysql_fetch_array($result_p2);  
		   
		   
		   $sql_p3 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND user = $id";	
		   $result_p3 = mysql_query($sql_p3,$link);
		   $row_p3 = mysql_fetch_array($result_p3); 
		   
		   //echo $row_p1['respuesta'];  
                 
				 
				 // fin p3
				 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="1">
             
              <tr>
                <td>&nbsp;</td>
                <td><strong>1</strong></td>
                <td><strong>2</strong></td>
                <td><strong>3</strong></td>
                <td><strong>4</strong></td>
                <td><strong>5</strong></td>
              </tr>
              <tr>
                <td class="tith"><span class="labelp1">Contenido Cientifico</span></td>
                <td <?php if ($row_p1['respuesta'] == 1) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p1['respuesta'] == 2) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p1['respuesta'] == 3) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p1['respuesta'] == 4) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p1['respuesta'] == 5) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">Dinámica de la actividad</span></td>
                <td <?php if ($row_p2['respuesta'] == 1) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p2['respuesta'] == 2) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p2['respuesta'] == 3) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p2['respuesta'] == 4) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p2['respuesta'] == 5) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">Ponentes</span></td>
                <td <?php if ($row_p3['respuesta'] == 1) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p3['respuesta'] == 2) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p3['respuesta'] == 3) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p3['respuesta'] == 4) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p3['respuesta'] == 5) { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
              </tr>
              
             </table>
           </div>

   
           </div>
           
           <!-- pagina 2 -->
           
           <div class="box result">
           
           <div class="preg_tit">¿Utilizas habitualmente opioides? ¿Cuál es el opioide que más 
utilizas?</div>
           <div class="preg_stit">Pregunta 2</div>
           <div class="preg_preg"></div>
           
            <?php $sql_p4 = "SELECT * FROM com_encuesta WHERE pregunta='p4' AND user = ".$id;	
		   $result_p4 = mysql_query($sql_p4,$link);
		   $row_p4 = mysql_fetch_array($result_p4);	
		   
		   
		   
		     
                 
				 
				 // fin p3
				 
				  ?>
           
           <div class="bloque espaciado">
             <?php echo $row_p4['respuesta']; ?>
           </div>

   
           </div>
           <!-- pagina 3 -->
           
           <div class="box result">
           
           <div class="preg_tit">¿Consideras a Tapentadol como un opioide seguro con menos 
efectos adversos?</div>
           <div class="preg_stit">Pregunta 3</div>
           <div class="preg_preg"></div>
           
            <?php $sql_p5 = "SELECT * FROM com_encuesta WHERE pregunta='p5' AND user = ".$id;	
		   $result_p5 = mysql_query($sql_p5,$link);
		   $row_p5 = mysql_fetch_array($result_p5);	
				
				 
				
				 
				 
				 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
             
              <tr>
         
                <td><strong>SI</strong></td>
                <td><strong>NO</strong></td>
              </tr>
              <tr>
  
                <td <?php if ($row_p5['respuesta'] == 'si') { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p5['respuesta'] == 'no') { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
              </tr>
              
             
              
             </table>
           </div>

   
           </div>
           
           
           <!-- pagina 3 -->
           
           <div class="box result">
           
           <div class="preg_tit">¿Consideras a Tapentadol como un opioide que se puede dar en 
monoterapia en el tratamiento del dolor con componente neuropático? </div>
           <div class="preg_stit">Pregunta 4</div>
           <div class="preg_preg"></div>
           
            <?php $sql_p6 = "SELECT * FROM com_encuesta WHERE pregunta='p6' AND user = ".$id;	
		   $result_p6 = mysql_query($sql_p6,$link);
		   $row_p6 = mysql_fetch_array($result_p6);	
				 
				 
				 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
             
              <tr>
         
                <td><strong>SI</strong></td>
                <td><strong>NO</strong></td>
              </tr>
              <tr>
  
                <td <?php if ($row_p6['respuesta'] == 'si') { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
                <td <?php if ($row_p6['respuesta'] == 'no') { ?> bgcolor="#00FF05"<?php } ?>>&nbsp;</td>
              </tr>
              
             
              
             </table>
           </div>

   
           </div>
           
           <!-- fin pg4 -->
           
           <!-- pagina 5 -->
             <?php $sql_p7 = "SELECT * FROM com_encuesta WHERE pregunta='p7' AND user = ".$id;	
		   $result_p7 = mysql_query($sql_p7,$link);
		   if ($row_p7 = mysql_fetch_array($result_p7)) {
		 
				  ?>
           <div class="box result">
           
           <div class="preg_tit">¿Con que dosis de Tapentadol inicias el tratamiento?</div>
           <div class="preg_stit">Pregunta 5</div>
           <div class="preg_preg"></div>
           
          
           
           <div class="bloque espaciado">
           <?php if ($row_p7['fal'] == 0) { ?>
             <?php echo $row_p7['respuesta']; ?>
           <?php } ?>
           </div>

   
           </div>
           <?php } ?>
        <div class="errores">
        
        </div>
        
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
