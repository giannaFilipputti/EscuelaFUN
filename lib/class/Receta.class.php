<?php
class Receta
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
	public $hay;	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "recetas";
	
    }
	

		
	public function agregar ($ot,$cliente,$od_es,$od_cyl,$od_eje,$od_add,$od_prisma,$od_prisma_dir,$oi_es,$oi_cyl,$oi_eje,$oi_add,$oi_prisma,$oi_prisma_dir,$dp_lejos,$dp_cerca,$profesional,$receta_comentarios)
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
	
	public function getbyOT($ot) {

		$db = Db::getInstance();
		     
					$sql = "SELECT *  FROM ".$this->tabla." 
					

					 WHERE ".$this->tabla.".ot = :ot";
    				$bind = array(
        			':ot' => $ot
    				);
					
				
				

    				//$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					$this->hay = 0;
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$this->hay = 1;
					$this->row = $row_p;
				}

	}

	public function getbyCliente($cliente) {

		$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." 
					

					 WHERE ".$this->tabla.".cliente = :cliente";
    				$bind = array(
        			':cliente' => $cliente
    				);
					
				
				

    				//$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					$this->hay = 0;
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$this->hay = 1;
					$this->row = $row_p;
				}

	}

	
	public function getAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".id, ".$this->tabla.".nombre, ".$this->tabla.".codigo, ".$this->tabla.".esfera, ".$this->tabla.".cilindro, ".$this->tabla.".eje,  ".$this->tabla.".espesor, ".$this->tabla.".adicion,  ".$this->tabla.".diametro,  ".$this->tabla.".base,  ".$this->tabla.".costo,  ".$this->tabla.".descripcion,  ".$this->tabla.".precio, tipo_producto.tipo_producto AS tipo_producto, tabla_marcas.marca AS marca, tratamientos.tratamientos AS tratamiento, tipo_cristal.tipo_cristal AS tipo_cristal  FROM ".$this->tabla." 
					LEFT JOIN tabla_marcas ON ".$this->tabla.".marca = tabla_marcas.id
					LEFT JOIN tipo_producto ON ".$this->tabla.".tipo_producto = tipo_producto.id
					LEFT JOIN tratamientos ON ".$this->tabla.".tratamiento = tratamientos.id 
					LEFT JOIN tipo_cristal ON ".$this->tabla.".tipo_cristal = tipo_cristal.id

					 WHERE ".$this->tabla.".id > :id";
    				$bind = array(
        			':id' => '0'
    				);
					
				
				$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = $this->tabla.".nombre";
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