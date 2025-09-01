<?php 

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';


$capitulo = new Capitulo();
$capitulo->getOne($id);

$modulo = new Modulo();
$modulo->getOne($capitulo->row[0]['modulo']);

$cursos = new Curso();
$cursos->getOne($modulo->row[0]['curso']);

include('header.php');

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
        <h1>Capitulos del Modulo: <?php echo $modulo->row[0]['titulo'];?> del curso: <?php echo $cursos->row[0]['titulo'];?></h1>
        <div class="box">
        <h2>Modificar Capitulo del Modulo </h2>
        <form method="POST" action="capitulos_mod1.php?id=<?php echo $id?>&modulo=<?php echo $modulo->row[0]['id'];?>&curso=<?php echo $curso; ?>">
        <label><span>Caso: </span>
          <input type="text" name="caso" size="20" value="<?php echo $capitulo->row[0]['caso']?>"></label>
        <label><span>Titulo Español: </span>
          <input type="text" name="titulo" size="20" value="<?php echo $capitulo->row[0]['titulo']?>"></label>
          <label><span>Titulo Ingles: </span>
          <input type="text" name="titulo_eng" size="20" value="<?php echo $capitulo->row[0]['titulo_eng']?>"></label>
        <label><span>Autor: </span>
          <input type="text" name="autor" size="20" value="<?php echo $capitulo->row[0]['autor']?>"></label>
           <label><span>Revista: </span>
          <input type="text" name="revista" size="20" value="<?php echo $capitulo->row[0]['revista']?>"></label>
          
          <label><span>Tema: </span>
          <input type="text" name="tema" size="20" value="<?php echo $capitulo->row[0]['tema']?>"></label>
          
       
          <label><span>Pestaña de descargas en menu: </span>
          <input type="checkbox" name="sub_menu" value="1"<?php if ($capitulo->row[0]['sub_menu'] == 1) { ?> checked="checked"<?php } ?>></label>
          <br class="clearfloat" />
          
          <label><span>Rese&ntilde;a del Autor: </span><textarea name="resena_autor" rows="4" cols="40"><?php echo $capitulo->row[0]['resena_autor']?></textarea></label>
          <label><span>Video: </span>
          <input type="text" name="video" size="20" value="<?php echo $capitulo->row[0]['video']?>"></label>
      
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
