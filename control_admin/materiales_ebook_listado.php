
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_material WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
         $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['ebook'] == 1) {
		   ?>
           eBook para <?php echo $rowc['nombre'];?>: <a href="../material/<?php echo $rowc['ebook_url'] ?>"><img src="body/ebook.png" /></a>
           <?php
		}
		?>
    
    <br /><br />
   
 