<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");
include("auto_n3.php");




// CONTENIDO PAGINA
$password = 'ghju5re5';
$pass = sha1(md5(trim($password)));




$pieces = explode(PHP_EOL, $nombres);
foreach($pieces as $element)
{
	
	$datos = explode(";", $element);
	$nombre = $datos[0];
	$nombre_clave = urls_amigables($datos[0]);
	//$email_clave = $nombre_clave."@test.com";
	$email_clave = $datos[1];
//echo $element."<br/>";
   $sql_del = "SELECT * FROM com_users WHERE nombre_clave = '".$nombre_clave."'";
          $result_del = mysql_query($sql_del);
		 if ( $row_del = mysql_fetch_array($result_del)) {
			 $sql = "UPDATE com_users SET email = '". $email_clave ."' WHERE id = ".$row_del['id'];
			 } else {
		  
		  
    $sql = "INSERT INTO com_users (nombre, nombre_clave, email, login, pass, nivel, tipo) VALUES ('".$nombre."','".$nombre_clave."','".$email_clave."','".$email_clave."','".$pass."','2', 'delegado')";
	
			 }
   echo $sql."<br>";
   $result = mysql_query ($sql ,$link) or die("el error es en el insert: ".mysql_error());
   //header("Location: ponentes.php"); 
 }
?>

