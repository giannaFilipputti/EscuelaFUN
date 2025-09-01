
<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->getOne($id);


		   if ($mod->row[0]['imagen'] == 1) {
		   ?>
           <img src="../uploads/modulos/<?php echo "g_modulo_".$mod->row[0]['id'] .".jpg"?>" />
           <?php
		}
		?>
    
    <br /><br />
   
 