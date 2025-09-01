<?php
class Entrenador
{
	public $id;
	public $titulo;
	public $imagen;
	public $orden;
	public $estado;
	public $tipo;
	
	public $img_ppl;
	
	public $cnt_img_ppl;

	public $box_tit;
	public $box_addtit;
	public $box_modtit;
	public $form_tit;
	public $form_stit;

	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
	
    }
	
	private function getOrden($tabla='com_equipo')
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
	   if (empty($this->nombre)) {
		   header("Location: equipo_add.php");
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'nombre' => $this->nombre,
        	'cargo' => $this->cargo,
        	'frase_esp' => $this->frase_esp,
        	'frase_eng' => $this->frase_eng,
			'orden' => $this->orden,
			'tipo' => $this->tipo
		);
    	$db->insert('com_equipo', $data);
		$this->id = $db->lastInsertId();
		
		   header("Location: equipo.php?tipo=".$this->tipo);
	   }
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: equipo.php");
	   }
		else if (empty($this->nombre)) {
		   header("Location: equipo_mod.php?id=".$this->id);
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'nombre' => $this->nombre,
        	'cargo' => $this->cargo,
        	'frase_esp' => $this->frase_esp,
        	'frase_eng' => $this->frase_eng
        			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_equipo', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: equipo.php?tipo=".$this->tipo);
	   }
		
    }
	

	
	public function getAll ()
	{
		       
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_registro WHERE id > :id ORDER BY ape1";
    				$bind = array(
        			':id' => '0'
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				
				$this->contador = $cont;
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					  
					    
						$this->row = $row_p;
					    
					
				}
	}
	
	
	public function getAll1 ()
	{
		       
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_mesadedialogo WHERE id > :id ORDER BY ape1";
    				$bind = array(
        			':id' => '0'
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				
				$this->contador = $cont;
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					  
					    
						$this->row = $row_p;
					    
					
				}
	}
	
	
	public function getAllEvento ($evento)
	{
		       
				$db = Db::getInstance();
		     
					$sql = "SELECT com_registro.*, eve_evento_registro.entrada FROM com_registro INNER JOIN eve_evento_registro ON com_registro.id = eve_evento_registro.usuario  WHERE com_registro.id > :id AND eve_evento_registro.evento = :evento ORDER BY com_registro.ape1";
    				$bind = array(
        			':id' => '0',
					':evento' => $evento
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				
				$this->contador = $cont;
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					  
					    
						$this->row = $row_p;
					    
					
				}
	}
	
	public function getAllSearch ($nombre,$ape1,$email,$pais,$disciplina,$rol)
	{
		       
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_registro WHERE id > :id AND pais = 19";
    				$bind = array(
        			':id' => '0'
    				);
					
					
								if (!empty($nombre)) {
                                
                              
                                    $nombres = explode(" ", $nombre);
                                    $concatenador = "AND ";
                                    $conti = 1;
                                    
                                    foreach($nombres as $word){
                                    //if ($conti >1){
                                            $sql.= " ".$concatenador;
                                    //    } 
                                        $sql .= " (nombre LIKE :nombre_".$conti.")";
                                        $bind[":nombre_".$conti] = "%$word%";
                                        $conti ++;
                                    }

                                }
								
								
								if (!empty($ape1)) {
                                
                              
                                    $ape1s = explode(" ", $ape1);
                                    $concatenador = "AND ";
                                    $conti = 1;
                                    
                                    foreach($ape1s as $word){
                                    //if ($conti >1){
                                            $sql.= " ".$concatenador;
                                    //    } 
                                        $sql .= " (ape1 LIKE :ape_".$conti.")";
                                        $bind[":ape_".$conti] = "%$word%";
                                        $conti ++;
                                    }

                                }
								
					
					if (!empty($email)) {
						$sql .= "  AND email = :email";
						
						$bind[':email'] = $email;
					}
					
					if (!empty($pais)) {
						$sql .= "  AND pais = :pais";
						
						$bind[':email'] = $email;
					}
					
					if (!empty($disciplina)) {
						$sql .= "  AND disciplina = :disciplina";
						
						$bind[':disciplina'] = $disciplina;
					}
					
					if (!empty($rol)) {
						$sql .= "  AND labor = :rol";
						
						$bind[':rol'] = $rol;
					}
					
					$sql .= "  ORDER BY ape1";
					
				
		        
				$cont = $db->run($sql, $bind);
				
				$this->contador = $cont;
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					  
					    
						$this->row = $row_p;
					    
					
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_registro WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				   $this->row = $row_p;
				}
	}

	public function setTitulos ($tipo)
	{
		$this->tipo = $tipo;
		if ($this->tipo == 1) {
			$this->box_tit = "Integrantes del equipo";
			$this->box_addtit = "Agregar integrante del equipo";
			$this->box_modtit = "Modificar integrante del equipo";
			$this->form_tit = "Nombre";
			$this->form_stit = "Cargo";
		} else if ($this->tipo == 2) {
			$this->box_tit = "Testimonios Clientes";
			$this->box_addtit = "Agregar testimonio cliente";
			$this->box_modtit = "Modificar  testimonio cliente";
			$this->form_tit = "Nombre";
			$this->form_stit = "Cargo";
		} else if ($this->tipo == 3) {
			$this->box_tit = "Servicios";
			$this->box_addtit = "Agregar Servicio";
			$this->box_modtit = "Modificar Servicio";
			$this->form_tit = "Titulo español";
			$this->form_stit = "Titulo ingles";
		} else if ($this->tipo == 4) {
			$this->box_tit = "Puntos Fuertes";
			$this->box_addtit = "Agregar Punto Fuerte";
			$this->box_modtit = "Modificar Punto fuerte";
			$this->form_tit = "Titulo español";
			$this->form_stit = "Titulo ingles";
		}
	}		 
}