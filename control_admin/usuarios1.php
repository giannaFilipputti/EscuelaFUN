<?php include("../includes/conn.php");
include("auto.php");

include("../includes/extraer_variables.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Usuarios</h1>
        
        <?php           $RegistrosAMostrar= 30;


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
    <div style="text-align:right">
    <form action="usuarios.php" method="get">
      Email: <input type="text" name="email" /><br />
     
      <input type="submit" />
      
    </form>
    </div>
    <h2>Usuarios ingresados</h2>
    <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
        <td align="center" width="30%">Usuario</td>
        <td align="center" width="20%">Codigo</td>
        <td align="center" width="30%">Email</td>
        <td align="center" width="20%">Acciones</td>
        </tr>
        <?php  while ($row_men3 = mysql_fetch_array($result_men3)) { 
		  
		  
                ?>
                <tr>
        <td align="left"><?php echo $row_men3['ape1']." ".$row_men3['ape2'].", ".$row_men3['nombre'];?></td>
        <td align="left"><?php echo $row_men3['codusuario'];?>
        </td>
        <td align="left"><?php echo $row_men3['email'];?>
        </td>
        <td align="center"><a href="usuarios_examenes.php?id=<?php echo $row_men3['id'];?>">Ver Examenes</a><br>
        <a href="usuarios_elim.php?id=<?php echo $row_men3['id'];?>">Eliminar</a>
        </td>
         
      </tr>
                  <?php } ?>
        </table>
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
