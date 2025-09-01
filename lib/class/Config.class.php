<?php
/**
 * Clase para Configurar el cliente
 * @Filename: Config.class.php
 * @version: 2.0
 * @Author: flow.cl
 * @Email: csepulveda@tuxpan.com
 * @Date: 28-04-2017 11:32
 * @Last Modified by: Carlos Sepulveda
 * @Last Modified time: 28-04-2017 11:32
 */
 



// 
 $COMMERCE_CONFIG = array(
 	"APIKEY" => "61AFD5F4-4B63-4B24-A8FF-9EDD3B481L9D", // Registre aquí su apiKey
 	"SECRETKEY" => "8b7d9ad01473e0d0b928f09ce8cb5b74fc4137f6", // Registre aquí su secretKey
 	"APIURL" => "https://www.flow.cl/api", // Producción EndPoint o Sandbox EndPoint
 	"BASEURL" => "https://fechida.c-pulpro.com" //Registre aquí la URL base en su página donde instalará el cliente
 );
 
 class Config {
 	
	static function get($name) {
		global $COMMERCE_CONFIG;
		//print_r( $COMMERCE_CONFIG);
		if(!isset($COMMERCE_CONFIG[$name])) {
			throw new Exception("The configuration element thas not exist ".$name, 1);
		}
		return $COMMERCE_CONFIG[$name];
	}
 }
