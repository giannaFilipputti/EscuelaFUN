<?php  

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
	


$fecha = date('Y-m-d H:i:s');


		$db = Db::getInstance();
				$sql = "SELECT * FROM com_registro WHERE id = :id AND uniqueid = :uniqueid LIMIT 1";
    			$bind = array(
        		':id' => $id,
        		':uniqueid' => $unique
    			);
		        
				$cont = $db->run($sql, $bind);

				if ($cont == 0) {
					header("Location: login.php?err=1");
				} else { 
					$db1 = Db::getInstance();
					$rowff = $db1->fetchAll($sql, $bind);

					if ($rowff[0]['activado'] == 1) {
						header("Location: login.php?err=3");
						die();
				 	} 
				 
				//$clave00 = createhash($tokensArray,$hashLenght);

				 	$db = Db::getInstance();
					$data = array(
        				'activado' => 1
					);
			    	$db->update('com_registro', $data, 'id = :id', array(':id' => $id));
						
				
					header("Location: login.php?reg=OK&evento=".$rowff[0]['evento']);

				}
		   
	
		
		


		

?>