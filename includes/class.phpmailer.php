<?php
/*
 * Compatibilidad PHP 8: la antigua PHPMailer 5.1 que vivía en este archivo usaba
 * each() y set_magic_quotes_runtime(), eliminadas en PHP 8. Ahora este archivo
 * carga PHPMailer 6 (includes/src/) y expone la clase global PHPMailer para que
 * el código que hace require('includes/class.phpmailer.php') siga funcionando.
 */
require_once __DIR__ . '/src/Exception.php';
require_once __DIR__ . '/src/PHPMailer.php';
require_once __DIR__ . '/src/SMTP.php';

if (!class_exists('PHPMailer', false)) {
    class PHPMailer extends \PHPMailer\PHPMailer\PHPMailer
    {
    }
}
