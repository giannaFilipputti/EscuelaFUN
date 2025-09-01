
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_cursos_mod WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
    $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['examen_pdf'] == 1) {
		   ?>
           <a href="../pdf/E_<?php echo $rowc['id'] .".pdf"?>"><img src="body/pdf_icon.png" /></a> <a href="modulos_examen_elim.php?id=<?php echo $rowc['id']?>">Eliminar</a>
           <?php
		}
		?>
    
    <br /><br />
   
 