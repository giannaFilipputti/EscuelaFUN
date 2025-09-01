<? include("../includes/conn.php");
include("../includes/extraer_variables.php");
include("auto.php");


          $sql_al = "SELECT * FROM com_alumnos WHERE id = ". $alumno ."";
          $result_al = mysql_query($sql_al);
		  $row_al = mysql_fetch_array($result_al);
		  
		  
		  $sql_ev = "SELECT * FROM com_alumnos_eventos WHERE alumno = ". $alumno ."";
          $result_ev = mysql_query($sql_ev);
		  $row_ev = mysql_fetch_array($result_ev);
  
           $sql1 = "SELECT * FROM com_cursos_mod WHERE id=".$modulo."";
		   //echo $sql_men2;
           $result1 = mysql_query($sql1,$link) or die ("Error en los moduls");
           if($row1 = mysql_fetch_array($result1)) { 
		    $preg_aprob = $row1['preg_aprob'];
		   
		 
		 $sql_ex = "SELECT * FROM com_alumnos_exam WHERE modulo=".$row1['id']." AND alumno = ".$alumno."";
		   //echo $sql_men2;
           $result_ex = mysql_query($sql_ex,$link) or die ("Error en los moduls");
           if($row_ex = mysql_fetch_array($result_ex)) { 
		   
		    $respuestas = "modulo:".$row_ex['modulo']."-nota:".$row_ex['nota']."-aprobado:".$row_ex['aprobado']."-estado:".$row_ex['estado']."-fecini:".$row_ex['fecini']."-fecfin:".$row_ex['fecfin']."<br>"; 
		   
		   $sql_men3 = "SELECT * FROM com_exam_preg WHERE modulo=".$row1['id']."";
		   
		   $sql_men31 = $sql_men3." ORDER BY orden";
		   
           $result_men3 = mysql_query($sql_men31,$link);
           $NroRegistrosc=mysql_num_rows(mysql_query($sql_men31));
		   
		   $porcentaje = ($row_ex['nota'] * 100) / $NroRegistrosc;
		   if ($row_ex['nota'] >= $preg_aprob) {
			   $pregfijo = '';
			   $claseapro = 'verde';
			   
			   } else {
			     $pregfijo = 'NO';
				 $claseapro = 'roja';
			
			   }
		   

		    while ($row_men3 = mysql_fetch_array($result_men3)) { 
		   
          
		     // $sql_men4 = "SELECT * FROM com_exam_resp WHERE pregunta=".$row_men3['id']."";
			 
			 $sql_men4  = "SELECT * FROM com_alumnos_resp WHERE pregunta=".$row_men3['id']." AND alumno = ".$alumno."";
			 
			 
           $result_men4 = mysql_query($sql_men4,$link);
           while($row_men4 = mysql_fetch_array($result_men4)) {
			   
			   
               $respuestas .= $row_men3['id']."-".$row_men4['respuesta']."<br>";
			   $sqlkk = "DELETE FROM com_alumnos_resp WHERE id = ".$row_men4['id']."";
			   //echo $sqlkk."<br>";
			   $resultkk = mysql_query ($sqlkk,$link);

           
         
		   } 
		   
		 
		   
		   }
		   $sqlkk1 = "DELETE FROM com_alumnos_exam WHERE id = ".$row_ex['id']."";
		   //echo $sqlkk1."<br>";
			 $resultkk = mysql_query ($sqlkk1,$link);
			 
			   
			   $result = mysql_query ("INSERT INTO com_exam_borrados (usuario, autor, fecha, datos) VALUES ('".$alumno."','".$rowff['id']."','".$fechoy."','".$respuestas ."')",$link) or die("el error es en el insert: ".mysql_error());
			   
			   
		   
		    } 
			
			// ahora agregamos el examen
			$sql_men3 = "SELECT * FROM com_exam_preg WHERE modulo=".$row1['id']."";
		   
		   $sql_men31 = $sql_men3." ORDER BY orden";
		   
		   $NroRegistrosc=mysql_num_rows(mysql_query($sql_men31));
		   
           $result_men3 = mysql_query($sql_men31,$link);
		   
		    while ($row_men3 = mysql_fetch_array($result_men3)) { 
			
			
			$sql_men4 = "SELECT * FROM com_exam_resp WHERE pregunta=".$row_men3['id']." AND correcta =1";
		   
           $result_men4 = mysql_query($sql_men4,$link);
		   
		    $row_men4 = mysql_fetch_array($result_men4);
			
			
			  $sqlrty = "INSERT INTO com_alumnos_resp (pregunta, alumno, respuesta, correcta, origen) VALUES ('".$row_men3['id']."','".$alumno."','".$row_men4['id']."','1','1')";
			 // echo $sqlrty."<br>";
			  $resultx = mysql_query ($sqlrty,$link) or die("el error es en el insert: ".mysql_error());
			
			}
		   
		   $sqlrtg = "INSERT INTO com_alumnos_exam (alumno, modulo, nota, aprobado, estado, fecini, fecfin, pag, evento, origen) VALUES ('".$alumno."','".$modulo."','".$NroRegistrosc."','1','1','".$fechoy."','".$fechoy."','10','".$row_ev['evento']."','1')";
		   //echo $sqlrtg."<br>";
		   $resultx = mysql_query ($sqlrtg ,$link) or die("el error es en el insert: ".mysql_error());
		   
			
			// aui terminamos de agregar el examen
			
			
			
		    } 
			
			
			header("Location: usuarios_examenes.php?id=".$alumno); 
			?>
           
        
      