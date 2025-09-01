<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

extract($_GET);

$link = new Diapositiva();
$link->getLink($id);

// $sql = "SELECT * FROM com_ponencias_ima_link WHERE imagen=" . $id . " ORDER BY orden";
//echo $sql;
if (!empty($link->row)) {
	foreach ($link->row as $Elem) {

		$url = $_POST['url_' . $Elem['id']];
		$top = $_POST['top_' . $Elem['id']];
		$left = $_POST['left_' . $Elem['id']];
		$ancho = $_POST['ancho_' . $Elem['id']];
		$alto = $_POST['alto_' . $Elem['id']];

		//echo $sql1."<br>";
		$link->modificarLink($Elem['id'], $top, $left, $ancho, $alto, $url);
	}
}

header("Location: ponencias_up_link.php?id=" . $id);
