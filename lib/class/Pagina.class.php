<?php
class Pagina
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;
	public $capitulo;

	public $estado;
	public $row;

	public $modulo;
	public $pag = 1;
	public $limit = 40;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "eve_eventos_contenidos";
	
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
	

	
	public function getAll ($capitulo)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." WHERE id > :id";
    				$bind = array(
        			':id' => '0'
    				);


    				if (!empty($capitulo)) {
					 	$sql .= " AND evento = :capitulo";
					 	$bind[":capitulo"] = $capitulo;

					 }

				
					
				
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
				
				
    				//echo $sql;

		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					
				   $this->hayelemen = $cont;
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  $longitud = count($row_p);
					for($i=0; $i<$longitud; $i++) {

					    //echo $row_p1['nombre'] ;
						$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'],1);
					   
				
						$conty++;
					}
					//$this->row_p = $row_p;
					$this->row = $row_p;
				}
	}

	public function porcentajeAlumno($id,$salida=0) {

			$sql = "SELECT id FROM com_ponencias_ima";
		 	$sql .= " WHERE ponencia = :ponencia";
		 					
						$bind = array(
        					':ponencia' => $id
    					);
    		$sql .= " ORDER BY orden";
    		$db = Db::getInstance();
			$cont = $db->run($sql, $bind);

			$sql1 = "SELECT id FROM com_alumnos_diapos";
		 	$sql1 .= " WHERE pagina = :pagina AND alumno = :alumno AND NOT (diapo <=> NULL)";
		 					
						$bind1 = array(
        					':pagina' => $id,
        					':alumno' => $this->alumno
    					);
    		$db1 = Db::getInstance();
			$cont1 = $db1->run($sql1, $bind1);
			$porcentaje = ($cont1 * 100) / $cont;
			if ($salida==0) {
				$this->porcentaje = $porcentaje;
			} else {
				return round($porcentaje);
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
				  	

					$this->row = $row_p;

					$this->contadorPag();
				}
	}

	public function contadorPag() {

		$sql = "SELECT id FROM ".$this->tabla."";
		$sql .= " WHERE orden < :orden AND evento = :capitulo ORDER BY orden";					

					$bind = array(
        				':orden' => $this->row[0]['orden'],
        				':capitulo' => $this->row[0]['evento']
    				);

		/*echo $sql;
		print_r($bind);*/

				$db = null;
				$db = Db::getInstance();		
		        
				$cont = $db->run($sql, $bind);

				$this->contActual = $cont+1;

		$sql1 = "SELECT id FROM ".$this->tabla."";
		$sql1 .= " WHERE evento = :capitulo ORDER BY orden";					

					$bind1 = array(
        				':capitulo' => $this->row[0]['evento']
    				);

				/*echo $sql1;
		print_r($bind1);*/


				$db1 = null;
				$db1 = Db::getInstance();		
		        
				$cont1 = $db1->run($sql1, $bind1);

				$this->contTotal = $cont1;
				

	
	}



	
	
	
	
		
}