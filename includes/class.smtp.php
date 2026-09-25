<?php
/*
 * Compatibilidad PHP 8: la clase SMTP ahora la provee PHPMailer 6 (includes/src/SMTP.php),
 * que se carga desde includes/class.phpmailer.php.
 */
require_once __DIR__ . '/class.phpmailer.php';
