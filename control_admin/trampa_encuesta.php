<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

           $sql_men3 = "SELECT com_alumnos.id FROM com_alumnos INNER JOIN com_encuesta_control ON com_alumnos.id =  com_encuesta_control.user  WHERE com_alumnos.id >= 0";
		  
		   
		   
		  // echo $sql_men31;
		   $result_men3 = mysql_query($sql_men3,$link);
           $conta = 1;
			 while ($row_men3 = mysql_fetch_array($result_men3)) { 
			 
			   $sql_p7 = "SELECT * FROM com_encuesta WHERE pregunta='p7' AND user = ".$row_men3['id'];	
		       $result_p7 = mysql_query($sql_p7,$link);
		       if ($row_p7 = mysql_fetch_array($result_p7)) {
				   echo "Ya contesto la 7 el: ".$row_p7['fecha']."<br>";
				   } else {
			   
			 
			   $sql_p5 = "SELECT * FROM com_encuesta WHERE pregunta='p5' AND user = ".$row_men3['id'];	
		       $result_p5 = mysql_query($sql_p5,$link);
		       $row_p5 = mysql_fetch_array($result_p5);	
			   
			   
			   $sql_p6 = "SELECT * FROM com_encuesta WHERE pregunta='p6' AND user = ".$row_men3['id'];	
		       $result_p6 = mysql_query($sql_p6,$link);
		       $row_p6 = mysql_fetch_array($result_p6);
			   
			   if ($row_p5['respuesta'] == 'si' and $row_p6['respuesta'] == 'si') {
				   $sqlh1 = "INSERT INTO com_encuesta (user, modulo,  pregunta, respuesta, fecha, fal) VALUES ('".$row_men3['id']."','".$row_p6['modulo']."','p7', '50','".$fechoy."', '1')";
				   echo "&#36sql =\"".$sqlh1."\";<br>";
				   $conta = $conta + 1;
				   
				   }
				   else {
					   echo "Las respuestas son: p5: ".$row_p5['respuesta']. " y p6:".$row_p6['respuesta'].". ID: ".$row_p5['id']." - ".$row_p6['id']."<br>";
					   
					   $sqlh1 = "INSERT INTO com_encuesta (user, modulo,  pregunta, respuesta, fecha, fal) VALUES ('".$row_men3['id']."','".$row_p6['modulo']."','p7', '','".$fechoy."', '1')";
					   echo "&#36sql =\"".$sqlh1."\";<br>";
					   
					   }
		  
				   }
                } ?>
      