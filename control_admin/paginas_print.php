<?php
header('Content-Type: text/html; charset=UTF-8');

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$ponencia = new Diapositiva();
$ponencia->getAll($id);

$pagina = new Pagina();
$pagina->getOne($ponencia->row[0]['ponencia']);

$capitulo = new Capitulo();
$capitulo->getAll($pagina->row[0]['capitulo']);

$modulo = new Modulo();
$modulo->getOne($capitulo->row[0]['modulo']);

$curso = new Curso();
$curso->getOne($modulo->row[0]['curso']);
$html = "";

if (!empty($ponencia->row)) {
  foreach ($ponencia->row as $Elem) {

    $html .= '<div style=""><div style="padding-top:20px;"><p style="text-align:center"><img src="../uploads/ponencias/' . $Elem['ponencia'] . '/' . $Elem['nombre'] . '" width=850px /></p></div>';
    if (!empty($Elem['comentario'])) {
      $html .= '<div style=" width:830px; text-align: justify; margin:0 auto;	border:solid 1px #929498;	padding:10px;	color:#003882;  font-size:13px;font-family:Arial, Helvetica, sans-serif;-moz-border-radius: 5px;	-webkit-border-radius: 5px;">' . $Elem['comentario'] . '</div></div>';
    }
    $html .= '</div><div style="page-break-before: always;"></div>';
  }
}
// require_once("../dompdf_config.inc.php");

// ———– Texto Html almacenado en la variable $html —————–
//$html = '<html><head><title>Generando un PDF</title></head><body><p><img src="http://peachep.files.wordpress.com/2007/10/cabecerablog2.jpg" alt="Cabecera Blog" width="95%" /></p><h2>Html2Fpdf, Creando PDF "al vuelo" con PHP</h2><p>En este tutorial vamos a tratar de explicar como generar PDFs on line o al vuelo desde nuestras páginas escritas con PHP.</p><p>Para ello vamos a utilizar el proyecto html2fpdf. Este proyecto se basa fundamentalmente en la utilización de 3 clases escritas en PHP: <b>FPDF, HTML2FPDF (extensión de la clase FPDF) y PDF (site Version)</b>. Se incluye otro script complementario contenido en el archivo htmltoolkit.php.</p><p>Para descargar los archivos necesarios id a esta dirección sourceforge.net/projects/html2fpdf.</p><p>Una vez descomprimido el archivo zip descargado nos encontraremos con una lista de archivos, de los cuales, algunos de ellos no nos serán necesarios. Por ejemplo, source2doc.php, es una clase que podemos utilizar para volcar en pantalla toda la información relativa a las variables, constantes o métodos que componen una determinada clase que le sería indicada. Pero este archivo no nos resultará necesario para generar PDFs.</p><p>Los archivos y directorio necesarios de todos los descargados para la generación de PDFs son:<ul><li>fpdf.php</li><li>html2fpdf.php</li><li>gif.php</li><li>htmltoolkit.php</li><li>incluir también el directorio o carpeta font</li></ul></p><p><a href="http://peachep.wordpress.com">peachep.wordpress.com</a></p></body></html>';
// ———– Texto Html —————–


/*
$dompdf = new DOMPDF();
//$dompdf->set_paper('letter','landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("diploma".urls_amigables($row_mod['titulo']).".pdf", 1); */

echo $html;
