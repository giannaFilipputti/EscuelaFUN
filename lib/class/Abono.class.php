<?php
class Abono
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "abonos";
	
    }
	

		
	public function agregar ()
    {
	  
			
			$db = Db::getInstance();
			$data = array(
        	'cliente' => $cliente,
        	'fecha' => date('Y-m-d H:i:s'),
        	'od_es' => $od_es,
        	'od_cyl' => $od_cyl,
        	'od_eje' => $od_eje,
        	'od_add' => $od_add,
        	'od_prisma' => $od_prisma,
        	'od_prisma_dir' => $od_prisma_dir,
        	'oi_es' => $oi_es,
        	'oi_cyl' => $oi_cyl,
        	'oi_eje' => $oi_eje,
        	'oi_add' => $oi_add,
        	'oi_prisma' => $oi_prisma,
        	'oi_prisma_dir' => $oi_prisma_dir,
        	'dp_lejos' => $dp_lejos,
			'dp_cerca' => $dp_cerca,
			'profesional' => $profesional,
			'comentarios' => $receta_comentarios,
			'ot' => $ot

		);
    	$db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
		
		//header("Location: usuarios_up.php?id=".$this->id);
		   //header("Location: usuarios.php");
	  
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: usuarios.php");
	   }
		else if (empty($this->titulo)) {
		   header("Location: usuarios_mod.php?id=".$this->id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'titulo' => $this->titulo
        			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: ucuarios.php");
	   }
		
    }
	

	static function getTotal($ot) {
		$db = Db::getInstance();
		     
					$sql = "SELECT SUM(monto) as total FROM abonos 

					 WHERE ot = :ot";
    				$bind = array(
        			':ot' => $ot
    				);
					
				

    				$sql .= " ORDER BY fecha"; 


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return  "0";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  return $row_p1['total'];				
					}
					//$this->row = $row_p;
				}

	}
	public function getAll ($ot)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".* FROM ".$this->tabla." 
					LEFT JOIN ot ON ".$this->tabla.".ot = ot.id

					 WHERE ".$this->tabla.".ot = :ot";
    				$bind = array(
        			':ot' => $ot
    				);
					
				

    				$sql .= " ORDER BY ".$this->tabla.".fecha"; 


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$this->row = $row_p;
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
					$this->row = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					$this->row = $row_p;
				}
	}

	public function getOneByCod ($codigo)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE codigo = :codigo LIMIT 1";
    			$bind = array(
        		':codigo' => $codigo
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

	public function getIdxCod ($cod)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE codigo = :codigo LIMIT 1";
    			$bind = array(
        		':codigo' => $cod
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					return "0";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					//$this->row = $row_p;
					return $row_p[0]['id'];
				}
	}

	public function getInventario ($producto, $sucursal)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM inventario WHERE producto = :producto AND sucursal = :sucursal LIMIT 1";
    			$bind = array(
        		':producto' => $producto,
        		':sucursal' => $sucursal
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return 0;
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					//$this->row = $row_p;
					return $row_p[0]['cantidad'];
				}
	}


	public function checkCodigo ($codigo)
	{
				//$rut = str_replace(".", "", $rut);
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE codigo = :codigo LIMIT 1";
    			$bind = array(
        		':codigo' => $codigo
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "true";
				} else {
					return "false";
				}
	}

	public function borrarTodos($ot)
	{
				$db = Db::getInstance();

			
       
			$db->delete($this->tabla, "ot=:ot" , array(':ot' => $ot)); 
	}



	
	
	
	
		
}