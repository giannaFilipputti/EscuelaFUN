<?php
 require_once '../lib_c/autoloader.class.php';
 require_once '../lib_c/init.class.php';
//  require_once '../lib_c/authAdmin.php';

 include("header.php");
?>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <? //include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Panel de control Administrativo </h1>
        <div class="box">
        <form method="POST" action="action-login.php">
        <label><span>Login: </span><input type="text" name="login" size="20"></label>
        <label><span>Password: </span><input type="password" name="password" size="20"></label>
        <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
        </div>
        
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
