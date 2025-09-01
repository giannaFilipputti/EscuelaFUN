<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

/**
 * Pagina del comercio para redireccion del pagador
 * A esta página Flow redirecciona al pagador pasando vía POST
 * el token de la transacción. En esta página el comercio puede
 * mostrar su propio comprobante de pago
 * 
 * 
 */

require 'vendor/autoload.php';

		use Sendpulse\RestApi\ApiClient;
		use Sendpulse\RestApi\Storage\FileStorage;


		/* se guarda en el mailing list */			
			
			// API credentials from https://login.sendpulse.com/settings/#api
			define('API_USER_ID', '40d6c11408f5b0bf7599d83b3ac6e41c');
			define('API_SECRET', '900e819a43d8076cdb62fc38889e45c1');
			define('PATH_TO_ATTACH_FILE', __FILE__);
			
			$SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
			
			/*
			 * Example: Get Mailing Lists
			 */
			//var_dump($SPApiClient->listAddressBooks());
			
			/*
			 * Example: Add new email to mailing lists
			 */
			 $bookID = '1434852';
			 $emails = array(
				array(
					'email' => 'giannalia@gmail.com',
					'variables' => array(
						'phone' => '',
						'ID' => '7',
						'Nombre' => 'Gianna',
						'Ape1' => 'Filipputti',
						'Ape2' => 'Marro',
						'Genero' => 'F',
						'DNI' => '22505431-2',
                        'porcentaje' => '0',
					)
				)
			);
			 $additionalParams = array(
                        'ID' => '7',
						'Nombre' => 'Gianna',
						'Ape1' => 'Filipputti',
						'Ape2' => 'Marro',
						'Genero' => 'F',
						'DNI' => '22505431-2',
                        'porcentaje' => '0',
			);
			 // With confirmation
             $SPApiClient->addEmails($bookID, $emails);


			/* se termina de guardar en el mailing list*/



   // Funcion::inscribirMailingList ('1434852', 'giannalia@gmail.com', '15', 'filipputti', 'marro', 'gianna', '$datos['genero']', $datos['dni'], '0');

