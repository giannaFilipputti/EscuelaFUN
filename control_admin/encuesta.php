<? include("../includes/conn.php");
require_once("../includes/extraer_variables_seg.php");
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
           <div class="preg_stit">Pregunta 1</div>
           <div class="preg_tit">Puntúe del 1 (valoración mínima) al 5 (valoración máxima) los siguientes aspectos:</div>
           
           <div class="preg_preg"></div>
           
            <?php $sql_p1 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND respuesta <> ''";		   
                 $tp1=mysql_num_rows(mysql_query($sql_p1));
				 
				 
				 $sql_p1r1 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND respuesta = '1'";		   
                 $tp1r1=mysql_num_rows(mysql_query($sql_p1r1));
				 
				 $sql_p1r2 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND respuesta = '2'";		   
                 $tp1r2=mysql_num_rows(mysql_query($sql_p1r2));
				 
				 $sql_p1r3 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND respuesta = '3'";		   
                 $tp1r3=mysql_num_rows(mysql_query($sql_p1r3));
				 
				 
				 $sql_p1r4 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND respuesta = '4'";		   
                 $tp1r4=mysql_num_rows(mysql_query($sql_p1r4));
				 
				 $sql_p1r5 = "SELECT * FROM com_encuesta WHERE pregunta='p1' AND respuesta = '5'";		   
                 $tp1r5=mysql_num_rows(mysql_query($sql_p1r5));
				 
				 
				 
				 $sql_p2 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND respuesta <> ''";		   
                 $tp2=mysql_num_rows(mysql_query($sql_p2));
				 
				 
				 $sql_p2r1 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND respuesta = '1'";		   
                 $tp2r1=mysql_num_rows(mysql_query($sql_p2r1));
				 
				 $sql_p2r2 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND respuesta = '2'";		   
                 $tp2r2=mysql_num_rows(mysql_query($sql_p2r2));
				 
				 $sql_p2r3 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND respuesta = '3'";		   
                 $tp2r3=mysql_num_rows(mysql_query($sql_p2r3));
				 
				 
				 $sql_p2r4 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND respuesta = '4'";		   
                 $tp2r4=mysql_num_rows(mysql_query($sql_p2r4));
				 
				 $sql_p2r5 = "SELECT * FROM com_encuesta WHERE pregunta='p2' AND respuesta = '5'";		   
                 $tp2r5=mysql_num_rows(mysql_query($sql_p2r5));
				 
				 //p3
				 
				 $sql_p3 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND respuesta <> ''";		   
                 $tp3=mysql_num_rows(mysql_query($sql_p3));
				 
				 
				 $sql_p3r1 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND respuesta = '1'";		   
                 $tp3r1=mysql_num_rows(mysql_query($sql_p3r1));
				 
				 $sql_p3r2 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND respuesta = '2'";		   
                 $tp3r2=mysql_num_rows(mysql_query($sql_p3r2));
				 
				 $sql_p3r3 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND respuesta = '3'";		   
                 $tp3r3=mysql_num_rows(mysql_query($sql_p3r3));
				 
				 
				 $sql_p3r4 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND respuesta = '4'";		   
                 $tp3r4=mysql_num_rows(mysql_query($sql_p3r4));
				 
				 $sql_p3r5 = "SELECT * FROM com_encuesta WHERE pregunta='p3' AND respuesta = '5'";		   
                 $tp3r5=mysql_num_rows(mysql_query($sql_p3r5));
				 
				 // fin p3
				 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
             
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
                <td><?php echo $tp1r1;?></td>
                <td><?php echo $tp1r2;?></td>
                <td><?php echo $tp1r3;?></td>
                <td><?php echo $tp1r4;?></td>
                <td><?php echo $tp1r5;?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">Dinámica de la actividad</span></td>
                <td><?php echo $tp2r1;?></td>
                <td><?php echo $tp2r2;?></td>
                <td><?php echo $tp2r3;?></td>
                <td><?php echo $tp2r4;?></td>
                <td><?php echo $tp2r5;?></td>
              </tr>
              
              <tr>
                <td class="tith"><span class="labelp2">Ponentes</span></td>
                <td><?php echo $tp3r1;?></td>
                <td><?php echo $tp3r2;?></td>
                <td><?php echo $tp3r3;?></td>
                <td><?php echo $tp3r4;?></td>
                <td><?php echo $tp3r5;?></td>
              </tr>
              
             </table>
           </div>

   
           </div>
           
           <!-- pagina 2 -->
           
           <div class="box result">
           <div class="preg_stit">Pregunta 2</div>
           <div class="preg_tit">¿Utilizas habitualmente opioides? ¿Cuál es el opioide que más utilizas?</div>
           
           <div class="preg_preg"></div>
           
            <?php $sql_p4 = "SELECT * FROM com_encuesta WHERE pregunta='p4' AND respuesta <> ''";		   
                 $tp4=mysql_num_rows(mysql_query($sql_p4));
				 
				  $sql_nav = "SELECT respuesta, count(respuesta) AS contador FROM com_encuesta WHERE respuesta <> '' AND pregunta = 'p4'";
			       $sql_nav .= " group by respuesta having count(respuesta)>0 ORDER BY contador DESC LIMIT 50";
		 		   
		          $result_nav = mysql_query($sql_nav,$link) or die("el error es porque: ".mysql_error());
		  		 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
               <?php while ($row_nav = mysql_fetch_array($result_nav)){ ?>
              <tr>
         
                <td><?php echo $row_nav['respuesta']?></td>
                <td><?php echo $row_nav['contador']?></td>
              </tr>
              
              
              <?php } ?>
  
              
             
              
             </table>
           </div>

   
           </div>
           
           
           <!-- pagina 2 -->
           <!-- pagina 3 -->
           
           <div class="box result">
           <div class="preg_stit">Pregunta 3</div>
           <div class="preg_tit">¿Consideras a Tapentadol como un opioide seguro con menos 
efectos adversos?</div>
           
           <div class="preg_preg"></div>
           
            <?php $sql_p5 = "SELECT * FROM com_encuesta WHERE pregunta='p5' AND respuesta <> ''";		   
                 $tp5=mysql_num_rows(mysql_query($sql_p5));
				 
				 
				 $sql_p5r1 = "SELECT * FROM com_encuesta WHERE pregunta='p5' AND respuesta = 'si'";		   
                 $tp5r1=mysql_num_rows(mysql_query($sql_p5r1));
				 
				 $sql_p5r2 = "SELECT * FROM com_encuesta WHERE pregunta='p5' AND respuesta = 'no'";		   
                 $tp5r2=mysql_num_rows(mysql_query($sql_p5r2));
				 
				
				 
				
				 
				 
				 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
             
              <tr>
         
                <td><strong>SI</strong></td>
                <td><strong>NO</strong></td>
              </tr>
              <tr>
  
                <td><?php echo $tp5r1;?></td>
                <td><?php echo $tp5r2;?></td>
              </tr>
              
             
              
             </table>
           </div>

   
           </div>
           
           
           <!-- pagina 3 -->
           
           <div class="box result">
           <div class="preg_stit">Pregunta 4</div>
           <div class="preg_tit">¿Consideras a Tapentadol como un opioide que se puede dar en 
monoterapia en el tratamiento del dolor con componente neuropático? </div>
           
           <div class="preg_preg"></div>
           
            <?php $sql_p6 = "SELECT * FROM com_encuesta WHERE pregunta='p6' AND respuesta <> ''";		   
                 $tp6=mysql_num_rows(mysql_query($sql_p6));
				 
				 
				 $sql_p6r1 = "SELECT * FROM com_encuesta WHERE pregunta='p6' AND respuesta = 'si'";		   
                 $tp6r1=mysql_num_rows(mysql_query($sql_p6r1));
				 
				 $sql_p6r2 = "SELECT * FROM com_encuesta WHERE pregunta='p6' AND respuesta = 'no'";		   
                 $tp6r2=mysql_num_rows(mysql_query($sql_p6r2));
				 
				
				 
				
				 
				 
				 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
             
              <tr>
         
                <td><strong>SI</strong></td>
                <td><strong>NO</strong></td>
              </tr>
              <tr>
  
                <td><?php echo $tp6r1;?></td>
                <td><?php echo $tp6r2;?></td>
              </tr>
              
             
              
             </table>
           </div>

   
           </div>
           
           <!-- fin pg4 -->
           <!-- pagina 5 -->
           
           <div class="box result">
           <div class="preg_stit">Pregunta 5</div>
           <div class="preg_tit">¿Con que dosis de Tapentadol inicias el tratamiento?</div>
           
           <div class="preg_preg"></div>
           
            <?php $sql_p7 = "SELECT * FROM com_encuesta WHERE pregunta='p7' AND respuesta <> ''";		   
                 $tp7=mysql_num_rows(mysql_query($sql_p7));
				 
				  $sql_nav = "SELECT respuesta, count(respuesta) AS contador FROM com_encuesta WHERE respuesta <> '' AND pregunta = 'p7'";
			       $sql_nav .= " group by respuesta having count(respuesta)>0 ORDER BY contador DESC LIMIT 50";
		 		   
		          $result_nav = mysql_query($sql_nav,$link) or die("el error es porque: ".mysql_error());
		  		 
				  ?>
           
           <div class="bloque espaciado">
             <table width="100%" cellpadding="0" cellspacing="0" border="0">
               <?php while ($row_nav = mysql_fetch_array($result_nav)){ ?>
              <tr>
         
                <td><?php echo $row_nav['respuesta']?></td>
                <td><?php echo $row_nav['contador']?></td>
              </tr>
              
              
              <?php } ?>
  
              
             
              
             </table>
           </div>

   
           </div>
           
           
           <!-- pagina 5 -->
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
