<? include_once ("../includes/conn.php");
 $result1e = mysql_query("SELECT * FROM com_alumnos WHERE email = '".$_POST['email']."' AND id <> ".$_POST['userid']."") or die("el error es porque: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   echo 'true';
               }
                else {
                  echo 'false';
                }
				
/* if ($_GET['email'] == 'gianna@cantv.net') {
   echo 'true';
}
else {
	 echo 'false';
	} */
?>