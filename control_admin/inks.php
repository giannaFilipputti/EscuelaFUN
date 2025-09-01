<?php 
/*
error_reporting(E_ALL);

	   ini_set('display_errors', '1');*/

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$pass = sha1(md5(trim($password)));

$sql = "SELECT * FROM com_users WHERE login = '".$login."' AND pass = '".$pass."'";
//echo $sql;
// Con la funci�n �mysql_query()� realizamos la consulta que queramos en la base de datos 
// seleccionada previamente. Es decir le entramos la consulta que hab�amos llamado �$sql�

    $result = mysql_query($sql,$link) or die ("hay un error en la consulta".mysql_error());

	$clave00 = createhash($tokensArray,$hashLenght);

if ($row = mysql_fetch_array($result)){
   
   

   setcookie("admin_jko", $row['login']);
   setcookie("admin_idm", $row['id']);
   setcookie("clave", $clave00, 0);
   
   $sql00 = "UPDATE com_users SET clave = '". $clave00 ."' WHERE id = ".$row['id'];
   $result00 = mysql_query ($sql00,$link) or die("el error es en el insert: ".mysql_error());
   header("Location: intro.php");
   

  
} 
else 
{
   header("Location: index.php");
}

?>