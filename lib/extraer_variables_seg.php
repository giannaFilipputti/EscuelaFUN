<?php
//include_once('inputfilter.php');
$logs_vars = "";
$logs_varsi = "";

$var_num = count($_GET);
$var_tags = array_keys($_GET);// obtiene los nombres de las varibles
$var_valores = array_values($_GET);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$var_num;$i++){
${$var_tags[$i]}=$var_valores[$i];
if ($var_tags[$i] == 'password' or $var_tags[$i] == 'pass_act' or $var_tags[$i] == 'pass_new' or $var_tags[$i] == 'pass_new1') {
$logs_vars .= $var_tags[$i]."=xxxxxxx&";
$logs_varsi .= $var_tags[$i]."=".$ifilter->process($var_valores[$i])."&";
} else {
$logs_vars .= $var_tags[$i]."=".$var_valores[$i]."&";
$logs_varsi .= $var_tags[$i]."=".$var_valores[$i]."&";
}
}

/***VARIABLES POR POST ***/

$var_num2 = count($_POST);
$var_tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$var_valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$var_num2;$i++){ 
${$var_tags2[$i]}=$var_valores2[$i];
if ($var_tags2[$i] == 'password' or $var_tags2[$i] == 'pass_act' or $var_tags2[$i] == 'pass_new' or $var_tags2[$i] == 'pass_new1') { 
$logs_vars .= $var_tags2[$i]."=xxxxxxx&";
$logs_varsi .= $var_tags2[$i]."=".$var_valores2[$i]."&";
} else {
$logs_vars .= $var_tags2[$i]."=".$var_valores2[$i]."&";
$logs_varsi .= $var_tags2[$i]."=".$var_valores2[$i]."&";
}
}

//echo $logs_vars;

function mostrarMes($mes)
    {
       switch($mes)
        {         
         case 1:
            $mes='Enero';
            break;     
         case 2:
            $mes='Febrero';
            break;     
         case 3:
            $mes='Marzo';
            break;
         case 4:
            $mes='Abril';
            break;
         case 5:
            $mes='Mayo';
            break;
         case 6:
            $mes='Junio';
            break;
         case 7:
            $mes='Julio';
            break;
         case 8:
            $mes='Agosto';
            break;
         case 9:
            $mes='Septiembre';
            break;
         case 10:
            $mes='Octubre';
            break;
         case 11:
            $mes='Noviembre';
            break;
         case 12:
            $mes='Diciembre';
            break;
        }
     
     return $mes;
    } 

function getRealIP()

{



   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )

   {

      $client_ip =

         ( !empty($_SERVER['REMOTE_ADDR']) ) ?

            $_SERVER['REMOTE_ADDR']

            :

            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?

               $_ENV['REMOTE_ADDR']

               :

               "unknown" );



      // los proxys van añadiendo al final de esta cabecera

      // las direcciones ip que van "ocultando". Para localizar la ip real

      // del usuario se comienza a mirar por el principio hasta encontrar

      // una dirección ip que no sea del rango privado. En caso de no

      // encontrarse ninguna se toma como valor el REMOTE_ADDR



      $entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);



      reset($entries);

      while (list(, $entry) = each($entries))

      {

         $entry = trim($entry);

         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )

         {

            // http://www.faqs.org/rfcs/rfc1918.html

            $private_ip = array(

                  '/^0\./',

                  '/^127\.0\.0\.1/',

                  '/^192\.168\..*/',

                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',

                  '/^10\..*/');



            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);



            if ($client_ip != $found_ip)

            {

               $client_ip = $found_ip;

               break;

            }

         }

      }

   }

   else

   {

      $client_ip =

         ( !empty($_SERVER['REMOTE_ADDR']) ) ?

            $_SERVER['REMOTE_ADDR']

            :

            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?

               $_ENV['REMOTE_ADDR']

               :

               "unknown" );

   }



   return $client_ip;



}

function current_url()
{
    $url      = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $validURL = str_replace("&", "&amp", $url);
    return $validURL;
}

function urls_amigables($url) {



// Tranformamos todo a minusculas



$url = mb_strtolower($url, 'UTF-8');



//Rememplazamos caracteres especiales latinos



$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'à', 'è', 'ì', 'ò', 'ù', 'ï', 'ü', 'Ñ');



$repl = array('a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'i', 'u', 'n');



$url = str_replace ($find, $repl, $url);



// Añaadimos los guiones



$find = array(' ', '&', '\r\n', '\n', '+');

$url = str_replace ($find, '-', $url);



// Eliminamos y Reemplazamos demás caracteres especiales



$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');



$repl = array('', '-', '');



$url = preg_replace ($find, $repl, $url);



return $url;



}


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
	
//echo "Aqui vienen las variables:  ".$logs_vars;
$fechoy = date('Y-m-d H:i:s');
?>