<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");



$result1e = mysql_query("SELECT id FROM com_invitados ORDER BY id DESC LIMIT 1",$link) or die("el error es porque: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $ide = 1;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $ide = $rowe['id'] + 1;
                }
				
// CONTENIDO PAGINA
 $sql_ev = "SELECT * FROM com_eventos WHERE id = ".$evento."";
          $result_ev = mysql_query($sql_ev);
		  $row_ev = mysql_fetch_array($result_ev);
		  
		  
	 $sql_ma = "SELECT * FROM com_mailformato LIMIT 1";
          $result_ma = mysql_query($sql_ma);
		  $row_ma = mysql_fetch_array($result_ma);
		  
		  
		  $sql_del = "SELECT * FROM com_users WHERE id = ".$delegado;
          $result_del = mysql_query($sql_del);
		  $row_del = mysql_fetch_array($result_del);
		  
		
		

$fechai = $fecha ." ".$hora.":".$minuto;
$sqlp = "INSERT INTO com_invitados (id, email, evento, fecin, nombre, apellido, userin, invitacion, delegado) VALUES ('".$ide."','".$email."','".$evento."','".$fechoy."','".$nombre."','".$apellido."','".$row_del['id']."','".$edoresultado."','".$delegado."')";

$result = mysql_query ($sqlp,$link) or die("el error es en el insert: ".mysql_error());


/* aqui empieza a ingresar el nvitado a la lista de asistentes */
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
				
				$sqlpi = "INSERT INTO com_alumnos (id, ape1, ape2, codusuario, email, nombre, dni, clave, fecha, pass, fecreg, origen) VALUES ('".$id."','".addslashes ($apellido)."','".addslashes ($ape2)."','".$usu_codigo."', '".$email."','".addslashes ($nombre)."','".addslashes ($dni)."','".$clave00."','".$fechoy."','123458','".$fechoy."','3')";
				$result = mysql_query ($sqlpi,$link) or die ("hay un error en la consulta");
				
				$sqlpf = "INSERT INTO com_alumnos_eventos (alumno, evento, delegado, delegado_campo, fecreg) VALUES ('".$id."','".$evento."','".$delegado."','".$row_del['nombre_clave']."', '".$fechoy."')";
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta");


			
                      
 
 }
                else {
					
					$rowff1 = mysql_fetch_array($result1e);
					
				    $resulter = mysql_query("SELECT * FROM com_alumnos_eventos WHERE alumno = ". $rowff1['id'] ." AND evento = ".$evento."",$link) or die("el error es porque41: ".mysql_error());
            // aqui va el codigo
			  if ($rower = mysql_fetch_array($resulter)){
				
				$sqlpf = "UPDATE com_alumnos_eventos SET alumno = '".$rowff1['id']."', evento = '".$evento."', delegado = '".$delegado."', delegado_campo = '".$row_del['nombre_clave']."', fecreg = '".$fechoy."' WHERE id = ".$rower['id'];
				//echo $sqlpf ;
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta1");
				
			  } else {
				  $sqlpf = "INSERT INTO com_alumnos_eventos (alumno, evento, delegado, delegado_campo, fecreg) VALUES ('".$rowff1['id']."','".$evento."','".$delegado."','".$row_del['nombre_clave']."', '".$fechoy."')";
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta1");
				}
     
                }


/* aqui termina de ingresar el invitado a la lista de asistentes*/



header("Location: eventos_invitados.php?id=".$evento); 
 
?>

