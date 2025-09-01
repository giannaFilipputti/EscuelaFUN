<?php
include_once("../includes/conn.php");

extract($_GET);


          $sql = "SELECT * FROM com_material WHERE curso = ". $id ." ORDER BY tipo, orden";
          //echo $sql;
          $result = mysql_query($sql,$link);
		  
		  
		   
		  
     while($row = mysql_fetch_array($result)) {
		 



			
			$tiempo = $_POST['text_'.$row['id']];
			
			$tiempo_limpio = acentos_html(strip_tags($tiempo));
					
			 $sql1 = "UPDATE com_material SET descripcion= '". addslashes($tiempo_limpio) ."' WHERE id = ".$row['id']."";
			 
			 //echo $sql1."<br>";

             $result1 = mysql_query ($sql1,$link) or die("el error es en el insert: ".mysql_error());
			 
			 
			  $sqlhh = "SELECT * FROM com_material WHERE id=".$row['id']."";
			  
			  $resulthh = mysql_query($sqlhh,$link);
			  $rowhh = mysql_fetch_array($resulthh);
			  
			   $texto = $rowhh['descripcion'];
			  
			  
			  
			  
			   $sqlhg = "SELECT * FROM com_indexador WHERE id_tabla=".$rowhh['id']." AND tabla = 'com_material'";
			   
			   //echo $sqlhg."<br>";
			  
			  $resulthg = mysql_query($sqlhg,$link);
			  if ($rowhg = mysql_fetch_array($resulthg)) {
				  
				 
				  
				  $sql1j = "UPDATE com_indexador SET texto = '".$texto ."', curso = '".$curso ."' WHERE id = ".$rowhg['id']."";
			 
			// echo $sql1j."<br>";

             $result1j = mysql_query ($sql1j,$link) or die("el error es en el insert: ".mysql_error());
				  
				  } else {
				  
				  $resultgb = mysql_query ("INSERT INTO com_indexador (id_tabla, tabla, texto, nombre, curso) VALUES ('".$rowhh['id']."','com_material','".$texto."','".$sqlhh['nombre']."','".$curso."')",$link) or die("el error es en el insert: ".mysql_error());
				  
				  }
			  
			
			 } 
			 
			 header("Location:material_texto.php?id=".$id);?>
       