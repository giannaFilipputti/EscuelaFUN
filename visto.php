<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$cap = New Capitulo();

$id_usuario = $_POST['id_usuario'];
$capitulo = $_POST['capitulo'];

$cap->registrarVisita($id_usuario, $capitulo, $modulo);

?>