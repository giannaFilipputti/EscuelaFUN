<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <? include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <? include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Estadísticas</h1>
        <h2>Encuesta</h2>
       <div class="box result">
           
              <?
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
	$orden = 'com_alumnos.ape1';
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
			
            
  
           $sql_men3 = "SELECT com_alumnos.id, com_alumnos.nombre, com_alumnos.ape1, com_alumnos.ape2, com_alumnos.email FROM com_alumnos INNER JOIN com_encuesta_control ON com_alumnos.id =  com_encuesta_control.user  WHERE com_alumnos.id >= 0";
		   if (!empty($email)) {
			   $sql_men3 .= " AND com_alumnos.email = '".$email."'";
			   }
		   
		   
		   
		   
		   $sql_men31 = $sql_men3." ORDER BY ".$orden." LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
		   
		  // echo $sql_men31;
		   
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
			
			echo "<div class=\"paginas\">Usuarios ".($RegistrosAEmpezar+1)."-".$cantproductos." de ".$NroRegistros."</div>";
			echo "<div class=\"paginas\">Pagina ".$PagAct." de ".$PagUlt."</div>";
			
			
			 echo "<div style='padding:10px;'>";
 echo "<div style='position:relative; width:140px; float:left; padding:0px; text-align:right;'>";
 if($PagAct>1) {
 
 echo "<a href='encuesta_users.php?pag=1&".$listvar."'>Primera</a>&nbsp;&nbsp;&nbsp;<a href='encuesta_users.php?pag=".$PagAnt."&".$listvar."'>Anterior</a>";
 }
 echo "</div>";
 //echo "<strong>Pagina ".$PagAct."/".$PagUlt."</strong>";
 echo "<div style='position:relative; width:180px; float:right; padding:0px; text-align:left;'>";
 
 if($PagAct<$PagUlt) {
 
 echo "<a href='encuesta_users.php?pag=".$PagSig."&".$listvar."'>Siguiente</a>&nbsp;&nbsp;&nbsp;<a href='encuesta_users.php?pag=".$PagUlt."&".$listvar."'>Ultima</a>";
 }
 //echo "<a onclick=Pagina('$PagUlt')>Ultimo</a>";
 echo "</div><br class='clearfloat' /></div>";
 
			
			
		   
    ?>
    <h2>Usuarios ingresados</h2>
    <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
        <td align="center" width="30%">Usuario</td>
        <td align="center" width="30%">Email</td>
        <td align="center" width="20%">Respuestas</td>
        </tr>
        <?  while ($row_men3 = mysql_fetch_array($result_men3)) { 
		  
		  
                ?>
                <tr>
        <td align="left"><?=$row_men3['ape1']." ".$row_men3['ape2'].", ".$row_men3['nombre'];?></td>
       
        <td align="left"><?=$row_men3['email'];?>
        </td>
        <td align="center"><a href="encuesta_ficha.php?id=<?=$row_men3['id'];?>">Ver Respuestas</a></td>
         
      </tr>
                  <? } ?>
        </table>
    <br /><br />
        
     
        
   
        <div class="errores">
        
        </div>
        
       </div>
          
          <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
