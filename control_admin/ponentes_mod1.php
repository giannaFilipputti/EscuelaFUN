<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n4.php");



	  $nombre_clave = addslashes(urls_amigables($nombre));
	  
	 
$sql = "SELECT * FROM com_users WHERE email='".$email."' AND id <> ".$id;
            $result = mysql_query($sql);
			if ($row = mysql_fetch_array($result)) {
				header("Location: ponentes_mod.php?error=1&id=".$id); 
				
			} else { 
			
	  
if (empty($password)) {
	$sqlp = "UPDATE com_users SET nombre = '". $nombre ."', nombre_clave = '". $nombre_clave ."', email = '". $email ."', login = '". $email ."', gerente = '". $gerente ."' WHERE id = ".$id."";
	
} else {
  $pass = sha1(md5(trim($password)));   
  $sqlp = "UPDATE com_users SET nombre = '". $nombre ."', nombre_clave = '". $nombre_clave ."', email = '". $email ."', login = '". $email ."', pass = '". $pass ."', gerente = '". $gerente ."' WHERE id = ".$id."";
  
}
  
  $result = mysql_query ($sqlp,$link) ;

//echo $sqlp;

    header("Location: ponentes.php"); 

			} ?>