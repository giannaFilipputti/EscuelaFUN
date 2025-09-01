
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_cursos_mod WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
    $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['img'] == 1) {
		   ?>
           <img src="../uploads/<?php echo $rowc['id'] .".jpg"; ?>" />
           <?php
		}
		?>
    
    <br /><br />
   
 