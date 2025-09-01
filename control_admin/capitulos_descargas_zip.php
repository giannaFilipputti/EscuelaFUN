
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_cursos_mod_cap WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
    $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['zip'] == 1) {
		   ?>
           <a href="../pdf/<?php echo $rowc['id'] .".zip"?>"><img src="body/zip.png" /></a> <a href="capitulos_zip_elim.php?id=<?php echo $rowc['id']?>">Eliminar</a>
           <?php
		}
		?>
    
    <br /><br />
   
 