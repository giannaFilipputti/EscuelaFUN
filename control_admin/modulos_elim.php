<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->eliminar($id, $ref);

$cap = new Capitulo();
$cap->getAll($id);

if (!empty($cap->row)) {
  foreach ($cap->row as $Elem) {
    $pagina = new Pagina();
    $pagina->getAll($Elem['id']);

    if (!empty($pagina->row)) {
      foreach ($pagina->row as $ElemPag) {
        $diapo = new Diapositiva();
        $diapo->eliminarByPagina($ElemPag['id'], $ref);
      }
    }

    $pagina->eliminarByCapitulo($Elem['id'], $ref, $id);
  }
}
$cap->eliminarByMod($id, $ref, $ref);

$exam = new Examen();
$exam->getByModulo($id);
if (!empty($exam->row)) {
  foreach ($exam->row as $ElemExam) {
    $exam->deletePregunta($ElemExam['id'], $ref);
  }
}



 header("Location: modulos.php?id=".$ref);
