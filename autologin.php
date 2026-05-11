<?php
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';

$token = isset($_GET['token']) ? trim($_GET['token']) : '';

if (empty($token)) {
    header("Location: login.php?err=5");
    exit;
}

$db  = Db::getInstance();
$sql = "SELECT * FROM com_registro WHERE clave = :clave AND activado = 1 LIMIT 1";
$bind = [':clave' => $token];
$db->run($sql, $bind);
$user = $db->fetchAll($sql, $bind);

if (empty($user)) {
    header("Location: login.php?err=3");
    exit;
}

$rowff = $user[0];

// Establecer cookies de sesión (igual que logIn() en Authorizacion)
setcookie("admin_jko", $rowff['email'], time() + (365 * 24 * 60 * 60));
setcookie("admin_idm", $rowff['id'],    time() + (365 * 24 * 60 * 60));
setcookie("clave",     $token,          time() + (365 * 24 * 60 * 60));

header("Location: cursos.php");
exit;
