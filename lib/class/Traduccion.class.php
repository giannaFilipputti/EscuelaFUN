<?php

class Traduccion
{
	public $id;
	public $categoria_esp;
	public $categoria_eng;
	public $proyecto;
	public $orden;


    public function __construct()
    {
       // echo "<p>Class X</p>";
	    $this->tabla = "com_especialidades";
	
    }
	
	
	
	
	public function getTraduccion ($idiom = 'esp')
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_traduccion WHERE id > :id ORDER BY id";
    			$bind = array(
        		':id' => '0'
    			);
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
					 
					 $var = array();
					 
					foreach($row_p as $row_p1) {
					    $var[$row_p1['clave']] = $row_p1[$idiom];						
					}
				   return $var;
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_categorias WHERE id = :id LIMIT 1";
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
						$this->categoria_esp = $row_p1['categoria_esp'] ;
						$this->categoria_eng = $row_p1['categoria_eng'] ;
						$this->orden=$row_p1['orden'] ;
					   
					    
					
						
					}
				}
	}
	
	
	static function getDisciplina($id) {
		
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_especialidades WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				    return $row_p[0]['especialidad'];
				}
		
	}
		
		
}