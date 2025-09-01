<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");
include("auto_n3.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>

<script>
  $(function() {
    $("#datepicker").datepicker({
	  minDate: 0,
	  changeMonth: true,
      changeYear: true,
	  showOn: "button",
      buttonImage: "body/calendar.gif",
      buttonImageOnly: true,
	  dateFormat: 'yy-mm-dd'
    });
  });
  </script>
  
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
        <h1>Reuniones</h1>
        <div class="box">
        <h2>Agregar reunión</h2>
        <form method="POST" action="eventos_add1.php">
        <label><span>Lugar: </span>
          <input type="text" name="lugar" size="20"></label>
        <label><span>Dirección: </span>
          <input type="text" name="direccion" size="20"></label>
        <label><span>Ciudad: </span>
          <input type="text" name="ciudad" size="20"></label>
        <label><span>Fecha: </span>
          <input type="text" name="fecha" size="20" id="datepicker"></label>
           <label><span>A las: </span>
          <select name="hora">
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="00">00</option>
          </select> : <select name="minuto">
          <option value="00">00</option>
          <option value="30">30</option>
          </select>
          </label>
        
        <label><span>Delegado: </span>
          <select name="delegados[]" multiple="multiple">
          <?
          $sql_p = "SELECT * FROM com_users WHERE tipo = 'delegado' ORDER BY nombre";
          $result_p = mysql_query($sql_p);
		  while ($row_p = mysql_fetch_array($result_p)) {
    ?>
            <option value="<?php echo $row_p['id']?>"><?php echo $row_p['nombre']?></option>
            <?php } ?>
          </select></label>
          
        
       
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
