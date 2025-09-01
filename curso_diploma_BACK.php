<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

include('lib/class/phpqrcode/qrlib.php');

require_once 'dompdf/autoload.inc.php';
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

use Dompdf\Dompdf;

use Dompdf\Options;



$page = "registro";
$scripts = "none";

//echo $authj->rowff['labor'].", ".$authj->rowff['disciplina']."<br>";



$prox = new Modulo();
$modulos = $prox->getOne($modulo);



$curs = new Curso();
$curso = $curs->getOne($modulos[0]['curso']);
$asiste = $curs->checkInscritoCurso($curso[0]['id'], $authj->rowff['id']);


//$asiste = Curso::verificarAsistencia($modulo, $authj->rowff['id']);
//echo "asiste ".$asiste;

if (!empty($asiste)) {
    $exam = new Examen();
    $exam->modulo = $modulo;
    $exam->capitulo = $capitulo;
    $exam->pagina = $pagina;
    $exam->alumno = $authj->rowff['id'];

    /* $cap = new Capitulo();
    $cap->getOne($exam->capitulo);*/

    // revisamos si vencio el plazo

    $plazo_vencido = 0;
    //verificamos en que estado está el examen
    $estado_exam = $exam->getEstado();
    //echo  $estado_exam." - ".$exam->id;
    if ($estado_exam == 5) {
        //$exam->iniciarExamen();
        echo "5";
        //header("Location: certificacion1.php?id=" . $modulo);
        die();
    } else if ($estado_exam == 1) {
        //$exam->getPreg();
        echo "1";
        //header("Location: certificacion1.php?id=" . $modulo);
        die();
    } else if ($estado_exam == 2) {
        // mostrar pantalla de reiniciar examen
        //$exam->reiniciarExam();
        echo "2";
       // header("Location: certificacion1.php?id=" . $modulo);
        die();
    } else if (($estado_exam == 3 or $estado_exam == 4) and $exam->aprobado == 1) {

        // $exam->descargarDiploma($authj->rowff['id'], $modulo);

        $alumno = new Alumno();
        $datos = $alumno->getOne($authj->rowff['id']);
        $codigo = $exam->getQRcode();
        $url_qr = $exam->generateQR($codigo);
        $fecha = strtotime($exam->fecfin); 
       // echo $fecha;    
       
       $nombres = mb_strtoupper($datos['nombre'] . " " . $datos['ape1'] . " " . $datos['ape2'], 'UTF-8');


       $html = "<html><head><title>CICLO CAPACITACIONES FECHIDA 2020</title><style>@font-face {
        font-family: 'Gotham-Bold';
        src: url('fonts/GothamBold.eot');
        src: local('☺'), url('fonts/GothamBold.woff') format('woff'), url('fonts/GothamBold.ttf') format('truetype'), url('fonts/GothamBold.svg') format('svg');
        font-weight: normal;
        font-style: normal; }
    
    @font-face {
    
        font-family: 'Conv_GothamRnd-Book';
    
        src: url('http://test.diabeweb.com/fice/fonts/GothamRnd-Book.ttf') format('truetype');
    
        font-weight: normal;
    
        font-style: normal;
    
    }</style></head><body><div style=\"text-align:left\">
    
                    <img src=\"img/diplomas/diploma.jpg?v=1\" style=\"position:absolute;width:700px; margin-bottom:5px;\" border=\"0\" ><br>
    
                    <table border=\"0\" cellpadding=\"2\" cellspacing=\"['acred_id']0\" width=\"500\" align=\"center\" style=\"position:absolute;top:355px\">
    
                        <tr>
    
                    
    
                        <td width=\"500\" align=\"center\"><span style=\"font-family:'Gotham-Bold;font-size:22px;color:#d10511;padding-left: 180px; font-weight:bold;\">" . $nombres . "</span>
                                               
                                        </td>
    
                        </tr>
    
                        </table>
                        <table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"500\" align=\"center\" style=\"position:absolute;top:460px\">
    
                        <tr>
    
                    
    
                        <td width=\"500\" align=\"center\" style=\"padding-left:110px\"><span style=\"font-family:'Gotham-Bold'; font-weight:bold;font-size:23px;color:#000000;\">" . $curso[0]['titulo'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                               
                                        </td>
    
                        </tr>
    
                        </table>
                        <table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"500\" align=\"center\" style=\"position:absolute;top:480px\">
    
                        <tr>

    
                    
    
                        <td width=\"500\" align=\"center\"><span style=\"font-family:'Gotham-Bold;font-size:15px;color:#666666;padding-left:00px\">" . $modulos['titulo1'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                               
                                        </td>
    
                        </tr>
    
                        </table>
    
                        <table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"150\" align=\"center\" style=\"position:absolute;top:510px\">
    
                        <tr>
    
                    
    
                        <td width=\"650\" align=\"left\"><span style=\"font-family:'Conv_GothamRnd-Book;font-size:13px;color:#666666;padding-left:445px\">Santiago, " . date('d', $fecha) . " de " . mostrarMes(date('m', $fecha)) . " de " . date('Y', $fecha) . "</span></td>
    
                        </tr>
                        <tr>
    
                    
    
                        <td width=\"650\" align=\"left\" style=\"padding-top:228px; padding-left: 560px\"><img src=\"".$url_qr."\"></td>
    
                        </tr>
                    
    
                        </table></div>";
    $html .= "</div></td></tr></table></div>";
    $html .= "</body></html>";
    $html .= '</div>';
    $html .= '</body></html>';





        //echo $html;



        //header("Location: http://www.tbaserver.com/FICE/test_diploma.php?nombre=".urlencode ($row_alu['nombre']." ".$row_alu['ape1']." ".$row_alu['ape2'])."&fecha=".urlencode ($fecha)."&modulo=".$row_mod['id']);





        $options = new Options();

		$options->set('defaultFont', 'Gotham-Bold');

        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', '');
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("diploma_1.pdf");
    } else {

        echo "555";
        //header("Location: certificacion1.php?id=" . $modulo);
        die();
    }
} else {
    echo "666";
    //header("Location: certificacion1.php?id=" . $modulo);
    die();
}
