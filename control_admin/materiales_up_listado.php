
<?php

include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sqlc = "SELECT * FROM com_material WHERE id=".$id."";
		  //echo $sqlc;
         $resultc = mysql_query($sqlc,$link) or die("el error es porque: ".mysql_error());
    $rowc = mysql_fetch_array($resultc); 
		   if ($rowc['pdf'] == 1) {
		   ?>
           PDF para <?php echo $rowc['pdf'];?>: <a href="../material/<?php echo "descarga_".$rowc['id'] .".pdf"?>"><img src="body/pdf_icon.png" /></a>
           <?php
		}
		?>
    
    <br /><br />
   
 