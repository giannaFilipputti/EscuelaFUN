<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "registro";
$scripts = "none";

//echo $authj->rowff['labor'].", ".$authj->rowff['disciplina']."<br>";
$prox = new Curso();
//$prox->getAllCertificado($id);

//$loscontenidos = $prox->getAllCertificadoC($id);
$modulo = $id;

$inscrito = Curso::getInscritoCurso($curso, $authj->rowff['id']);

//$asiste = Certificacion::verificarAsistencia($modulo, $authj->rowff['id']);


    $exam = new Examen();
    $exam->curso = $curso;
    $exam->modulo = $modulo;
    $exam->capitulo = $capitulo;
    $exam->pagina = $pagina;
    $exam->alumno = $authj->rowff['id'];

   /* $cap = new Capitulo();
    $cap->getOne($exam->capitulo);*/

    // revisamos si vencio el plazo
    if ($exam->checkPlazo() == 1) {
        $plazo_vencido = 1;
        header("Location: certificacion1.php?id=".$modulo);
	    die();

    } else {
        $plazo_vencido = 0;
        //verificamos en que estado está el examen
        $estado_exam = $exam->getEstado();
        //echo  $estado_exam." - ".$exam->id;
        if ($estado_exam == 5) {
           // if ($inscrito[0]['porcentaje'] >= $cursos[0]['visual_min']) { 
            $exam->iniciarExamen();
            header("Location: examen1.php?modulo=".$modulo."&pag=0");
	        die();
           /* } else {
                header("Location: inicio_examen.php?id=".$modulo);
	            die();
            }*/
        } else if ($estado_exam == 1) {
            $exam->getPreg();
            header("Location: examen1.php?id=".$modulo."&pag=".$exam->pagactual);
	        die();
        } else if ($estado_exam == 2) {
            // mostrar pantalla de reiniciar examen
            $exam->reiniciarExam();
            header("Location: examen1.php?modulo=".$modulo."&pag=0");
	        die();

        } else if ($estado_exam == 3) {
            header("Location: inicio_examen.php?id=".$modulo);
	        die();
        } else if ($estado_exam == 4) {
            header("Location: inicio_examen.php?id=".$modulo);
	        die();
        }
    }





?>