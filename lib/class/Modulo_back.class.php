<?php
class Modulo
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 50;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_cursos_mod";
	
    }
	

		
	public function agregar ()
    {
	   if (empty($this->marca)) {
		   header("Location: modulos_add.php");
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'marca' => $this->marca
		);
    	$db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
		
		//header("Location: modulos_up.php?id=".$this->id);
		   header("Location: modulos.php");
	   }
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: modulos.php");
	   }
		else if (empty($this->marca)) {
		   header("Location: modulos_mod.php?id=".$this->id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'marca' => $this->marca
        			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: modulos.php");
	   }
		
    }
	

	
	public function getAll ($id)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." WHERE curso = :id";
    				$bind = array(
        			':id' => $id
    				);					
				
					$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = "orden";
    				} else {
    					$orden = $this->orden;
    				}
    				

    				if ($this->tiporden == 'desc') {
    					$tiporden = " desc";
    				} else {
    					$tiporden = "";
    				}

    				$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 
				
				


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					return $row_p;
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
	}

	public function registrarAcceso() {

				$db = Db::getInstance();
				$sql = "SELECT * FROM com_alumnos_modulo WHERE alumno = :alumno AND modulo = :modulo LIMIT 1";
    			$bind = array(
        		':alumno' => $this->alumno,
        		':modulo' => $this->row[0]['id']
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {

					$db1 = Db::getInstance();
					$data1 = array(
        				'alumno' => $this->alumno,
        				'modulo' => $this->row[0]['id'],
        				'fecin' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_alumnos_modulo', $data1);
				} else {
					
					// no pasa nada si ya se registró el acceso
				}

	}

	public function guardarEncuesta($p1, $p2, $p3, $p4, $p5, $p6) {

					$db1 = null;
					$db1 = Db::getInstance();
					$data1 = array(
        				'alumno' => $this->alumno,
        				'modulo' => $this->row[0]['id'],
        				'p1' => $p1,
        				'p2' => $p2,
        				'p3' => $p3,
        				'p4' => $p4,
        				'p5' => $p5,
        				'p6' => $p6,
        				'fecha' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_encuesta', $data1);

	}



	
	
	
	
		
}