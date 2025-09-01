<? include("../includes/conn.php");
//include("auto_nivel2.php");
include("../includes/extraer_variables.php");

		foreach ($_GET as $key => $value) 
       { 
         if ($key != 'pag') {
	       $listvar .=  $key."=".$value."&";
         }
        if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
           $listvaro .=  $key."=".$value."&";
         }
  
        }


          $sql = "SELECT * FROM com_alumnos WHERE ";
		  
		 
			   $sql .= "test = 0 AND ";
		
		  
		 
		  
		  $sql .= "id > 0 ORDER BY ape1";
		  //echo $sql;
          $result = mysql_query($sql,$link) or die("el error es porque: ".mysql_error());
		  
		  $shtml = "Apellido 1,Apellido 2,Nombre,Codigo Esteve,Email,Ultimo Acceso,Registro FOCO\n";
          while ($row = mysql_fetch_array($result)) {
			
			$sql_pre = "SELECT * FROM com_zoomplus_permisos WHERE usuario=".$row['id']."";
		   
           $result_pre = mysql_query($sql_pre,$link);
           if ($row_pre = mysql_fetch_array($result_pre)) {
			   
			    $lafecha = $row_pre['fecin'];
			   } else {
				    $lafecha = '';
			   }
		   
		   
		    
			 $ape1 = utf8_decode($row['ape1']);
			 $ape2 = utf8_decode($row['ape2']);
			 $nombre = utf8_decode($row['nombre']);
			 $email = $row['email'];
			 $codigo = $row['codusuario'];
			 $estado = "";
			
			 $shtml .= str_replace(",", "-", $ape1).",".str_replace(",", "-", $ape2).",".str_replace(",", "-", $nombre).",".str_replace(",", "-", $codigo).",".str_replace(",", "-", $email).",".$row['fecha'].",".$lafecha."\n";
		  
                
				 } 
				 
				 header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=alumnos.csv");
echo $shtml;?>
      