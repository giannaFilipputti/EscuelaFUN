<?php
class Funcion
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "forma_pago";
	
    }
	

		
	static function inscribirMailingList ($listaid, $email, $id, $ape1, $ape2, $nombre, $genero, $dni, $porcentaje) {
		/*require '../../vendor/autoload.php';

		use Sendpulse\RestApi\ApiClient;
		use Sendpulse\RestApi\Storage\FileStorage;*/


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
			 $bookID = $listaid;
			 $emails = array(
				array(
					'email' => $email,
					'variables' => array(
						'phone' => '',
						'ID' => $id,
						'Nombre' => $nombre,
						'Ape1' => $ape1,
						'Ape2' => $ape2,
						'Genero' => $genero,
						'DNI' => $dni,
                        'porcentaje' => $porcentaje,
					)
				)
			);
			 $additionalParams = array(
			   'joinurl' => $joinurl,
			);
			 // With confirmation
             $SPApiClient->addEmails($bookID, $emails);


			/* se termina de guardar en el mailing list*/
	}

	static function convertiraMin($tiempo) {

		$minutos1=$tiempo/60;
		$Seg=$tiempo%60;
		$minutos=floor($minutos1);
		//echo "minutos: ".$minutos;

		if ($minutos > 60) {
			$horas1=$minutos/60;
			$minutos=$tiempo%60;
			$horas=floor($horas1);
		} else {
			$horas="00";
		}


		$tiempoSG = str_pad($horas, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT).":".str_pad($Seg, 2, "0", STR_PAD_LEFT);



			
			return $tiempoSG;
		   // return $segundos." ".$Ms
	}

	static function conversorSegundosHoras($tiempo_en_segundos) {
	
		$tiempo_en_segundos = round($tiempo_en_segundos);
		$horas = floor($tiempo_en_segundos / 3600);
		$minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
		$segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
	
		return str_pad($horas, 2, "0", STR_PAD_LEFT). ':' . str_pad($minutos, 2, "0", STR_PAD_LEFT) . ":" . str_pad($segundos, 2, "0", STR_PAD_LEFT);
	}
	
	
	
	
		
}