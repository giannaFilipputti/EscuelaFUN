<?php include("../includes/conn.php");
include ("auto.php");

include("../includes/extraer_variables.php");

$video_id= 193348080;
$url = "http://vimeo.com/api/v2/video/".$video_id.".php";
$response = unserialize(file_get_contents($url));
$video_title = $response[0]['title'];
$lightbox_thumb = $response[0]['thumbnail_large'];

echo $lightbox_thumb;

// Try to print the $response to see all parameters.
print_r($response);
  
 
?>
