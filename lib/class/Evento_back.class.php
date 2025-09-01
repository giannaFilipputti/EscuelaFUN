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
	
	
	public function getAll ($tipo = '', $labor = '', $disciplina = '')
	{
				$db = Db::getInstance();
				$sql = "SELECT ".$this->tabla.".* FROM ".$this->tabla; 
				$sql .= "LEFT JOIN com_evento_rol ON ".$this->tabla.".id = com_evento_rol.evento";
				$sql .= "LEFT JOIN com_evento_disciplina ON ".$this->tabla.".id = com_evento_disciplina.evento
				WHERE ".$this->tabla.".id > :id";
				$bind = array(
        		':id' => '0'
    			);				
				
				$date = new DateTime();
				$date->modify('-10 hours');;
				$lafechoa=  $date->format('Y-m-d H:i:s');
				
				//echo "Tipo".$tipo;
				if ($tipo == 'proximos') {
					$sql .= " AND ".$this->tabla.".fecha >= :fecha"; 
					$bind[':fecha'] = $lafechoa;
				} else if ($tipo == 'pasados') {
					$sql .= " AND ".$this->tabla.".fecha < :fecha"; 
					$bind[':fecha'] = $lafechoa;					
				}
				
				if (!empty($disciplina) and $labor != 6) {
					$sql .= " AND com_evento_disciplina.disciplina = :disciplina"; 
					$bind[':disciplina'] = $disciplina;					
				}
				
				if (!empty($labor) and $labor != 6) {
					$sql .= " AND com_evento_rol.rol = :rol"; 
					$bind[':rol'] = $labor;					
				}
				
				
				
				if ($tipo == 'pasados') {
					$sql .= " GROUP BY ".$this->tabla.".id ORDER BY fecha DESC";
					
				} else {
					$sql .= " GROUP BY ".$this->tabla.".id ORDER BY fecha";
				}
								
				/*echo $sql;
				print_r($bind);*/			
				
    			
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
		
		
		
}