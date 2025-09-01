<?php

class Codigo
{
	public $id;
	public $categoria_esp;
	public $categoria_eng;
	public $proyecto;
	public $orden;


    public function __construct()
    {
       // echo "<p>Class X</p>";
	    $this->tabla = "com_codigos";
	
    }
	
	private function getOrden($tabla='regiones')
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
	   if (empty($this->categoria_esp)) {
		   header("Location: categorias_add.php");
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'categoria_esp' => $this->categoria_esp,
        	'categoria_eng' => $this->categoria_eng,
			'orden' => $this->orden		
		);
    	$db->insert('com_categorias', $data);
		   
		header("Location: categorias.php");
	   }
		
    }
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: categorias.php");
	   }
		else if (empty($this->categoria_esp)) {
		   header("Location: categorias_mod.php?id=".$this->id);
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'categoria_esp' => $this->categoria_esp,
        	'categoria_eng' => $this->categoria_eng	
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_categorias', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: categorias.php");
	   }
		
    }
	
	
	public function getAll ($org = "")
	{
				$db = Db::getInstance();
				$sql = "SELECT ".$this->tabla.".*, com_registro.nombre, com_registro.ape1, com_registro.ape2, com_cursos_2022.titulo FROM ".$this->tabla." LEFT JOIN com_registro ON com_registro.id = ".$this->tabla.".usuario LEFT JOIN com_cursos_2022 ON com_cursos_2022.id = ".$this->tabla.".curso WHERE ".$this->tabla.".id > :id";
    			$bind = array(
        		':id' => '0'
    			);

                if (!empty($org)) {
                    $sql .= " AND ".$this->tabla.".organizacion = :organizacion";
                    $bind[':organizacion'] = $org;

                }
				
				$sql .= " ORDER BY ".$this->tabla.".id";
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				   return $row_p;
				}
	}
	
	
	public function getOne ($codigo)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE codigo = :codigo LIMIT 1";
    			$bind = array(
        		':codigo' => $codigo
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                    $this->id = $row_p[0]['id'];
                    return $row_p[0];
				  
				}
	}

    public function codigoUsado ($curso, $usuario)
    {
	   if (empty($this->id)) {
		   //header("Location: categorias.php");
	   }
		 else {
			
			$db = Db::getInstance();
			$data = array(
        	'usuario' => $usuario,
        	'curso' => $curso,
            'usado' => '1'	
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		
	   }
		
    }
	
	static function getLabor($id) {
		
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_cargo WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				    return $row_p[0]['cargo'];
				}
		
	}
	
	static function getCargos ($user)
	{
			$db = Db::getInstance();
			$sql = "SELECT com_cargos.* FROM com_cargos INNER JOIN com_users_cargo ON com_cargos.id = com_users_cargo.cargo WHERE com_users_cargo.user = :user";
    			$bind = array(
        		':user' => $user
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
	}


	static function getRegion ($id=0)
	{
		if ($id == 0 or empty($id)) {
			return "";

		} else {
			$db = Db::getInstance();
				$sql = "SELECT * FROM com_regiones WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					return $row_p[0]['region'];
				   
				}

		}

				
	}
      
		
		
}