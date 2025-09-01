<?php include("../includes/conn.php");
include("../includes/extraer_variables.php");
include ("auto.php");



            $sql_eve = "SELECT * FROM com_eventos WHERE id=".$evento."";
            $result_eve = mysql_query($sql_eve);
			$row_eve = mysql_fetch_array($result_eve);
			
			$porciones = explode("*", $row_eve['delegados']);
			$losdelegados = '';
			$haydel = 0;
			foreach ($porciones as $s) {
				if (!empty($s) and $haydel == 0) {
				$sql_u = "SELECT * FROM com_users WHERE id =".$s;
                $result_u = mysql_query($sql_u);
		        $row_u = mysql_fetch_array($result_u);
				$id_delegado = $row_u['id'];
			    $nombre_delegado = $row_u['nombre'];
				$haydel = 1;
				}
				
			}


 /* if (!empty($delegado)) {
   $sql_del = "SELECT * FROM com_users WHERE id = ".$delegado."";
			  
		  

          $result_del = mysql_query($sql_del);
		  if ($row_del = mysql_fetch_array($result_del)) {
			  $id_delegado = $row_del['id'];
			  $nombre_delegado = $row_del['nombre'];
			  }
			  
			else {
				$id_delegado = 0;
				$nombre_delegado = "";
			}
 }*/

if ($id_registro == 'no') {
	   $sqlpf = "INSERT INTO com_alumnos_eventos (alumno, evento, delegado, delegado_campo, fecreg) VALUES ('".$alumno."','".$evento."','".$id_delegado."','".urls_amigables($nombre_delegado)."', '".$fechoy."')";
	  // echo $sqlpf;
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta1");
				
				
	
	} else {
		
		 $sql_evea = "SELECT * FROM com_alumnos_eventos WHERE id = ".$id_registro."";
		 
          $result_evea = mysql_query($sql_evea);
		  if ($row_evea = mysql_fetch_array($result_evea)) {
			  
			  $sqlpfa = "INSERT INTO com_alum_ev_cambios (alumno, evento, delegado, delegado_campo, fecreg, feccambio, user) VALUES ('".$row_evea['alumno']."','".$row_evea['evento']."','".$row_evea['delegado']."','".$row_evea['delegado_campo']."', '".$row_evea['fecreg']."', '".$fechoy."', '".$rowff['id']."')";
	  // echo  $sqlpfa;
				$resultevea = mysql_query ($sqlpfa,$link) or die ("hay un error en la consulta1");
			  
		  }
		
		
		$sqlpf = "UPDATE com_alumnos_eventos SET evento = '".$evento."', delegado = '".$id_delegado."', delegado_campo = '".urls_amigables($nombre_delegado)."'  WHERE id = ".$id_registro;
			//	echo $sqlpf ;
				$result = mysql_query ($sqlpf,$link) or die ("hay un error en la consulta1");
	
	
	}

header("Location: usuarios.php"); 
 
?>

