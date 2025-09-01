<?php
class Mailing
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
       $this->tabla = "tabla_marcas";
	
    }
	

		
	public function agregar ($email, $apikey, $secret)
    {
	   $url = 'https://www.tbhealthcare.es/api/mailing/mailing.php';

			# DATOS DEL USUARIO QUE ENVIAMOS
			$data = array(
				'apikey' => $apikey,
				'secret' => $secret,
				'email' => $email
			);
			$payload = json_encode($data);


			# PETICIÓN POST A VUESTRO SISTEMA
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			# RECIBIMOS VUESTRA RESPUESTA CON LA URL A LA QUE REDIRIGIR EL USUARIO
			$result = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			//echo $httpCode."<br>";

			if ($httpCode == 200 && !empty($result)) {
				header('Location: ' . $result);
				
				//echo "Ok: " . $result;
			} else {
				// Error
				echo "error: " . $result;
			}
		
    }
	
	
	
	
	
	
		
}