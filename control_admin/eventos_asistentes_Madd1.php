<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");




// CONTENIDO PAGINA
            $result1e = mysql_query("SELECT * FROM com_alumnos WHERE email = '".$email."'") or die("el error es porque: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                  
               
				
			 
                 $result1e = mysql_query("SELECT id FROM com_alumnos ORDER BY id DESC LIMIT 1",$link) or die("el error es porque46: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $id = 1;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $id = $rowe['id'] + 1;
                }
				
				$clave00 = createhash($tokensArray,$hashLenght);
				$clave02 = createhash($tokensArray,$hashLenght);
				$usu_codigo = "asistente".$id;
				
				$sqlpi = "INSERT INTO com_alumnos (id, ape1, ape2, codusuario, email, nombre, dni, clave, fecha, pass, fecreg, origen) VALUES ('".$id."','".addslashes ($ape1)."','".addslashes ($ape2)."','".$usu_codigo."', '".$email."','".addslashes ($nombre)."','".addslashes ($dni)."','".$clave00."','".$fechoy."','123458','".$fechoy."','2')";
				$result = mysql_query ($sqlpi,$link) or die ("hay un error en la consulta");
				
				$sqlpf = "INSERT INTO com_alumnos_eventos (alumno, evento, fecreg) VALUES ('".$id."','".$evento."','".$fechoy."')";
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta");


			
                      header("Location: eventos_asistentes.php?id=".$evento); 
 
 }
                else {
					
				  foreach ($_GET as $key => $value) { 
  
	                  $listvar .=  $key."=".$value."&";
				  
				  }


                  header("Location: eventos_asistentes_Madd.php?error=1&".$listvar); 
                }
				
?>

