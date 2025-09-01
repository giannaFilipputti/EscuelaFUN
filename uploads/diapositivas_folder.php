<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);


		    if (mkdir("ponencias/dir_de_prueba", 0777)) {
				echo "Creo el directorio";
			} else {
				echo "NO creo el directorio";
			}

	   
	   

?>