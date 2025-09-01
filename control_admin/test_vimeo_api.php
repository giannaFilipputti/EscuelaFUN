<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


require '../vendor/autoload.php';






  use Vimeo\Vimeo;

  $client = new Vimeo("cc2ca18d6db9af024e8cd3500fc8e73bc440225d", "tJzM3P8mgbso/T6FKR7LCIO2+bztP2XxRcRgClDdBlVJMoUu1OkHXC156GGzrNLpiR/7ZS7tIMnt7aDljxkkuZtSorTd/T/e87+JJkaca1yiBkB0wvxlzad0b0CsfHg9", "0086c348f138863b43f1cf18579f1f2a");
$video_id = "451686900";
$response = $client->request("/videos/$video_id");

print_r($response);
/*
  $client = new Vimeo("cc2ca18d6db9af024e8cd3500fc8e73bc440225d", "0086c348f138863b43f1cf18579f1f2a");

  $response = $client->request('/videos/730124314', array(), 'GET');

  $obj = json_decode($response);
  print_r($obj->{'body'}{'stats'});

  echo "<br>Linea 1";
  print_r($response->{'body'}{'stats'});


  echo "<br>Linea 2";

  print_r($response['body']['stats']['plays']);

  //$obj = json_decode($response);

  //print_r($obj->{'stats'});

  echo "<br>Linea 3<br>";
  print_r($response);

// require_once '../lib/authAdmin.php';

//include("../function_api.php");