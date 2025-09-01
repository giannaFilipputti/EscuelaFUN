<?php
	require_once '../lib_c/autoloader.class.php';
	require_once '../lib_c/init.class.php';
	
	$authj = new AuthorizacionAdmin();
	$authj->logIn($login, $password);
?>