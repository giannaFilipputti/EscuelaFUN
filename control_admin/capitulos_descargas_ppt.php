
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_cursos_mod_cap WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
    $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['ppt'] == 1) {
		   ?>
           <a href="../pdf/<?php echo"ppt_".urls_amigables(cortar_string ($rowc['titulo'], 15))."_".$rowc['id'] .".".$rowc['ppt_ext']?>"><img src="body/ppt.png" /></a> <a href="capitulos_ppt_elim.php?id=<?php echo $rowc['id']?>">Eliminar</a>
           <?php
		}
		?>
    
    <br /><br />
   
 