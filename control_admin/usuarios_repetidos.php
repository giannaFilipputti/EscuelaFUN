<? include("../includes/conn.php");
include("../includes/conn_v1.php");
include("../includes/extraer_variables.php");
include("auto.php");




          $RegistrosAMostrar= 30;


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
			
            
  
           //$sql_men3 = "SELECT * FROM com_alumnos WHERE tipo <> 'Ponente' AND id >= 0";
		   $sql_men3 = "SELECT * FROM com_alumnos WHERE id >= 0";
		   if (!empty($email)) {
			   $sql_men3 .= " AND email = '".$email."'";
			   }
			   
			   if (!empty($nombre)) {
			   $sql_men3 .= " AND nombre LIKE '%".$nombre."%'";
			   }
		   
		      if (!empty($ape1)) {
			   $sql_men3 .= " AND (ape1 LIKE '%".$ape1."%' OR ape2 LIKE '%".$ape1."%')";
			   }
		   
		   
		   
		   $sql_men31 = $sql_men3." ORDER BY ".$orden."";
		   echo $sql_men31."<br>";
		    echo $sql_men3."<br>";
		   
           $result_men3 = mysql_query($sql_men3,$link);
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
 
 echo "<a href='usuarios.php?pag=1&".$listvar."'>Primera</a>&nbsp;&nbsp;&nbsp;<a href='usuarios.php?pag=".$PagAnt."&".$listvar."'>Anterior</a>";
 }
 echo "</div>";
 //echo "<strong>Pagina ".$PagAct."/".$PagUlt."</strong>";
 echo "<div style='position:relative; width:180px; float:right; padding:0px; text-align:left;'>";
 
 if($PagAct<$PagUlt) {
 
 echo "<a href='usuarios.php?pag=".$PagSig."&".$listvar."'>Siguiente</a>&nbsp;&nbsp;&nbsp;<a href='usuarios.php?pag=".$PagUlt."&".$listvar."'>Ultima</a>";
 }
 //echo "<a onclick=Pagina('$PagUlt')>Ultimo</a>";
 echo "</div><br class='clearfloat' /></div>";
 
			
			
		   
    ?>
    <h2>Buscar Usuarios</h2>
  
    <h2>Usuarios registrados repetidos</h2>
    <table border="1">
      <thead>
        <tr>
        <td width="15%">Contador</td>
        <td width="25%">Apellido<a href='usuarios.php?<?php echo $listvaro?>&orden=ape1'><img src="body/orden_up.png" /></a><a href='usuarios.php?<?php echo $listvaro?>&orden=ape1&tiporden=desc'><img src="body/orden_down.png" /></a></td>
        <td width="25%">Nombre<a href='usuarios.php?<?php echo $listvaro?>&orden=nombre'><img src="body/orden_up.png" /></a><a href='usuarios.php?<?php echo $listvaro?>&orden=nombre&tiporden=desc'><img src="body/orden_down.png" /></a></td>
        <td width="10%">Código V1</td>
        <td width="10%">Código v2</td>
        <td width="25%">Email<a href='usuarios.php?<?php echo $listvaro?>&orden=email'><img src="body/orden_up.png" /></a><a href='usuarios.php?<?php echo $listvaro?>&orden=email&tiporden=desc'><img src="body/orden_down.png" /></a></td>
        
        </tr>
      </thead>
        <? 
		$contador = 1;
		 while ($row_men3 = mysql_fetch_array($result_men3)) { 
		       
			     $sql1_li = "SELECT * FROM com_alumnos_v1 WHERE email = '".$row_men3['email']."'";
		        $result1_li = mysql_query($sql1_li,$link);
				if ($row1_li = mysql_fetch_array($result1_li)) { ?>
                <tr><td colspan="6">
                <?php
					
					$sqlp = "UPDATE com_alumnos_eventos_v1 SET alumno = '".$row_men3['id']."' WHERE alumno = ".$row1_li['id'];
                    echo $sqlp."<br>";
                    $resultp = mysql_query ($sqlp,$link);
					
					$sqlp1 = "UPDATE com_alumnos_exam_v1 SET alumno = '".$row_men3['id']."' WHERE alumno = ".$row1_li['id'];
                    echo $sqlp1."<br>";
                    $resultp1 = mysql_query ($sqlp1,$link);
					
					$sqlp2 = "UPDATE com_alumnos_resp_v1 SET alumno = '".$row_men3['id']."' WHERE alumno = ".$row1_li['id'];
                    echo $sqlp2."<br>";
                    $resultp2 = mysql_query ($sqlp2,$link);
					
					if (is_numeric ($row1_li['codusuario'])) {
					
					$sqlp3 = "UPDATE com_alumnos SET codusuario = '".$row1_li['codusuario']."', codusuario_ant = '".$row_men3['codusuario']."' WHERE id = ".$row_men3['id'];
                    echo $sqlp3."<br>";
                    $resultp3 = mysql_query ($sqlp3,$link);
					}
					
					
					$sqlp4 = "DELETE FROM com_alumnos_v1 WHERE id = ".$row1_li['id']."";
					//$sqlp4 = "UPDATE com_alumnos_v1 SET repetido = '1' WHERE id = ".$row1_li['id'];
                    echo $sqlp4."<br>";
                    $resultp4 = mysql_query ($sqlp4,$link);
					
  
                ?>
                </td></tr>
                <?php 
					
			     $evento = "";
		        $sql1 = "SELECT * FROM com_alumnos_eventos WHERE alumno = ".$row_men3['id']."";
		        $result1 = mysql_query($sql1,$link);
				while ($row1 = mysql_fetch_array($result1)) {
			
			      $sql_pon = "SELECT * FROM com_eventos WHERE id = ".$row1['evento'];
                  $result_pon = mysql_query($sql_pon,$link);
		          if ($row_pon = mysql_fetch_array($result_pon)) {
				  $evento .= "<a href=\"usuarios_eventos.php?evento=".$row_pon['id']."&alumno=".$row_men3['id']."\">".$row_pon ['lugar']." ".date_format(date_create($row_pon['fecha']), 'd-m-Y H:i')."</a><br>";
				  }
				}
				if (empty($evento)) {
					$evento .= "<a href=\"usuarios_eventos.php?evento=0&alumno=".$row_men3['id']."\">Asignar Evento</a><br>";
					}
		  
                ?>
                <tr>
                <td><?php echo $contador;?></td>
        <td align="left"><?php echo fMayuscula($row_men3['ape1']." ".$row_men3['ape2']);?></td>
        <td align="left"><?php echo fMayuscula($row_men3['nombre']);?></td>
        <td align="left"><?=$row1_li['codusuario'];?>
        </td>
        <td align="left"><?=$row_men3['codusuario'];?>
        </td>
        <td align="left"><?=$row_men3['email'];?>
        </td>
        
         
      </tr>
      
      
      <tr>
                <td><?php echo $contador;?></td>
        <td align="left"><?php echo fMayuscula($row1_li['ape1']." ".$row_men3['ape2']);?></td>
        <td align="left"><?php echo fMayuscula($row1_li['nombre']);?></td>
        <td align="left">&nbsp;
        </td>
        <td align="left">&nbsp;
        </td>
        <td align="left"><?=$row1_li['email'];?>
        </td>
        
         
      </tr>
                  <? $contador = $contador + 1;
				}
				} ?>
        </table>
   