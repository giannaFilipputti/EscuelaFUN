<?php
class Producto
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
	public $inventario;
	public $sucursal;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "productos";
	
    }
	

		
	public function agregar ()
    {
	   if (empty($this->codigo) or empty($this->nombre)) {
		   header("Location: usuarios_add.php");
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'codigo' => $this->codigo,
        	'nombre' => $this->nombre,
        	'tipo_producto' => $this->tipo_producto,
        	'marca' => $this->marca,
        	'tratamiento' => $this->tratamiento,
        	'tipo_cristal' => $this->tipo_cristal,
        	'esfera' => $this->esfera,
        	'cilindro' => $this->cilindro,
        	'eje' => $this->eje,
        	'color' => $this->color,
        	'espesor' => $this->espesor,
        	'adicion' => $this->adicion,
        	'diametro' => $this->diametro,
        	'base' => $this->base,
        	'costo' => $this->costo,
        	'descripcion' => $this->descripcion,
        	'precio' => $this->precio,
        	'inventario' => $this->inventario,
        	'sucursal' => $this->sucursal

		);
    	$db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
		
		//header("Location: usuarios_up.php?id=".$this->id);
		   //header("Location: usuarios.php");
	   }
		
    }


	
	
	
	public function modificar ()
    {
	  if (empty($this->codigo) or empty($this->nombre)) {
		   header("Location: usuarios_add.php");
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'codigo' => $this->codigo,
        	'nombre' => $this->nombre,
        	'tipo_producto' => $this->tipo_producto,
        	'marca' => $this->marca,
        	'tratamiento' => $this->tratamiento,
        	'tipo_cristal' => $this->tipo_cristal,
        	'esfera' => $this->esfera,
        	'cilindro' => $this->cilindro,
        	'eje' => $this->eje,
        	'color' => $this->color,
        	'espesor' => $this->espesor,
        	'adicion' => $this->adicion,
        	'diametro' => $this->diametro,
        	'base' => $this->base,
        	'costo' => $this->costo,
        	'descripcion' => $this->descripcion,
        	'precio' => $this->precio,
        	'inventario' => $this->inventario,
        	'sucursal' => $this->sucursal

		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		//header("Location: ucuarios.php");
	   }
		
    }
	

	
	public function getAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".id, ".$this->tabla.".nombre, ".$this->tabla.".codigo, ".$this->tabla.".esfera, ".$this->tabla.".cilindro, ".$this->tabla.".eje,  ".$this->tabla.".espesor, ".$this->tabla.".adicion,  ".$this->tabla.".diametro,  ".$this->tabla.".base,  ".$this->tabla.".costo,  ".$this->tabla.".descripcion,  ".$this->tabla.".precio, ".$this->tabla.".inventario, ".$this->tabla.".sucursal, tipo_producto.tipo_producto AS tipo_producto, tabla_marcas.marca AS marca, tratamientos.tratamientos AS tratamiento, tipo_cristal.tipo_cristal AS tipo_cristal  FROM ".$this->tabla." 
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

	public function getAllbyOrden ($ot)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".id, ".$this->tabla.".nombre, ".$this->tabla.".codigo, ".$this->tabla.".esfera, ".$this->tabla.".cilindro, ".$this->tabla.".eje,  ".$this->tabla.".espesor, ".$this->tabla.".adicion,  ".$this->tabla.".diametro,  ".$this->tabla.".base,  ".$this->tabla.".costo,  ".$this->tabla.".descripcion, ".$this->tabla.".inventario, ".$this->tabla.".sucursal, ot_det.id AS ot_id, ot_det.nombre_producto, ot_det.precio_venta,  ot_det.cant  FROM ot_det 
					LEFT JOIN ".$this->tabla." ON ".$this->tabla.".id = ot_det.producto

					 WHERE ot_det.ot = :ot";
    				$bind = array(
        			':ot' => $ot
    				);
					
				

    				/*echo $sql;
    				print_r($bind);*/
    				


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontro";
				} else {
					//echo "encontro";
					
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

				$sql = "SELECT ".$this->tabla.".id, ".$this->tabla.".codigo, ".$this->tabla.".nombre, ".$this->tabla.".costo, ".$this->tabla.".precio, productos.inventario, productos.sucursal, colores.color FROM productos
    LEFT JOIN colores ON ".$this->tabla.".color = colores.id
    LEFT JOIN tabla_marcas ON ".$this->tabla.".marca = tabla_marcas.id
    LEFT JOIN tipo_producto ON ".$this->tabla.".tipo_producto = tipo_producto.id
     WHERE codigo = :codigo LIMIT 1";


				//$sql = "SELECT * FROM ".$this->tabla." WHERE codigo = :codigo LIMIT 1";
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

	public function getInfoxCod ($cod)
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
					return $row_p[0];
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



	
	
	
	
		
}