
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_cursos_mod_cap WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
    $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['pdf_med'] == 1) {
		   ?>
           PDF para <?php echo verTipoUsuario('med')?>: <a href="../pdf/<?php echo urls_amigables($rowc['titulo'])."_".$rowc['id'] ."_med.pdf"?>"><img src="body/pdf_icon.png" /></a> <a href="capitulos_down_elim.php?id=<?php echo $rowc['id']?>&tipo=med">Eliminar</a>
           <?php
		}
		?>
    
    <br /><br />
   
 