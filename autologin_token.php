<?php
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';

header('Content-Type: application/json');

define('TRASPASO_TOKEN', 'FECHIDA_FUN_SECRET_2024');

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data || !isset($data['token']) || $data['token'] !== TRASPASO_TOKEN) {
    echo json_encode(['ok' => false, 'msg' => 'Token inválido']);
    exit;
}

$email = isset($data['email']) ? trim($data['email']) : '';
$pass  = isset($data['pass'])  ? trim($data['pass'])  : null;

if (empty($email)) {
    echo json_encode(['ok' => false, 'msg' => 'Email requerido']);
    exit;
}

$db  = Db::getInstance();
$sql = "SELECT id, pass FROM com_registro WHERE email = :email AND activado = 1 LIMIT 1";
$bind = [':email' => $email];
$db->run($sql, $bind);
$user = $db->fetchAll($sql, $bind);

if (empty($user)) {
    echo json_encode(['ok' => false, 'msg' => 'Usuario no encontrado en FUN']);
    exit;
}

// Si se provee password, verificarlo
if ($pass !== null) {
    $pass_hash = sha1(md5($pass));
    if ($user[0]['pass'] !== $pass_hash) {
        echo json_encode(['ok' => false, 'err' => 'auth', 'msg' => 'Contraseña incorrecta']);
        exit;
    }
}

// Generar token de sesión y guardarlo en clave
$token = uniqid('fun_', true);
$db->update('com_registro', ['clave' => $token], 'id = :id', [':id' => $user[0]['id']]);

echo json_encode(['ok' => true, 'token' => $token]);
