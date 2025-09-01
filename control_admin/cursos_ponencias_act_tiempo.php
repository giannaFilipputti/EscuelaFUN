<?php
include_once("../includes/conn.php");

extract($_GET);


          $sql = "SELECT * FROM com_ponencias_destacados WHERE curso=".$id." AND tipo='".$tipo."'";
          //echo $sql;
          $result = mysql_query($sql,$link);
		   
		  
     while($row = mysql_fetch_array($result)) {
			
			$tit = $_POST['tit_'.$row['id']];
			$stit = $_POST['stit_'.$row['id']];
			$desc = $_POST['desc_'.$row['id']];
			//$tiempo_limpio = acentos_html(strip_tags($tiempo));
					
			 $sql1 = "UPDATE com_ponencias_destacados SET titulo = '". $tit ."',subtitulo = '". $stit ."', descr = '". $desc ."' WHERE id = ".$row['id']."";
			 
			// echo $sql1."<br>";

             $result1 = mysql_query ($sql1,$link) or die("el error es en el insert: ".mysql_error());
			 
			 
			  
			 //echo $sql1."<br>";

             
			  
			  
			  
			  
			  
			
			 } 
			 
			 header("Location: cursos_destacados.php?curso=".$id."&tipo=".$tipo);?>
       