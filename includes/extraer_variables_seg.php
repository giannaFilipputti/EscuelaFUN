<?php 

if (function_exists('noFiltro')) {
    //echo "Las funciones de IMAP están disponibles.<br />\n";
} else {
	function noFiltro($variable) {
	return $varible;
	
}
}



$var_num = count($_GET);
$var_tags = array_keys($_GET);// obtiene los nombres de las varibles
$var_valores = array_values($_GET);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$var_num;$i++){
${$var_tags[$i]}=$var_valores[$i];
if ($var_tags[$i] == 'password' or $var_tags[$i] == 'pass_act' or $var_tags[$i] == 'pass_new' or $var_tags[$i] == 'pass_new1') {
$logs_vars .= $var_tags[$i]."=xxxxxxx&";
$logs_varsi .= $var_tags[$i]."=".$var_valores[$i]."&";
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
//echo "Aqui vienen las variables:  ".$logs_vars;
?>