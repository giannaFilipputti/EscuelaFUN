<?php
include_once("../includes/conn.php");

extract($_GET);
if (empty($id)) $id = 'no'; 
  
          $sql = "SELECT * FROM com_ponencias_ima WHERE ponencia=".$id." AND video <> '' ORDER BY orden";
          //echo $sql;
          $result = mysql_query($sql,$link);
		   
		  
    
		$contador = 1;
		while($row = mysql_fetch_array($result)) {
			//echo "encontro";
			 $sql0 = "UPDATE com_ponencias_ima SET orden = '". $contador ."' WHERE id = ".$row['id']."";
                         echo "$sql0 - <br/>";
                        $result0 = mysql_query ($sql0,$link) or die("el error es en el insert: ".mysql_error());
     
			
		
                        $contador = $contador + 1;
		}
                
                
                $sql = "SELECT * FROM com_ponencias_ima WHERE ponencia=".$id." AND video IS NULL ORDER BY orden";
          //echo $sql;
          $result = mysql_query($sql,$link);
		   
		  
    
	
		while($row = mysql_fetch_array($result)) {
			
			 $sql0 = "UPDATE com_ponencias_ima SET orden = '". $contador ."' WHERE id = ".$row['id']."";
                         echo "$sql0 - <br/>";
                        $result0 = mysql_query ($sql0,$link) or die("el error es en el insert: ".mysql_error());
     
			
		
                        $contador = $contador + 1;
		}
                
                ?>
       