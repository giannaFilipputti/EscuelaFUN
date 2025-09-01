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

$pagina = new Pagina();
$pagina->getAll($capitulo->row[0]['id']);


	   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $apptitle?></title>
<link href="../css/estilos_print.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
</head>

<body>
<div class="marco">
  <div class="container">
    <div class="head">
       <img src="../body/head_bg_print.jpg"  />
    </div>
   
   
    <div class="interna">
    
      
      <div class="contenido">
        <div class="borde_sup">&nbsp;</div>
        <div class="texto">
        
           <h1><?php echo $modulo->row[0]['titulo'];?> - Capítulo <?php echo $cap;?></h1>
		   <h2><?php echo $capitulo->row[0]['titulo'];?></h2>
           <div class="negrita"><?php echo $capitulo->row[0]['autor'];?></div>
           <div class="italica"><?php echo $capitulo->row[0]['resena_autor'];?></div>
           
           <?php foreach ($pagina->row as $Elem) { ?>
           <div><?php echo $Elem['contenido'];?></div>
           <?php } ?>
           
          
           
        </div>
      </div>
      <br class="clearfloat" />
      
      
      
    </div>

  </div>
</div>

<?php include('cierre.php');?>
</body>
</html>
