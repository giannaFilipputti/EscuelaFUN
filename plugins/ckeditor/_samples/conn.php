<?php // Fichero con los datos de conexion a la BBDD


function Conectarse()

{

$db_host="mysql5.genepal.com"; // Host al que conectar, habitualmente es el �localhost�

$db_nombre="giannah_tracker"; // Nombre de la Base de Datos que se desea utilizar

$db_user="giannah_jitter"; // Nombre del usuario con permisos para acceder

$db_pass="jt654321er"; // Contrase�a de dicho usuario


// Ahora estamos realizando una conexi�n y la llamamos �$link�

$link=mysql_connect($db_host, $db_user, $db_pass) or die ("Error conectando a la base de datos.");


// Seleccionamos la base de datos que nos interesa

mysql_select_db($db_nombre ,$link) or die ("Error conectando a la base de datos."); 


// Devolvemos $link porque nos har� falta m�s adelante, cuando queramos hacer consultas.

return $link;

}

// As� llamaremos a la funci�n que ten�a los datos para conectarse

$link = Conectarse();
$ptitulo = 'Jitter Tracker';
$pmoneda = 'BsF.';

?>