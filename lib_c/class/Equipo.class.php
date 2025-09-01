<?php
class Equipo
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
		        if ($this->interfaz==1) {
					$sqlag = " AND estado = 1";
				}
		        else {
					$sqlag = "";
				}
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_equipo WHERE id > :id AND tipo= :tipo".$sqlag." ORDER BY orden";
    				$bind = array(
        			':id' => '0',
        			':tipo' => $this->tipo
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  
					    $this->id[$conty] = $row_p1['id'] ;
						$this->nombre[$conty] = $row_p1['nombre'] ;
						$this->cargo[$conty] = $row_p1['cargo'] ;
						$this->frase_esp[$conty] = $row_p1['frase_esp'] ;
						$this->frase_eng[$conty] = $row_p1['frase_eng'] ;
					    $this->imagen[$conty] = $row_p1['imagen'] ;
						$this->orden[$conty]=$row_p1['orden'] ;
						$this->estado[$conty]=$row_p1['estado'] ;
						$this->tipo[$conty]=$row_p1['tipo'] ;
					    
					  $conty++;
				
					}
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_equipo WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				   foreach($row_p as $row_p1) {
					    $this->id = $row_p1['id'] ;
						$this->nombre = $row_p1['nombre'] ;
						$this->cargo = $row_p1['cargo'] ;
						$this->frase_esp = $row_p1['frase_esp'] ;
						$this->frase_eng = $row_p1['frase_eng'] ;
					    $this->imagen = $row_p1['imagen'] ;
						$this->orden=$row_p1['orden'] ;
						$this->estado=$row_p1['estado'] ;
						$this->tipo=$row_p1['tipo'] ;
					   
					   					   
					  
						
					}
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