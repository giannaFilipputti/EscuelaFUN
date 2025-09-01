<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");





// CONTENIDO PAGINA
                $result1x = mysql_query("SELECT id FROM com_alumnos_demo ORDER BY id DESC LIMIT 1",$link) or die("el error es porque46: ".mysql_error());
               if(mysql_num_rows($result1x)==0) { 
                   $idx = 1;
               }
                else {
                  $rowx = mysql_fetch_array($result1x);
                  $idx = $rowx['id'] + 1;
                }
				
				$email = "pyc".$idx."@esteve.es";
				
				$sqlpi = "INSERT INTO com_alumnos_demo (id, email, evento, fecin, nombre, ape1, ape2, dni) VALUES ('".$idx."','".$email."','".$evento."','".$fechoy."','".$nombre."','".$ape1."','".$ape2."','".$dni."')";
				$result1pi = mysql_query($sqlpi,$link) or die("el error es porque46: ".mysql_error());
				
			 
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
				
				$sqlpi = "INSERT INTO com_alumnos (id, ape1, ape2, codusuario, email, nombre, dni, clave, fecha, pass, fecreg) VALUES ('".$id."','".addslashes ($ape1)."','".addslashes ($ape2)."','".$usu_codigo."', '".$email."','".addslashes ($nombre)."','".addslashes ($dni)."','".$clave00."','".$fechoy."','123458','".$fechoy."')";
				$result = mysql_query ($sqlpi,$link) or die ("hay un error en la consulta");
				
				$sqlpf = "INSERT INTO com_alumnos_eventos (alumno, evento, fecreg) VALUES ('".$id."','".$evento."','".$fechoy."')";
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta");


			
header("Location: eventos_asistentes_add2.php?evento=".$evento."&email=".$email); 
 
?>

