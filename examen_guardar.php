<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$exam = new Examen();
$pagina = $pag;



$exam->origen = "examen";


$exam->modulo = $modulo;
$exam->curso = $curso;
$exam->capitulo = $capitulo;
$exam->pagina = $pagina;
$exam->pag = $pagina;
$exam->alumno = $authj->rowff['id'];
$exam->actionBoton = $actionBoton;


if ($exam->actionBoton == "atras") {
  $exam->pagNext = $pag;
  if ($exam->pagNext <= 1) {
    $exam->pagNext = 0;
  }
} else {
  $exam->pagNext = $pag +1;
}


// revisamos si vencio el plazo

//echo $exam->checkPlazo();
if ($exam->checkPlazo() == 1) {
  $plazo_vencido = 1;
} else {
  $plazo_vencido = 0;
  //verificamos en que estado está el examen
  $estado_exam = $exam->getEstado();

  

  //echo  $estado_exam." - ".$exam->id;
  $result = 0;
  if ($id == $exam->id) {
    if ($estado_exam == 1) {
      $exam->getPreg();

      if ($exam->total_pages < $exam->pagNext) {
        //echo "entra aqui";
        $exam->pagNext = $exam->total_pages;
      }

      // aqui vamos revisando las respuestas

      $lasresp = array();
      foreach ($exam->preg as $Elem) {
        $laresp = "p" . $Elem['id'];

        $exam->guardarResp($Elem['id'], ${$laresp});
      }

      $exam->actualizarExam();

      

      if ($exam->estadoExamen == 1) {
        //acaba de terminar el examen
        $result = 2;
        // echo "Examen Finalizado";
        //header("Location: resultados.php?id=".$modulo);
        header("Location: inicio_examen.php?id=".$modulo);

      } else {
        // aun no termina el examen
        // echo "Examen No Finalizado";
        header("Location: examen1.php?curso=".$curso."&modulo=".$modulo."&pag=".$exam->pagNext);

      }
      $result = 1;

      //terminamos de revisar las respuestas
    } else if ($estado_exam == 2) {
      // mostrar pantalla de reiniciar examen
    } else if ($estado_exam == 3) {
      // mostrar encuesta
    } else if ($estado_exam == 4) {
      // mostrar resultados
    }
  }
}


//header("Location: examen.php?modulo=".$modulo."&capitulo=".$capitulo."&pagina=".$pagina."&result=".$result);

//echo $logs_vars;
//<a href="resultados.php" class="examen-btn">Ver Resultados</a>
?>