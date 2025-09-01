<?php // Fichero con los datos de conexion a la BBDD

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
include("auto_nivel2.php");

$Area = $_REQUEST["id"];
$curso = new Curso();
$curso->getOne($Area);
//realizamos la consulta
// $sql_cur = "SELECT * FROM com_cursos WHERE id=".$Area."";
// $result_cur = mysql_query($sql_cur);
// $row_cur = mysql_fetch_array($result_cur);
$mod = new Modulo();


if ($curso->row[0]['examen'] == 1) {
  $mod->estado = 1;
  $mod->ex_unico = 1;
  $mod->getModByCurso($Area);
  // $SQL = "SELECT * FROM com_cursos_mod WHERE curso=".$Area." AND estado = 1 AND examen_unico = 1 ORDER BY orden";
  //   $rsCons = mysql_query($SQL, $link) or die(mysql_error());

  $cantReg = count($mod->row);

  if ($cantReg > 0) {

    //el bucle para cargar las opciones
    foreach ($mod->row as $Elem) {

      echo "<option value='" . $Elem["id"] . "'>Examen Unico</option>";
    }
  }
} else {
  $mod->getModByCurso($Area);

  // $SQL = "SELECT * FROM com_cursos_mod WHERE curso = $Area";

  // $rsCons = mysql_query($SQL, $link) or die(mysql_error());

  $cantReg = count($mod->row);

  if ($cantReg > 0) {

    //el bucle para cargar las opciones
    foreach ($mod->row as $Elem) {

      echo "<option value='" . $Elem["id"] . "'>" . $Elem["titulo"] . "</option>";
    }
  }
}
