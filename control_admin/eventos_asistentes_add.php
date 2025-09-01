<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

$sql = "SELECT * FROM com_eventos WHERE id=".$id;
          $result = mysql_query($sql);
		  $row = mysql_fetch_array($result);
		  
		  $tags = explode('*',$row['delegados']);
		  $idm = '';

          foreach($tags as $key) {
			if (!empty($key)) {
			 if (!empty($idm)) {
				 $idm .= ', ';
				 }    
             $idm .= '"'.$key.'"';  
			}
           }
		  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
<script src="js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/uploadifive.css">
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
        <h1>Invitados a Eventos</h1>
        
        <div class="box">
        <h2>Agregar Usuario DEMO: (agregar usuario demo solo si el usuario no tiene dirección de correo electronico)</h2>
        <form method="POST" action="eventos_asistentes_add1.php">
        <input type="hidden" name="evento" value="<?php echo $id?>" />
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20"></label>
         <label><span>Apellido 1: </span>
          <input type="text" name="ape1" size="20"></label>
          <label><span>Apellido 2: </span>
          <input type="text" name="ape2" size="20"></label>
          <label><span>DNI: </span>
          <input type="text" name="dni" size="20"></label>
           
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
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
