
<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';


$pagina = new Pagina();
$pagina->getOne($id);

  $capitulo = new Capitulo();
$capitulo->getAll($pagina->row[0]['capitulo']);


		   if ($pagina->row[0]['pdf'] == 1) {
		   ?>
           <a href="../pdf/<?php echo $capitulo->row[0]['id']."_pagina_".$pagina->row[0]['id'] .".pdf"?>"><img src="body/pdf_icon.png" /></a> <a href="paginas_down_elim.php?id=<?php echo $pagina->row[0]['id']?>">Eliminar</a>
           <?php
		}
		?>
    
    <br /><br />
   
 