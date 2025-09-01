<?php include("../includes/conn.php");
include ("auto.php");


include("../includes/extraer_variables.php");

		  
       
		  
		 // $password = sha1(md5(trim('yantil')));
   
  $sqlp = "UPDATE com_eventos SET version = '2'";
  echo $sqlp."<br>";
  $resultp = mysql_query ($sqlp,$link);
  
  
  

  


//header("Location: capitulos.php?id=".$modulo); ?>