<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->getOne($id);

// $sqlc = "SELECT * FROM com_cursos_mod WHERE id=" . $id . "";
// //echo $sqlc;
// $resultc = mysql_query($sqlc, $link) or die("el error es porque: " . mysql_error());
// $rowc = mysql_fetch_array($resultc);
if ($mod->row[0]['pdf'] == 1) {
?>
  <a href="../pdf/E_<?php echo $rowc['id'] . ".pdf" ?>"><img src="body/pdf_icon.png" /></a> <a href="modulos_examen_elim.php?id=<?php echo $rowc['id'] ?>">Eliminar</a>
<?php
}
?>

<br /><br />