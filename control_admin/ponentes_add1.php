<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n4.php");




// CONTENIDO PAGINA

$pass = sha1(md5(trim('yantil')));
$nombre_clave = urls_amigables($nombre);

$sql = "SELECT * FROM com_users WHERE email='".$email."'";
            $result = mysql_query($sql);
			if ($row = mysql_fetch_array($result)) {
				header("Location: ponentes_add.php?error=1"); 
				
			} else { 

$result = mysql_query ("INSERT INTO com_users (nombre, nombre_clave, email, login, pass, nivel, tipo, gerente) VALUES ('".$nombre."','".$nombre_clave."','".$email."','".$email."','".$pass."', '2', 'delegado','".$gerente."')",$link) or die("el error es en el insert: ".mysql_error());
header("Location: ponentes.php"); 
 
			}
?>

