
<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$capitulo = new Capitulo();
$capitulo->getOne($id);

     
		   if ($capitulo->row[0]['imagen'] == 1) {
		   ?>
           <img src="../uploads/capitulos/<?php echo "g_capitulo_".$capitulo->row[0]['id'] .".jpg"?>" />
           <?php
		}
		?>
    
    <br /><br />
   
 