<?
$login = $_COOKIE["admin_jko"];
if (empty($_COOKIE["admin_jko"])) {
	 header("Location: index.php");
} else {
	$resultff = mysql_query("SELECT * FROM com_users WHERE id = ". $_COOKIE["admin_idm"] ."",$link) or die("el error es porque: ".mysql_error());

    if ($rowff = mysql_fetch_array($resultff)){
	   if ($rowff['clave'] != $_COOKIE["clave"]) {
		   //header("Location: index.php?err=3");
		}
       } else {
          header("Location: index.php?err=4");
       }
}
?>