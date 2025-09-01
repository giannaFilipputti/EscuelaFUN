<?php
class OrdenTrabajo
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $descuento;
	public $descuento1;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $fecha_prometida_d;
	public $fecha_prometida_h;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "ot";
	
    }
	

		
	public function agregar ()
    {
	   
			
	   	 $db = Db::getInstance();
			
       
			$data = array(
        	'fecha' => $this->fecha,
        	'fecha_prometida' => $this->fecha_prometida,
        	'sucursal' => $this->sucursal,
        	'cliente' => $this->cliente,
        	'notas' => $this->notas,
        	'estado' => $this->estado,
        	'user' => $this->user

		);
    	$db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();



			
		
		//header("Location: usuarios_up.php?id=".$this->id);
		   //header("Location: usuarios.php");
	   
		
    }
	

	//$ot->agregarDet($ot->id, $pro->row_p['id'], $cant, $pro->row_p['precio'], $cliente);
	

	public function agregarDet ($ot, $producto,$nombre_producto, $cant, $precio, $cliente, $sucursal, $tipo_inventario)
    {
	   
			if ($tipo_inventario != 2) {
				$db1 = Db::getInstance();
				$sql1 = "SELECT * FROM inventario WHERE producto = :producto AND sucursal = :sucursal LIMIT 1";
    			$bind1 = array(
        		':producto' => $producto,
        		'sucursal' => $sucursal
    			);
		        
				$cont = $db1->run($sql1, $bind1);
				if ($cont == 0) {
					//echo "no encontro";
					$inventario = 0;
					$id_inventario = 0;
				} else {
					
					$db2 = Db::getInstance();
					$row_p = $db2->fetchAll($sql1, $bind1);
					$inventario = $row_p[0]['cantidad'];
					$id_inventario = $row_p[0]['id'];
					//echo "hay inventario.".$row_p[0]['cantidad'];					
				}
			}

          //echo "<br>".$cant." inventario".$inventario;
			if ($inventario >= $cant or $tipo_inventario == 2) {
			
			$db = Db::getInstance();
			
       
			$data = array(
        	'ot' => $ot,
        	'producto' => $producto,
        	'nombre_producto' => $nombre_producto,
        	'cant' => $cant,
        	'precio_venta' => $precio,
        	'cliente' => $cliente

		);
    	$db->insert('ot_det', $data);
 		

 		if ($tipo_inventario != 2) {
 			$cantidad_actual = $inventario - $cant;

    		$db3 = Db::getInstance();
				$data = array(
        			'cantidad' => $cantidad_actual        			
				);
	    	$db3->update('inventario', $data, 'id = :id', array(':id' => $id_inventario));
 		}
    	

			}
	   	 
		   
		
    }


    public function deleteDet ($ot, $id_orden_det, $producto, $cant, $sucursal, $tipo_inventario)
    {
	   
			
			if ($tipo_inventario != 2) {
				$db1 = Db::getInstance();
				$sql1 = "SELECT * FROM inventario WHERE producto = :producto AND sucursal = :sucursal LIMIT 1";
    			$bind1 = array(
        		':producto' => $producto,
        		'sucursal' => $sucursal
    			);
		        
				$cont = $db1->run($sql1, $bind1);
				if ($cont == 0) {
					//echo "no encontro";
					$inventario = 0;
					$id_inventario = 0;
				} else {
					
					$db2 = Db::getInstance();
					$row_p = $db2->fetchAll($sql1, $bind1);
					$inventario = $row_p[0]['cantidad'];
					$id_inventario = $row_p[0]['id'];
					//echo "hay inventario.".$row_p[0]['cantidad'];  
					
				}

			}
				

          //echo "<br>".$cant." inventario".$inventario;
		//if ($cant > 0 or $tipo_inventario == 2) {
			
			$db = Db::getInstance();

			//echo "id_orden_det: ".$id_orden_det;	
       
			$db->delete('ot_det', "id=:id" , array(':id' => $id_orden_det)); 		

 			if ($tipo_inventario != 2) {
 					$cantidad_actual = $inventario + $cant;

    				$db3 = Db::getInstance();
					$data = array(
        				'cantidad' => $cantidad_actual        			
					);
	    			$db3->update('inventario', $data, 'id = :id', array(':id' => $id_inventario));
 			}
    	

		//}
	   	 
		   
		
    }

    public function deleteOt ($ot)
    {
	   
		 $abo = New Abono();
		 $abo->borrarTodos($ot);

		 $rec = New Receta();
		 $rec->borrarTodos($ot);
			
			$db = Db::getInstance();	
       
			$db->delete('ot', "id=:id" , array(':id' => $ot)); 		

 			
    	

		//}
	   	 
		   
		
    }


    public function agregarAbono ($ot, $monto, $forma_pago, $tipo_documento, $no_documento, $no_pago)
    {
	   
			
	   	 $db = Db::getInstance();
			
       
			$data = array(
        	'ot' => $ot,
        	'fecha' => date('Y-m-d H:i:s'),
        	'monto' => $monto,
        	'forma_pago' => $forma_pago,
        	'tipo_documento' => $tipo_documento,
        	'no_documento' => $no_documento,
        	'no_pago' => $no_pago
		);

    	$db->insert('abonos', $data);
		   
		
    }

    public function modificarAbono ($id, $ot, $monto, $forma_pago, $tipo_documento, $no_documento, $no_pago)
    {
	   
			
	   	 $db = Db::getInstance();
			
       
			$data = array(
        	'fecha' => date('Y-m-d H:i:s'),
        	'monto' => $monto,
        	'forma_pago' => $forma_pago,
        	'tipo_documento' => $tipo_documento,
        	'no_documento' => $no_documento,
        	'no_pago' => $no_pago
		);

    	//$db->insert('abonos', $data);
		$db->update('abonos', $data, 'id = :id', array(':id' => $id));
		   
		
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


    public function cambiarEstado($id, $estado)
    {
	   
		
			$db = Db::getInstance();
			$data = array(
        		'estado' => $estado       			
			);
			if ($estado == 1) {
				$data['fecha_entrega'] = date('Y-m-d H:i:s');
			}
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		
	}


	public function calcularTotalOrden ()
    {
	   
		
			$db = Db::getInstance();
				$sql = "SELECT SUM(precio_venta*cant) AS total FROM ot_det WHERE ot = :id";

    				$bind = array(
        			':id' => $this->id
    				);
		        /*echo $sql;
		        print_r($bind);*/
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					return 0;
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					//$this->row = $row_p;
					return $row_p[0]['total'];
				}
		   
		
	}



	public function modificarMonto ($monto, $descuento = 0, $descuento1 = 0)
    {
	   		if (!empty($descuento) && $descuento > 0) {
    			$descuentop = ($monto * $descuento)/100;
  			} else {
  				$descuentop = 0;
  			} 

  			if (!empty($descuento1) && $descuento1 > 0) {
    			$descuentos = $descuento1;
  			} else {
  				$descuentos = 0;
  			} 
  	

	   		$total = round($monto - $descuentop - $descuentos);
		
			$db = Db::getInstance();
			$data = array(
        		'subtotal' => $monto,
        		'descuento' => $descuento,
        		'descuento1' => $descuento1,
        		'monto' => $total        			
			);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		
	}
		

	

	
	public function getAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".id, ".$this->tabla.".fecha, ".$this->tabla.".fecha_prometida, ".$this->tabla.".fecha_entrega, ".$this->tabla.".sucursal, ".$this->tabla.".subtotal, ".$this->tabla.".descuento, ".$this->tabla.".descuento1, ".$this->tabla.".monto, ".$this->tabla.".estado, clientes.nombre, clientes.apellidos, sucursales.sucursal FROM ".$this->tabla." 
					LEFT JOIN clientes ON ".$this->tabla.".cliente = clientes.id
					LEFT JOIN sucursales ON ".$this->tabla.".sucursal = sucursales.id

					 WHERE ".$this->tabla.".id > :id";
					 $bind = array(
        			':id' => '0'
    				);

					 if (!empty($this->cliente)) {
					 	$sql .= " AND ".$this->tabla.".cliente = :cliente";
					 	$bind[":cliente"] = $this->cliente;

					 }

					 if (!empty($this->sucursal) and $this->sucursal > 0) {
					 	$sql .= " AND ".$this->tabla.".sucursal = :sucursal";
					 	$bind[":sucursal"] = $this->sucursal;
					 }


					if (!empty($this->fecha_prometida_d)) {
						$sql .= " AND ".$this->tabla.".fecha_prometida >= :fecha_prometida_d";
					 	$bind[":fecha_prometida_d"] = $this->fecha_prometida_d;
	  				}

	  				if (!empty($this->fecha_prometida_h)) {
						$sql .= " AND ".$this->tabla.".fecha_prometida <= :fecha_prometida_h";
					 	$bind[":fecha_prometida_h"] = $this->fecha_prometida_h;
	  				}

	  				if (!is_null($this->estado)) {
						$sql .= " AND ".$this->tabla.".estado = :estado";
					 	$bind[":estado"] = $this->estado;
	  				}


    				
					
				/*echo $sql."<br>"; 
    				print_r($bind);*/

					$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = $this->tabla.".fecha DESC";
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
	

	public function getProductosVendidos ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ot_det.nombre_producto, ot_det.cant, ot_det.precio_venta,  ".$this->tabla.".id, ".$this->tabla.".fecha, ".$this->tabla.".fecha_prometida, ".$this->tabla.".fecha_entrega, ".$this->tabla.".sucursal, ".$this->tabla.".monto, ".$this->tabla.".estado, clientes.nombre, clientes.apellidos, sucursales.sucursal, productos.codigo FROM ot_det 
						LEFT JOIN ot ON ot_det.ot = ".$this->tabla.".id	
						LEFT JOIN productos ON ot_det.producto = productos.id						
						LEFT JOIN clientes ON ".$this->tabla.".cliente = clientes.id
						LEFT JOIN sucursales ON ".$this->tabla.".sucursal = sucursales.id

					 WHERE ".$this->tabla.".id > :id";
					 $bind = array(
        			':id' => '0'
    				);

					

					 if (!empty($this->sucursal) and $this->sucursal > 0) {
					 	$sql .= " AND ".$this->tabla.".sucursal = :sucursal";
					 	$bind[":sucursal"] = $this->sucursal;
					 }


					if (!empty($this->fecha_d)) {
						$sql .= " AND ".$this->tabla.".fecha >= :fecha_d";
					 	$bind[":fecha_d"] = $this->fecha_d;
	  				}

	  				if (!empty($this->fecha_h)) {
						$sql .= " AND ".$this->tabla.".fecha <= :fecha_h";
					 	$bind[":fecha_h"] = $this->fecha_h;
	  				}

	  				if (!is_null($this->producto)) {
						$sql .= " AND productos.codigo = :producto";
					 	$bind[":producto"] = $this->producto;
	  				}


    				
					
				/*echo $sql."<br>"; 
    				print_r($bind);*/

					$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = $this->tabla.".fecha DESC";
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
				$sql = "SELECT ".$this->tabla.".id, ".$this->tabla.".fecha, ".$this->tabla.".fecha_prometida, ".$this->tabla.".fecha_entrega, ".$this->tabla.".sucursal, ".$this->tabla.".subtotal, ".$this->tabla.".descuento, ".$this->tabla.".descuento1, ".$this->tabla.".monto,  ".$this->tabla.".notas, ".$this->tabla.".estado, clientes.nombre, clientes.apellidos, clientes.rut FROM ".$this->tabla." 
					LEFT JOIN clientes ON ".$this->tabla.".cliente = clientes.id WHERE ".$this->tabla.".id = :id";

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

	public function getOneDet ($id)
	{
			$db = Db::getInstance();
				$sql = "SELECT id FROM ot_det WHERE id = :id";

    				$bind = array(
        			':id' => $id
    				);
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					//$row_p = "";
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);

					return $row_p[0]['id'];
				  
					//$this->row = $row_p;
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



	
	
	
	
		
}