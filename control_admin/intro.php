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
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Panel de control Administrativo </h1>
        <p>Bienenido al panel de control Administrativo <?=$apptitle;?>. Seleccione la opcion que desea realizar en el menu de la izquierda</p>

        <div style="margin: 25px 0; clear:both"><a href="usuarios_down1.php" style="border:1px solid #cccccc; padding: 5px 10px; background: #FF0000; color: #ffffff">Descargar Listado de usuarios</a></div>

        <div style="margin: 25px 0; clear:both"><a href="usuarios_master_down1.php" style="border:1px solid #cccccc; padding: 5px 10px; background: #FF0000; color: #ffffff">Descargar Listado de participantes Masterclass 1</a></div>


		<div style="margin: 25px 0; clear:both"><a href="usuarios_master_encuesta.php" style="border:1px solid #cccccc; padding: 5px 10px; background: #FF0000; color: #ffffff">Descargar Encuestas Masterclass 1</a></div>

        
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
