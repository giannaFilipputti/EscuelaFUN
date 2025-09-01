<?php include("../includes/conn.php");
include_once("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n4.php");


	  $nombre_clave = addslashes(urls_amigables(utf8_encode($nombre)));
	  
	  
	  $sql = "SELECT * FROM com_users WHERE email='".$email."' AND id <> ".$id;
            $result = mysql_query($sql);
			if ($row = mysql_fetch_array($result)) {
				header("Location: organizadores_mod.php?error=1&id=".$id); 
				
			} else { 
	  
if (empty($password)) {
	$sqlp = "UPDATE com_users SET nombre = '". $nombre ."', nombre_clave = '". $nombre_clave ."', email = '". $email ."', login = '". $email ."' WHERE id = ".$id."";
	
} else {
  $pass = sha1(md5(trim($password)));   
  $sqlp = "UPDATE com_users SET nombre = '". $nombre ."', nombre_clave = '". $nombre_clave ."', email = '". $email ."', login = '". $email ."', pass = '". $pass ."' WHERE id = ".$id."";
  
}
  $result = mysql_query ($sqlp,$link) ;



header("Location: organizadores.php");

			}?>