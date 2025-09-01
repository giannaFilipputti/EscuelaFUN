<?php

/**
 * @author Sascha Br�ning <sascha.broening@gmail.com>
 * @license LGPL-3.0
 * @copyright (c) 2014, Sascha Br�ning
 * @version v 1.0 2014-08-28
 * @todo too much :)
 */
const LB = '<br>';

class Autoloader
{

    /**
     * File Extension String
     *
     * @var string
     */
    private static $extension = '.class.php';

    /**
     * File Path String
     *
     * @var string
     */
    private static $path = '/class';

    /**
     *
     * @method Load Class if exists
     * @param string $classname            
     */
    public static function load($classname)
    {
        $path = (Autoloader::$path) ? __DIR__ . self::$path : __DIR__;
        
        $path = $path . DIRECTORY_SEPARATOR . $classname . self::$extension;
        
        if (! file_exists($path)) {
			echo $path;
            throw new Exception('The initialised Class is not available!', 10);
        } else {
            require_once $path;
        }
    }
}

/**
 * @function Custom Exception Handler
 *
 * @param object $e            
 */
function exception_handler($e)
{
     $elerror = 'Code: ' . $e->getCode();
    $elerror .= 'Error: ' . $e->getMessage();
    $elerror .= 'File: ' . $e->getFile();
    $elerror .= 'Line: ' . $e->getLine();
    $elerror .= 'Trace: ' . $e->getTraceAsString();
    $elerror .= $_SERVER['REQUEST_URI'];
    
    $para      = 'gianna@tba.es';
    $titulo    = 'Error';
    $mensaje   = $elerror;
    $cabeceras = 'From: gianna@tba.es' . "\r\n" .
    'Reply-To: gianna@tba.es' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($para, $titulo, $mensaje, $cabeceras);
    
    echo 'Code: ' . $e->getCode() . LB;
    echo 'Error: ' . $e->getMessage() . LB;
    echo 'File: ' . $e->getFile() . LB;
    echo 'Line: ' . $e->getLine() . LB;
    echo 'Trace: ' . $e->getTraceAsString() . LB;
}

set_exception_handler('exception_handler');