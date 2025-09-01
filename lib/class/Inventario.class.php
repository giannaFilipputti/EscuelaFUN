<?php
class Inventario
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
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;
	public $id_entrada;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
	
    }
	

		
	public function agregar ($sucursal, $producto, $cant)
    {
	  	
	  	$db = Db::getInstance();
				$sql = "SELECT * FROM inventario WHERE producto = :producto AND sucursal = :sucursal LIMIT 1";
    			$bind = array(
        			'producto' => $producto,
        			'sucursal' => $sucursal
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$db = Db::getInstance();
					$data = array(
						'producto' => $producto,
        				'sucursal' => $sucursal,
        				'cantidad'=> $cant

					);
    				$db->insert('inventario', $data);
					$this->id = $db->lastInsertId();
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  	$cant_actual = $row_p[0]['cantidad'];
				  	$id = $row_p[0]['id'];

				  	$cant = $cant + $cant_actual;

				  	$data = array(
        				'cantidad'=> $cant
					);
				  	$db->update('inventario', $data, 'id = :id', array(':id' => $id));
					//$this->row = $row_p;
				}


			
			
		
	   
		
    }


    public function nuevaEntrada ($id_proveedor,$tipo_documento, $no_documento, $total, $sucursal)
    {
	  	
	  	
					$db = Db::getInstance();
					$data = array(
						'fecha' => date('Y-m-d H:i:s'),
						'proveedor' => $id_proveedor,
        				'tipo_documento' => $tipo_documento,
        				'no_documento'=> $no_documento,
        				'total'=> $total,
        				'sucursal'=> $sucursal

					);
    				$db->insert('entradas', $data);
					$this->id_entrada = $db->lastInsertId();
				
	   
		
    }

    public function detalleEntrada ($entrada,$producto, $precio, $cantidad)
    {
	  	
	  	
					$db = Db::getInstance();
					$data = array(
						'entrada' => $entrada,
        				'producto' => $producto,
        				'precio'=> $precio,
        				'cantidad'=> $cantidad

					);
    				$db->insert('entradas_det', $data);
					$this->id_entrada = $db->lastInsertId();
				
	   
		
    }


	public function restarInventario ($sucursal, $producto, $cant) {
		
	}
	
	
	
	public function modificar ($sucursal, $producto, $cant)
    {
	   if (empty($this->id)) {
		   header("Location: sucursales.php");
	   }
		else if (empty($this->titulo)) {
		   header("Location: sucursales_mod.php?id=".$this->id);
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'titulo' => $this->titulo
        			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('sucursales', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: sucursales.php");
	   }
		
    }
	

	
	public function getAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM sucursales WHERE id > :id".$sqlag."";
    				$bind = array(
        			':id' => '0'
    				);
					
				
				$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = "sucursal";
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
				   /*foreach($row_p as $row_p1) {
					  $conty++;				
					}*/
					$this->row = $row_p;
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM sucursales WHERE id = :id LIMIT 1";
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


	public function checkemail ($rut)
	{
				//$rut = str_replace(".", "", $rut);
				$db = Db::getInstance();
				$sql = "SELECT * FROM sucursales WHERE rut = :rut LIMIT 1";
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