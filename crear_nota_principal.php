
<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$db = Db::getInstance();


$usuario = $authj->rowff['id'];
$fecha = date('Y-m-d H:i:s', strtotime('-3 hours'));

$query = "INSERT INTO com_notas (curso,modulo,capitulo,tiempo,usuario,comentario,fecha,principal)
               VALUES ($f_curso,$f_modulo,$f_capitulo,$f_tiempo,$usuario,'$txt_nota_principal','$fecha',1)";

$db->run($query);

?>