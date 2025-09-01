<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");




// CONTENIDO PAGINA

          $sqlffg = "SELECT * FROM com_alumnos WHERE id = ". $id ." AND codusuario LIKE '%asistente%'";
          $resultffg = mysql_query($sqlffg);
		  if(mysql_num_rows($resultffg)==1) { 
			  
			  
            $result1e = mysql_query("SELECT * FROM com_alumnos WHERE email = '".$email."' AND id <> ".$id."") or die("el error es porque: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                  
               
				
			 
                $sqlup = "UPDATE com_alumnos SET ape1 = '". $ape1 ."', ape2 = '". $ape2 ."', email = '". $email ."', nombre = '". $nombre ."' WHERE id = '".$id."'";
				$resultup = mysql_query ($sqlup,$link) or die ("hay un error en la consulta1 ".mysql_error());
				
				


			
                      header("Location: eventos_asistentes.php?id=".$evento); 
 
 }
                else {
					
				  foreach ($_GET as $key => $value) { 
  
	                  $listvar .=  $key."=".$value."&";
				  
				  }


                  header("Location: eventos_asistentes_Mmod.php?error=1&".$listvar); 
                }
				
		 }
                else {
					
				  foreach ($_GET as $key => $value) { 
  
	                  $listvar .=  $key."=".$value."&";
				  
				  }


                  header("Location: eventos_asistentes_Mmod.php?error=2&".$listvar); 
                }
		
				
?>

