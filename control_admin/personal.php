<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

include("header.php");
?>
<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Opciones Personales </h1>
      <?php

$login = $authj->login;

$db = Db::getInstance();
$sql = "SELECT * FROM com_users WHERE login = :login ";
$bind = array(':login'=>$login);
$row = $db->fetchAll($sql,$bind);
?>
<div class="box">
<form action="personal1.php?ref=<?php echo $ref?>" method="post" name="form1" onSubmit="return validar();">
<span class="subtitulos">Modificar Password de Acceso al sistema</span><br><br />
	                 
                         <label>Ingrese el nuevo password de acceso al sistema:  <br>
                              
                              <input type="password" name="password"><br>
                         </label>
						 <label>Reconfirme Password:  <br>
                              
                              <input type="password" name="password1"><br>
                         </label>
						 
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Agregar" />
                         </label>
                   
</form></div>
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
