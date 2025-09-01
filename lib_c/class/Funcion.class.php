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


	
	
	
	
		
}