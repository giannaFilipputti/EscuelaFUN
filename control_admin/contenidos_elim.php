<?php include("../includes/conn.php");
include ("auto.php");


$id = $ifilter->process($_GET['id']);

$result = mysql_query ("DELETE FROM com_contenidos WHERE id = ".$id."",$link);



header("Location: contenidos.php?id=".$ref); ?>