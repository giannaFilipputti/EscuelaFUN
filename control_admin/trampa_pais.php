<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

           $sql_men3 = "SELECT * FROM com_alumnos  WHERE com_alumnos.provincia = '' OR com_alumnos.provincia IS NULL";
		  
		   
		   
		  // echo $sql_men31;
		   $result_men3 = mysql_query($sql_men3,$link);
           $conta = 1;
			 while ($row_men3 = mysql_fetch_array($result_men3)) { 
			  echo $conta." - No tiene provincia: ".$row_men3['email']."<br>";
			 
			   $sql_p7 = "SELECT * FROM com_alumnosEEE WHERE email='".$row_men3['email']."'";	
		       $result_p7 = mysql_query($sql_p7,$link);
		       if ($row_p7 = mysql_fetch_array($result_p7)) {
				   echo $conta." - Ya contesto la 7 el: ".$row_p7['email']."<br>";
				   
				     $sqlp = "UPDATE com_alumnos SET pais = '".$row_p7['pais']."' WHERE id = '".$row_men3['id']."'";
					echo $sqlp."<br>";
					//$resultp = mysql_query ($sqlp,$link);
				   } else {
					   
					  
			   
			 
			 
		  
				   }
				     $conta++;
                } ?>
      