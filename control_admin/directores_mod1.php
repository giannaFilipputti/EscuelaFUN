<?php 
require_once '../lib/autoloader.class.php';
require_once '../lib/init.class.php';
require_once '../lib/authAdmin.php';



	   
  $sqlp = "UPDATE com_directores SET nombre = '". $nombre ."', zona = '". $zona ."' WHERE id = ".$id."";
  

  $result = mysql_query ($sqlp,$link) ;



      header("Location: directores.php"); 

			 ?>