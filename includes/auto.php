<?php 
/* $message = "emp";
foreach($_POST as $nombre_campo => $valor){ 
   $message .= '$' . $nombre_campo . '=\'' . $valor . '\';<br />';
   //eval($asignacion); 
} 
$message .= " termina";
echo $message; */


if(strpos($_SERVER['REQUEST_URI'], '/webARC/no_access.php') !== false )  {
	//echo "no pasa nada"; 
}
else {
	


	

$fecha = date('Y-m-d H:i:s');

$login = $_COOKIE["codusuario_jko"];


if (empty($_COOKIE["codusuario_jko"])) {
	 $revisar_post = 'si';
	 //echo 'no hay cookie';
} else {
	$resultff = mysql_query("SELECT * FROM com_users WHERE id = ". $_COOKIE["id_jko"] ."",$link) or die("el error es porque333: ".mysql_error());

    if ($rowff = mysql_fetch_array($resultff)){
	   if ($rowff['clave'] != $_COOKIE["clave"]) {	   
		   $revisar_post = 'si';
		} else {
		  $revisar_post = 'no';
		}
       } else {
          $revisar_post = 'si';
       }
}

//echo $revisar_post;
if ($revisar_post == 'si') {
	
	/* foreach($_POST as $variable => $valor)
    {
    echo $variable;
        
    } */
	
	extract($_POST);
	
	$url = $_SERVER['HTTP_REFERER'];
	$url_original = 'esteve.es/EsteveFront';
	//$url_original = '/webARC/no_access.php';
	//echo $url;
	if(strpos( $url, $url_original ) !== false )  {
		//echo "aqui entra";
		//echo "<br>el codigo de usuario". $usu_codusuario;
		if (!empty($usu_codusuario)) {
			$resultff = mysql_query("SELECT * FROM com_users WHERE codusuario = '". $usu_codusuario ."'",$link) or die("el error es porque44: ".mysql_error());
            // aqui va el codigo
			  if ($rowff = mysql_fetch_array($resultff)){
				$clave00 = createhash($tokensArray,$hashLenght);
				$clave02 = createhash($tokensArray,$hashLenght);
				$sqlup = "UPDATE com_users SET ape1 = '". $usu_ape1 ."', ape2 = '". $usu_ape2 ."', email = '". $usu_correo ."', nombre = '". $usu_nombre ."', clave = '". $clave00 ."', fecha  = '". $fecha ."', pass = '".$clave02."' WHERE codusuario = '".$usu_codusuario."'";
				$resultup = mysql_query ($sqlup,$link) or die ("hay un error en la consulta");
				setcookie("codusuario_jko", $codusuario);
                setcookie("id_jko", $rowff['ido']);
                setcookie("clave", $clave00);
				
			} else {
				
			   $result1e = mysql_query("SELECT id FROM com_users ORDER BY id DESC LIMIT 1",$link) or die("el error es porque44grt: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $id = 1;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $id = $rowe['id'] + 1;
                }
				
				$clave00 = createhash($tokensArray,$hashLenght);
				$clave02 = createhash($tokensArray,$hashLenght);
				
				$sqlpi = "INSERT INTO com_users (id, ape1, ape2, codusuario, email, nombre, clave, fecha, pass) VALUES ('".$id."','".$usu_ape1."','".$usu_ape2."','".$usu_codusuario."', '".$usu_correo."','".$usu_nombre."','".$clave00."','".$fecha."','".$clave02."')";
				$result = mysql_query ($sqlpi,$link) or die ("hay un error en la consulta");
				
				
				setcookie("codusuario_jko", $usu_codusuario);
                setcookie("id_jko", $id);
                setcookie("clave", $clave00);
			
			}
			
			// aqui termina el codigo
			
			} 
		else {
			// AQUI SE SUPONE QUE NO IDENTIFICA AL USUARIO POR QUE EL CODIGO VIENE VACIO
			
			
			/* $result1e = mysql_query("SELECT id FROM com_users ORDER BY id DESC LIMIT 1",$link) or die("el error es porque44grt: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $id = 1;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $id = $rowe['id'] + 1;
                }
				
				$clave00 = createhash($tokensArray,$hashLenght);
				$clave02 = createhash($tokensArray,$hashLenght);
				
				$sqlpi = "INSERT INTO com_users (id, ape1, ape2, codusuario, email, nombre, clave, fecha, pass) VALUES ('".$id."','".$usu_ape1."','".$usu_ape2."','".$clave02."', '".$usu_correo."','".$usu_nombre."','".$clave00."','".$fecha."','".$clave02."')";
				$result = mysql_query ($sqlpi,$link) or die ("hay un error en la consulta");
				
				
				setcookie("codusuario_jko", $clave02);
                setcookie("id_jko", $id);
                setcookie("clave", $clave00); */
				
			// AQUI TERMINA LA ACCION QUE SE DEBE ELIMINAR EL CODIGO VIENE VACIO
			
			 header("Location: no_access.php");
			}
		
		}  
		
		else {
			 header("Location: no_access.php");
			}
	


	// este es si hay que revisar el post
	}
// el end de si no es la pagina de login	
}
?>