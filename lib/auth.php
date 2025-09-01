<?php

 		$authj = new Authorizacion();
		$authj->auth();
		//echo "page: ".$page;
		if ($page != 'personal') {
			if (is_null($authj->rowff['fecnac']) || empty($authj->rowff['telefono']) || empty($authj->rowff['pais']) || $authj->rowff['cambiopass']==0) {
				header("Location: personal.php");
				die();
			}
		}
		
		/*
		$idiom = $_COOKIE["idiom"];
		if (empty($idiom)) { 
			$idiom = 'esp';
		}
		$trad = New Traduccion();
		$var = $trad->getTraduccion($idiom);*/
		
		
		//print_r($var);