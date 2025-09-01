<?php
include_once("../includes/conn.php");

extract($_GET);
if (empty($id)) $id = 'no'; 

          $sql = "SELECT * FROM com_ponencias WHERE id=".$id."";
          //echo $sql;
          $result = mysql_query($sql,$link);
		   
		  
   $row = mysql_fetch_array($result);
			
			if ($row['imagen'] == 1) {
				?>
                <img src="../uploads/imagenes/<?php echo $id?>.jpg" />
                <?php 
				
				}
			?>