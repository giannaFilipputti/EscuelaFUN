<? include("../includes/conn.php");
include("auto.php");

include("../includes/extraer_variables.php");

          $RegistrosAMostrar= 1;


foreach ($_GET as $key => $value) 
{ 
  if ($key != 'pag') {
	  $listvar .=  $key."=".$value."&";
  }
  if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
  $listvaro .=  $key."=".$value."&";
  }
  
}
if (empty($_GET['orden'])) {
	$orden = 'ape1';
	} else {
		if (empty($_GET['tiporden'])) {
	            $orden = $_GET['orden'];
	       } else {
	            $orden = $_GET['orden']." DESC";
	       }
	
	}
	
 //estos valores los recibo por GET
            if(isset($pag)){
               $RegistrosAEmpezar=($pag-1)*$RegistrosAMostrar;
               $PagAct=$pag;
              //echo "aqui vemos";
              //caso contrario los iniciamos
            }else{
               $RegistrosAEmpezar=0;
               $PagAct=1;
            } 
			
            
  
           $sql_men3 = "SELECT * FROM com_alumnos WHERE id >= 0";
		   if (!empty($email)) {
			   $sql_men3 .= " AND email = '".$email."'";
			   }
		   
		   
		   
		   
		   $sql_men31 = $sql_men3." ORDER BY ".$orden." LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
		   
           $result_men3 = mysql_query($sql_men31,$link);
		   $NroRegistros=mysql_num_rows(mysql_query($sql_men3));
           $NroRegistrosc=mysql_num_rows(mysql_query($sql_men31));
 
		   
		   $cantproductos = $RegistrosAEmpezar + $RegistrosAMostrar ;
            if ($cantproductos > $NroRegistros) {
	          $cantproductos = $NroRegistros;
	         }
			 
			 $PagAnt=$PagAct-1;
			$PagSig=$PagAct+1;
			$PagUlt=$NroRegistros/$RegistrosAMostrar;

			//verificamos residuo para ver si llevará decimales
			$Res=$NroRegistros%$RegistrosAMostrar;
 
			if($Res>0)  $PagUlt=floor($PagUlt)+1;
			
			echo "<div class=\"paginas\">Alumnos ".($RegistrosAEmpezar+1)."-".$cantproductos." de ".$NroRegistros."</div>";
			echo "<div class=\"paginas\">Pagina ".$PagAct." de ".$PagUlt."</div>";
			
			
			 echo "<div style='padding:10px;'>";
 echo "<div style='position:relative; width:140px; float:left; padding:0px; text-align:right;'>";
 if($PagAct>1) {
 
 echo "<a href='trampa_usuarios.php?pag=1&".$listvar."'>Primera</a>&nbsp;&nbsp;&nbsp;<a href='trampa_usuarios.php?pag=".$PagAnt."&".$listvar."'>Anterior</a>";
 }
 echo "</div>";
 //echo "<strong>Pagina ".$PagAct."/".$PagUlt."</strong>";
 echo "<div style='position:relative; width:180px; float:right; padding:0px; text-align:left;'>";
 
 if($PagAct<$PagUlt) {
 
 echo "<a href='trampa_usuarios.php?pag=".$PagSig."&".$listvar."'>Siguiente</a>&nbsp;&nbsp;&nbsp;<a href='trampa_usuarios.php?pag=".$PagUlt."&".$listvar."'>Ultima</a>";
 }
 //echo "<a onclick=Pagina('$PagUlt')>Ultimo</a>";
 echo "</div><br class='clearfloat' /></div>";
 
			
			
		   
    ?>
    
    <h2>Usuarios ingresados</h2>
    <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
        <td align="center" width="30%">Usuario</td>
        <td align="center" width="20%">Codigo</td>
        <td align="center" width="30%">Email</td>
        <td align="center" width="20%">Acciones</td>
        </tr>
        <?  while ($row_men3 = mysql_fetch_array($result_men3)) { 
		$estado = "";
		        $result1e = mysql_query("SELECT id FROM com_alumnos_servicios WHERE alumno = ".$row_men3['id']." AND servicio = 41",$link) or die("el error es porque44grt: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
			      // aqui revisamos si está inscrito en el servicio
						   $urls = 'http://www.esteve.es/EsteveFront/Inscripcion.do';

						  
                            foreach ($fieldss as $i => $value) {
                              unset($array[$i]);
                            }
						   $fieldss = array();

						   $fieldss['usu_codusuario'] = $row_men3['codusuario'];
						   $fieldss['zon'] = 34;
						   $fieldss['con'] = 41;
						   
						  


						   foreach($fieldss as $key=>$value) { $fieldss_string .= $key.'='.$value.'&'; }
						   rtrim($fieldss_string, '&');

						   $chs = curl_init($urls);
						   # Form data string
						   $postStrings = http_build_query($datas);
						   //$postString = "usu_email=gianna@tba.es";
						   //echo $postString;
						   # Setting our options
						   curl_setopt($chs, CURLOPT_POST, count($fieldss));

						   curl_setopt($chs, CURLOPT_POSTFIELDS, $fieldss_string);
						   curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
						   # Get the response
						   $responses = curl_exec($chs);
						   curl_close($chs);
						   
                           echo "<br>".$responses;
						   if ($responses == 'false'){
							     $estado = "NO ESTA ni en TBA ni en ESTEVE";
								 //echo "aqui";
							   } else {
							    
								 
                                    $sqlpi = "INSERT INTO com_alumnos_servicios (alumno, servicio, fecreg, tipo_reg) VALUES ('".$row_men3['id']."','41','".$fechoy."','1')";
				                     $result = mysql_query ($sqlpi,$link) or die ("hay un error en la consulta 79");	
									  $estado = "registrado DESDE ESTEVE";						    
							   }
						// terminamos de revisar si está inscrito en el servicio 
						//echo "esta el usuario pero no está registrado en el servicio";
			   
			   } else {
				   
			   $estado = "Ya estaba registrado en ZOOM";
			   }
		  
                ?>
                <tr>
        <td align="left"><?=$row_men3['ape1']." ".$row_men3['ape2'].", ".$row_men3['nombre'];?></td>
        <td align="left"><?=$row_men3['codusuario'];?>
        </td>
        <td align="left"><?=$row_men3['email'];?>
        </td>
        <td align="center"><?php echo $estado;?></td>
         
      </tr>
                  <? } ?>
        </table>
   