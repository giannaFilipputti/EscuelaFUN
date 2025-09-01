<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
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
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Configuraciones</h1>
        <div class="box">
        <h2>Modificar Configuraciones de envios de Emails y SMS</h2>
        
        <form method="POST" action="config1.php">
        <h3>Configuracion SMTP</h3>
        <label><span>Host SMTP: </span>
          <input type="text" name="smtp_host" size="20" value="<?php echo $authj->rowff['smtp_host']?>"></label>
        <label><span>Email Remitente: </span>
          <input type="text" name="smtp_email" size="20" value="<?php echo $authj->rowff['smtp_email']?>"></label>
        
        <label><span> Remitente: </span>
          <input type="text" name="smtp_remitente" size="20" value="<?php echo $authj->rowff['smtp_remitente']?>"></label>
        <label><span>Usuario SMTP: </span>
          <input type="text" name="smtp_user" size="20" value="<?php echo $authj->rowff['smtp_user']?>"></label>
          <label><span>Pass SMTP: </span>
          <input type="text" name="smtp_password" size="20" value="">(Complete este campo solo si ha cambiado el password de la cuenta SMTP)</label>
       
          <h3>Configuracion SMS</h3>
          
          <label><span>Login SMS: </span>
          <input type="text" name="sms_login" size="20" value="<?php echo $authj->rowff['sms_login']?>"></label>
          <label><span> Remitente: </span>
          <input type="text" name="sms_remitente" size="20" value="<?php echo $authj->rowff['sms_remitente']?>"></label>
          <label><span>Pass SMS: </span>
          <input type="text" name="sms_password" size="20" value="">(Complete este campo solo si ha cambiado el password de la cuenta SMS)</label>
         
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
