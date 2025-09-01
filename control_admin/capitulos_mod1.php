<?php 
require '../vendor/autoload.php';
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

use Vimeo\Vimeo;

if (empty($sub_menu)) {
	$sub_menu = 0;
}	  

$client = new Vimeo("cc2ca18d6db9af024e8cd3500fc8e73bc440225d", "tJzM3P8mgbso/T6FKR7LCIO2+bztP2XxRcRgClDdBlVJMoUu1OkHXC156GGzrNLpiR/7ZS7tIMnt7aDljxkkuZtSorTd/T/e87+JJkaca1yiBkB0wvxlzad0b0CsfHg9", "0086c348f138863b43f1cf18579f1f2a");
$elvideo = "/videos/$video";
//echo $elvideo;
$response = $client->request($elvideo, array(), 'GET');

$duracion = $response['body']['duration'];
  
$capitulo = new Capitulo();
$capitulo->modificar($id,$caso,$modulo,$titulo,$titulo_eng,$autor,$resena_autor,$revista,$duracion,$tema,$sub_menu,$video);
   
  // $sqlp = "UPDATE com_cursos_mod_cap SET caso = '". $caso ."', titulo = '". $titulo ."', titulo_eng = '". $titulo_eng ."', autor = '". $autor ."', resena_autor = '". $resena_autor ."', revista = '". $revista ."', tema = '". $tema ."', sub_menu = '". $sub_menu ."', video = '". $video ."' WHERE id = ".$id."";
  // $result = mysql_query ($sqlp,$link);



header("Location: capitulos.php?id=".$modulo."&ref=".$curso); 
  ?>