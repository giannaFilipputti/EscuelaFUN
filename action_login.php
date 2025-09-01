<?php /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
	  require_once 'lib/init.class.php';

	  

	  

	    $authj = new Authorizacion();
		$authj1 = $authj->logIn($usu_login, $usu_pass, $acepto);
		$sufijo = "";
		
		if (!empty($evento)) {
			$prox = New Evento();
			$prox->getOne($evento);
			$eventos = $prox->row[0];
			
			if (!empty($eventos['id'])) {
				$sufijo = "&evento=".$eventos['friendly_url'];
				
			} 
			if (!empty($clinica)) {
				$sufijo = "&clinica=".$clinica;
				
			} 
			
		}
		
		//echo $authj1 ;
		if ($authj1 == 'OK') {			
			if (!empty($eventos['id'])) {
				header("Location: ".BASE_PATH."evento.php?id=".$eventos['id']);
			} else if (!empty($clinica)) {
				header("Location: ".BASE_PATH."clinica_inscribir.php?id=".$clinica);
			} else {
				header("Location: ".BASE_PATH."cursos.php");
				//echo "aqui";
			}			
	
		} else if ($authj1 == 'err1') {
			header("Location: ".BASE_PATH."login.php?err=1".$sufijo);
		} else if ($authj1 == 'err2') {
			header("Location: ".BASE_PATH."login.php?err=2".$sufijo);
		}
	

     

?>