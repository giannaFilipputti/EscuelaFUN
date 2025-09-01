<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$acred = new Acreditaciones();
$acred->getOne($id);

$mod = new Modulo();
$mod->getOne($acred->row[0]['modulo']);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);


// $sql = "SELECT * FROM com_acreditaciones WHERE id=".$id."";
// $result = mysql_query($sql);
// $row = mysql_fetch_array($result);

// $sql1 = "SELECT * FROM com_cursos_mod WHERE id=".$row['modulo']."";
// $result1 = mysql_query($sql1);
// $row1 = mysql_fetch_array($result1);

// $sql0 = "SELECT * FROM com_cursos WHERE id=".$row1['curso']."";
// $result0 = mysql_query($sql0);
// $row0 = mysql_fetch_array($result0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<script>
  $(function() {
    $(".datepicker1").datepicker({
	     dateFormat:"yy/mm/dd",
		 showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date"
		});
  });
  </script>
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
        <h1>Acreditaciones del Modulo: <?php echo $mod->row[0]['titulo'];?> del curso: <?php echo $curso->row[0]['titulo'];?></h1>
        <div class="box">
        <h2>Agregar período de acreditacion al Modulo </h2>
        <form method="POST" action="modulos_acred_mod1.php?id=<?php echo $id?>&modulo=<?php echo $mod->row[0]['id'];?>&ref=<?php echo $curso->row[0]['id']?>">
        <label><span>Creditos: </span>
          <input type="text" name="creditos" size="10" value="<?php echo $acred->row[0]['creditos']?>"></label>
          <label><span>No. Acreditacion: </span>
          <input type="text" name="no_acred" size="20" value="<?php echo $acred->row[0]['no_acred']?>"></label>
          <label><span>Periodo: </span>
          <input type="text" name="periodo" size="20" value="<?php echo $acred->row[0]['periodo']?>"></label>
         <label><span>Horas: </span>
          <input type="text" name="horas" size="10" class="numerico" value="<?php echo $acred->row[0]['horas']?>"></label>
          
          <label><span>Acreditado desde: </span>
          <input type="text" name="acred_desde" class="datepicker1" size="20" readonly="readonly" value="<?php echo $acred->row[0]['acred_desde']?>"></label>
          
          <label><span>Acreditado hasta: </span>
          <input type="text" name="acred_hasta" class="datepicker1" size="20" readonly="readonly" value="<?php echo $acred->row[0]['acred_hasta']?>"></label>
          
          <label><span>Acreditado?: </span>
          <input type="checkbox" name="acreditado" value="1"></label>
          
     
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
        </div>
       
       
    
 
 
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
