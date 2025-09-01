<?php include("../includes/conn.php");
include_once("../includes/extraer_variables_seg.php");
include ("auto.php");
include("auto_n4.php");



// CONTENIDO PAGINA

$pass = sha1(md5(trim($password)));
$nombre_clave = urls_amigables($nombre);

$sql = "SELECT * FROM com_users WHERE email='".$email."'";
            $result = mysql_query($sql);
			if ($row = mysql_fetch_array($result)) {
				header("Location: organizadores_add.php?error=1"); 
				
			} else { 
			
			
$result = mysql_query ("INSERT INTO com_users (nombre, nombre_clave, email, login, pass, nivel, tipo) VALUES ('".$nombre."','".$nombre_clave."','".$email."','".$email."','".$pass."', '3', 'organizador')",$link) or die("el error es en el insert: ".mysql_error());

header("Location: organizadores.php"); 

			}

 
?>

