<?php

class Evento
{
	public $id;
	public $categoria_esp;
	public $categoria_eng;
	public $proyecto;
	public $orden;


    public function __construct()
    {
       // echo "<p>Class X</p>";
	    $this->tabla = "com_eventos";
	
    }
	
	private function getOrden($tabla='com_eventos')
    {
		
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$tabla." WHERE orden > :id ORDER BY orden DESC LIMIT 1";
    			$bind = array(
        		':id' => 0
    			);
		        
				$cont = $db->run($sql, $bind);
				//echo "contador:".$cont;
				if ($cont == 0) {
					$orden = 1;
				} else {
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				   foreach($row_p as $row_p1) {
						$orden = $row_p1['orden'] + 1;
					}
				}
		
		return sprintf($orden);
	}
		
	public function agregar ()
    {
	   if (empty($this->categoria_esp)) {
		   header("Location: categorias_add.php");
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'categoria_esp' => $this->categoria_esp,
        	'categoria_eng' => $this->categoria_eng,
			'orden' => $this->orden		
		);
    	$db->insert('com_categorias', $data);
		   
		header("Location: categorias.php");
	   }
		
    }
	
	
	public function registrarEvento ($titulo, $fecha, $disciplinas, $cargos, $id_zoom, $url_zoom, $pais, $interno, $origen, $com_idioma)
    {
	   if (empty($titulo)) {
		   //header("Location: categorias_add.php");
		   return "err1";
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'titulo' => $titulo,
        	'fecha' => $fecha,
			'id_zoom' => $id_zoom,
			'link_zoom' => $url_zoom,
			'idioma' => $com_idioma,
			'interno' => $interno,
			'origen' => $origen
			
		);
		
    	$db->insert('com_eventos', $data);
		
		$id = $db->lastInsertId();
		
		foreach ($disciplinas as $selectedOption) {			
			$db1 = Null;
			$db1 = Db::getInstance();
			$data1 = array(
        	'evento' => $id,
        	'disciplina' => $selectedOption			
			);
			$db1->insert('com_evento_disciplina', $data1);			
		}
		
		foreach ($cargos as $selectedOption) {			
			$db1 = Null;
			$db1 = Db::getInstance();
			$data1 = array(
        	'evento' => $id,
        	'rol' => $selectedOption			
			);
			$db1->insert('com_evento_rol', $data1);			
		}
		
		foreach ($pais as $selectedOption) {			
			$db1 = Null;
			$db1 = Db::getInstance();
			$data1 = array(
        	'evento' => $id,
        	'pais' => $selectedOption			
			);
			$db1->insert('com_evento_pais', $data1);			
		}
		
		$friendly_url = "evento-".$id;
		$db = Null;
		$db = Db::getInstance();
			$data = array(
        	'friendly_url' => $friendly_url
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
   		
		
		
	   }
		
    }
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: categorias.php");
	   }
		else if (empty($this->categoria_esp)) {
		   header("Location: categorias_mod.php?id=".$this->id);
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'categoria_esp' => $this->categoria_esp,
        	'categoria_eng' => $this->categoria_eng	
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_categorias', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: categorias.php");
	   }
		
    }
	
	
	public function getAll ($tipo = '',$interno=0, $origen=0, $tiporden="")
	{
		//echo $tiporden;
				$db = Db::getInstance();
				$sql = "SELECT ".$this->tabla.".* FROM ".$this->tabla; 
				$sql .= " WHERE ".$this->tabla.".id > :id AND interno >= :interno";
				$bind = array(
        		':id' => '0',
				':interno' => $interno
    			);				
				
				$date = new DateTime();
				$date->modify('-10 hours');;
				$lafechoa=  $date->format('Y-m-d H:i:s');
				
				//echo "Tipo".$tipo;
				if ($origen != 0) {
					$sql .= " AND ".$this->tabla.".origen = :origen"; 
					$bind[':origen'] = $origen;
					
				}
				if ($tipo == 'proximos') {
					$sql .= " AND ".$this->tabla.".fecha >= :fecha"; 
					$bind[':fecha'] = $lafechoa;
				} else if ($tipo == 'pasados') {
					$sql .= " AND ".$this->tabla.".fecha < :fecha"; 
					$bind[':fecha'] = $lafechoa;					
				}
				
						
				
				
				if ($tipo == 'pasados') {
					$sql .= " GROUP BY ".$this->tabla.".id ORDER BY fecha DESC";
					
				} else if (!empty($tiporden)) {
					$sql .= " GROUP BY ".$this->tabla.".id ORDER BY fecha DESC";
				} else {
					$sql .= " GROUP BY ".$this->tabla.".id ORDER BY fecha";
				}
								
				/*echo $sql;
				print_r($bind);
echo "<br><br>";		*/	
				
    			
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$this->row = "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   $this->row = $row_p;
				}
	}
	
	
	public function getEventosUsuario ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT ".$this->tabla.".*, com_evento_registro.entrada FROM ".$this->tabla; 
				$sql .= " LEFT JOIN com_evento_registro ON ".$this->tabla.".id = com_evento_registro.evento";
				/*$sql .= " LEFT JOIN com_evento_disciplina ON ".$this->tabla.".id = com_evento_disciplina.evento";*/
				$sql .= " WHERE com_evento_registro.usuario = :id";
				$bind = array(
        		':id' => $id
    			);				
				
				
				
				
				
				
					$sql .= " GROUP BY ".$this->tabla.".id ORDER BY fecha DESC";
					
				
								
				/*echo $sql;
				print_r($bind);
echo "<br><br>";*/				
				
    			
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$this->row = "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   $this->row = $row_p;
				}
	}
	
	
	public function inscribir($evento, $usuario) {
		
		$check = Evento::verificarAsistencia($evento, $usuario);
		
		if ($check == 0) {
			$db = Db::getInstance();
			$data = array(
        	'evento' => $evento,
        	'usuario' => $usuario,
			'fecin' => date('Y-m-d H:i:s')
			
			);
			$db->insert('com_evento_registro', $data);
		}
		
		
		   
		
		
		
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$this->row = $row_p;
				   
				}
	}
	
	
	public function getOnebyURL ($evento,$proximos=0)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE friendly_url = :url";
    			$bind = array(
					':url' => $evento
    			);
				if ($proximos == 1) {
					$date = new DateTime();
					$date->modify('-6 hours');;
					$lafechoa=  $date->format('Y-m-d H:i:s');									
									//echo "Tipo".$tipo;
									if ($tipo == 'proximos') {
										$sql .= " AND fecha >= :fecha"; 
										$bind[':fecha'] = $lafechoa;
									}
					
				}
				
				$sql .= " LIMIT 1";
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$this->row = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$this->row = $row_p;
				   
				}
	}
	
	
	
	static function verificarAsistencia($evento, $user) {
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_evento_registro WHERE evento = :evento AND usuario = :user";
				$bind = array(
        		':evento' => $evento,
				':user' => $user
    			);
				
				/*echo $sql;
				print_r($bind);*/
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					
					//echo "no hay";
					return 0;
					
				} else {
					//echo "si hay";
					return 1;
				}
		
	}
	
	public function checkEncuesta ($evento) {
		
		$lacoo = $_COOKIE["encuesta_".$evento];
		if ($lacoo == 1) {
			return 1;
		} else {
			return 0;
		}
		
		
	}
	
	public function guardarEncuesta($p1, $p2, $p5, $p6, $alumno) {
 //echo $p1.", ".$p2.", ".$p5.", ".$p6;
					$db1 = null;
					$db1 = Db::getInstance();
					$data1 = array(
						'alumno' => $alumno,
        				'evento' => $this->row[0]['id'],
        				'p1' => $p1,
        				'p2' => $p2,
        				'p5' => $p5,
        				'p6' => $p6,
        				'fecha' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_evento_encuesta', $data1);
					
					setcookie("encuesta_".$this->row[0]['id'],'1',time() + 365 * 24 * 60 * 60);
					

	}
	
	public function getRoles($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT com_evento_rol.rol, com_cargos.plural  FROM com_evento_rol INNER JOIN com_cargos ON com_cargos.id=com_evento_rol.rol WHERE com_evento_rol.evento = :evento";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$resultado = array();
					foreach($row_p as $row_p1) {
						$resultado[$row_p1['rol']] = $row_p1['plural'];
					}					
					return $resultado;
				   
				}
		
	}
	
	public function getDisciplinas($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT com_evento_disciplina.disciplina, com_especialidades.especialidad  FROM com_evento_disciplina INNER JOIN com_especialidades ON com_especialidades.id=com_evento_disciplina.disciplina WHERE com_evento_disciplina.evento = :evento";
    			//$sql = "SELECT disciplina FROM com_evento_disciplina WHERE evento = :evento";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$resultado = array();
					foreach($row_p as $row_p1) {
						$resultado[$row_p1['disciplina']] = $row_p1['especialidad'];
					}					
					return $resultado;
				   
				}
		
	}
	
		public function registrarEntrada($evento,$user,$ip) {
			
			
			$db1 = null;
					$db1 = Db::getInstance();
					$data1 = array(
						'usuario' => $user,
        				'evento' => $evento,
        				'ip' => $ip,
        				'fecha' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_evento_acceso', $data1);
					
					
		
		$db = Db::getInstance();
			$data = array(
        	'entrada' => '1'
		);
		   
		   $db->update('com_evento_registro', $data, 'evento = :evento AND usuario= :usuario', array(':evento' => $evento,':usuario' => $user));
		   
		
	}
	
	
	public function getDescargas($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_evento_descargas WHERE evento = :evento";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
		
	}
	
	static function getDescargaOne($id) {
		
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_evento_descargas WHERE id = :id";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
		
	}
		
		
		
}