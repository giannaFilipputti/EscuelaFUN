<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */

$page = 'personal';
 
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';


			
		
$acceso = Curso::getInfoPago($idpago, $authj->rowff['id']);


	

			require("lib/class/FlowApi.class.php");

			//Para datos opcionales campo "optional" prepara un arreglo JSON
			$optional = array(
				"nombre" => $authj->rowff['nombre']." ".$authj->rowff['ape1'],
				"usuario" => $authj->rowff['id'],
				"idpago" => $idpago,
				"Curso" => "Inscripción Escuela de Especialización en Deportes Acuaticos"
			);
			$optional = json_encode($optional);

			//Prepara el arreglo de datos
			$params = array(
				"commerceOrder" => $acceso[0]['id']."-".uniqid(),
				"subject" => "Curso ".$mod->row[0]['titulo'],
				"currency" => "CLP",
				"amount" => $acceso[0]['monto'],
				"email" => $authj->rowff['email'],
				"paymentMethod" => 9,
				"urlConfirmation" => Config::get("BASEURL") . "/confirm.php?id=".$idpago,
				"urlReturn" => Config::get("BASEURL") ."/confirm1.php?id=".$idpago,
				"optional" => $optional
			);
			//Define el metodo a usar
			//print_r($params);
			$serviceName = "payment/create";

			try {
				// Instancia la clase FlowApi
				$flowApi = new FlowApi;
				// Ejecuta el servicio
				$response = $flowApi->send($serviceName, $params,"POST");
				//Prepara url para redireccionar el browser del pagador
				$redirect = $response["url"] . "?token=" . $response["token"];
				header("location:$redirect");
			} catch (Exception $e) {
				echo $e->getCode() . " - " . $e->getMessage();
			}



			



?>