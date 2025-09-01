<?php
class Cliente
{
	public $id;
	public $titulo;
	public $imagen;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	public $origen;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
	
    }
	
	private function getOrden($tabla='clientes')
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
	   if (empty($this->rut) or empty($this->apellidos)) {
		   header("Location: clientes_add.php");
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'empresa' => $this->empresa,
			'apellidos' => $this->apellidos,
			'nombre' => $this->nombre,
			'rut' => $this->rut,
			'email' => $this->email,
			'telf_trabajo' => $this->telf_trabajo,
			'telf_particular' => $this->telf_particular,
			'telf_movil' => $this->telf_movil,
			'direccion' => $this->direccion,
			'ciudad' => $this->ciudad,
			'provincia' => $this->provincia,
			'region_pais' => $this->region_pais,
			'notas' => $this->notas,
			'fecin' => date('Y-m-d H:i:s'),
			'fecmod' => date('Y-m-d H:i:s')
		);
    	$db->insert('clientes', $data);
		$this->id = $db->lastInsertId();
		
		//header("Location: clientes_up.php?id=".$this->id);
		if ($this->origen != 1) {
			header("Location: clientes.php");
		} 
		   
	   }
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: clientes.php");
	   }
		else if (empty($this->rut)) {
		   header("Location: clientes_mod.php?id=".$this->id);
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'empresa' => $this->empresa,
			'apellidos' => $this->apellidos,
			'nombre' => $this->nombre,
			'rut' => $this->rut,
			'email' => $this->email,
			'telf_trabajo' => $this->telf_trabajo,
			'telf_particular' => $this->telf_particular,
			'telf_movil' => $this->telf_movil,
			'direccion' => $this->direccion,
			'notas' => $this->notas,
			'fecmod' => date('Y-m-d H:i:s')
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('clientes', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: clientes.php");
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
		     
					$sql = "SELECT * FROM clientes WHERE id > :id".$sqlag."";
    				$bind = array(
        			':id' => '0'
    				);

    				if (!empty($this->rut)) {
					 	$sql .= " AND rut= :rut";
					 	$bind[":rut"] = $this->rut;
					 }

					 if (!empty($this->nombre)) {
					 	$sql .= " AND nombre LIKE :nombre";
					 	$bind[":nombre"] = "%$this->nombre%";
					 }

					 if (!empty($this->apellidos)) {
					 	$sql .= " AND apellidos LIKE :apellidos";
					 	$bind[":apellidos"] = "%$this->apellidos%";
					 }
					
					if (!empty($this->email)) {
					 	$sql .= " AND email= :email";
					 	$bind[":email"] = $this->email;
					 }
				
				$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = "apellidos";
    				} else {
    					$orden = $this->orden;
    				}
    				

    				if ($this->tiporden == 'desc') {
    					$tiporden = " desc";
    				} else {
    					$tiporden = "";
    				}

    				$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 

    					//echo $sql;
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   /*foreach($row_p as $row_p1) {
					  $conty++;				
					}*/
					$this->row = $row_p;
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM clientes WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					$this->row = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				
					$this->row = $row_p;
				}
	}

	public function getOneByRut ($rut)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM clientes WHERE rut = :rut LIMIT 1";
    			$bind = array(
        		':rut' => $rut
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					$this->row = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				
					$this->row = $row_p;
				}
	}


	public function checkemail ($rut)
	{
				//$rut = str_replace(".", "", $rut);
				$db = Db::getInstance();
				$sql = "SELECT * FROM clientes WHERE rut = :rut LIMIT 1";
    			$bind = array(
        		':rut' => $rut
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "true";
				} else {
					return "false";
				}
	}
	
	
	
	
		
}