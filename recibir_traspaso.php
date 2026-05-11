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

$user_src    = $data['user'];
$registro_src = $data['registro'];
$examen_src  = isset($data['examen']) ? $data['examen'] : null;
$curso_fun   = (int)$data['curso_fun'];

if (!$user_src || !$registro_src || !$curso_fun) {
    echo json_encode(['ok' => false, 'msg' => 'Datos incompletos']);
    exit;
}

$db = Db::getInstance();

// 1. Verificar o crear usuario por email
$email = trim($user_src['email']);
$sql = "SELECT id FROM com_registro WHERE email = :email LIMIT 1";
$db->run($sql, [':email' => $email]);
$existing = $db->fetchAll($sql, [':email' => $email]);

if (!empty($existing)) {
    $id_fun = (int)$existing[0]['id'];
} else {
    $uid = uniqid();
    $data_user = [
        'nombre'    => $user_src['nombre'],
        'ape1'      => $user_src['ape1'],
        'ape2'      => $user_src['ape2'],
        'email'     => $email,
        'dni'       => isset($user_src['dni']) ? $user_src['dni'] : '',
        'telefono'  => isset($user_src['telefono']) ? $user_src['telefono'] : '',
        'genero'    => isset($user_src['genero']) ? $user_src['genero'] : '',
        'tipouser'  => isset($user_src['tipouser']) ? (int)$user_src['tipouser'] : 0,
        'fecnac'    => isset($user_src['fecnac']) ? $user_src['fecnac'] : null,
        'pass'      => isset($user_src['pass']) ? $user_src['pass'] : '',
        'pais'      => 116,
        'clave'     => $uid,
        'uniqueid'  => $uid,
        'activado'  => 1,
        'fecha'     => date('Y-m-d H:i:s'),
    ];
    $db->insert('com_registro', $data_user);
    $id_fun = (int)$db->lastInsertId();
    if (!$id_fun) {
        echo json_encode(['ok' => false, 'msg' => 'Error al crear usuario en FUN']);
        exit;
    }
}

// 2. Verificar o crear inscripción al curso
$sql2 = "SELECT id FROM com_cursos_registro WHERE usuario = :u AND curso = :c LIMIT 1";
$bind2 = [':u' => $id_fun, ':c' => $curso_fun];
$db->run($sql2, $bind2);
$existing_reg = $db->fetchAll($sql2, $bind2);

if (empty($existing_reg)) {
    $data_reg = [
        'curso'              => $curso_fun,
        'usuario'            => $id_fun,
        'tipouser'           => isset($registro_src['tipouser']) ? (int)$registro_src['tipouser'] : 0,
        'estado'             => isset($registro_src['estado']) ? (int)$registro_src['estado'] : 0,
        'estadopago'         => isset($registro_src['estadopago']) ? (int)$registro_src['estadopago'] : 0,
        'validprerequisitos' => isset($registro_src['validprerequisitos']) ? (int)$registro_src['validprerequisitos'] : 0,
        'floworder'          => isset($registro_src['floworder']) ? $registro_src['floworder'] : '',
        'porcentaje'         => isset($registro_src['porcentaje']) ? (int)$registro_src['porcentaje'] : 0,
        'fecini'             => isset($registro_src['fecini']) ? $registro_src['fecini'] : null,
        'fecfin'             => isset($registro_src['fecfin']) ? $registro_src['fecfin'] : null,
        'joinurl'            => isset($registro_src['joinurl']) ? $registro_src['joinurl'] : '',
        'idpago'             => isset($registro_src['idpago']) ? (int)$registro_src['idpago'] : 0,
        'fecha'              => date('Y-m-d H:i:s'),
    ];
    $db->insert('com_cursos_registro', $data_reg);
}

// 3. Verificar o crear examen
if ($examen_src) {
    // Buscar el módulo con examen_unico=1 del curso en FUN
    $sql3 = "SELECT id FROM com_cursos_mod WHERE curso = :c AND examen_unico = 1 LIMIT 1";
    $db->run($sql3, [':c' => $curso_fun]);
    $modulo_fun = $db->fetchAll($sql3, [':c' => $curso_fun]);

    if (!empty($modulo_fun)) {
        $modulo_id = (int)$modulo_fun[0]['id'];

        $sql4 = "SELECT id FROM com_alumnos_exam WHERE alumno = :a AND modulo = :m LIMIT 1";
        $bind4 = [':a' => $id_fun, ':m' => $modulo_id];
        $db->run($sql4, $bind4);
        $existing_exam = $db->fetchAll($sql4, $bind4);

        if (empty($existing_exam)) {
            $data_exam = [
                'alumno'   => $id_fun,
                'modulo'   => $modulo_id,
                'nota'     => isset($examen_src['nota']) ? $examen_src['nota'] : 0,
                'aprobado' => isset($examen_src['aprobado']) ? (int)$examen_src['aprobado'] : 0,
                'estado'   => isset($examen_src['estado']) ? (int)$examen_src['estado'] : 0,
                'fecini'   => isset($examen_src['fecini']) ? $examen_src['fecini'] : null,
                'fecfin'   => isset($examen_src['fecfin']) ? $examen_src['fecfin'] : null,
                'pag'      => 1,
            ];
            $db->insert('com_alumnos_exam', $data_exam);
        }
    }
}

echo json_encode(['ok' => true]);
