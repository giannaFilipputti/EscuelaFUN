<?php

class Contenido
{
	public $id;
	public $titulo_esp;
	public $titulo_eng;
	public $contenido_esp;
	public $contenido_eng;
	public $ubicacion;
	public $identificador;


    public function __construct()
    {
       // echo "<p>Class X</p>";
	
    }
	

		

	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: contenidos.php");
	   }
		else if (empty($this->titulo_esp)) {
		   header("Location: contenidos_mod.php?id=".$this->id);
	   } else {
			
			$db = Db::getInstance();
			$data = array(
			'titulo_esp' => $this->titulo_esp,
        	'titulo_eng' => $this->titulo_eng,
        	'contenido_esp' => $this->contenido_esp,
        	'contenido_eng' => $this->contenido_eng	
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_contenidos', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: contenidos.php");
	   }
		
    }
	
	
	public function getAll ()
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_contenidos WHERE id > :id ORDER BY id DESC";
    			$bind = array(
        		':id' => '0'
    			);
		       
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					    $this->id[$conty] = $row_p1['id'] ;
						$this->titulo_esp[$conty] = $row_p1['titulo_esp'] ;
						$this->titulo_eng[$conty] = $row_p1['titulo_eng'] ;
					    $this->contenido_esp[$conty] = $row_p1['contenido_esp'] ;
						$this->contenido_eng[$conty] = $row_p1['contenido_eng'] ;
						$this->ubicacion[$conty]=$row_p1['ubicacion'] ;
					    $this->identificador[$conty]=$row_p1['identificador'] ;
					    
					   
				
						$conty++;
					}
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_contenidos WHERE id = :id LIMIT 1";
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
						$this->titulo_esp = $row_p1['titulo_esp'] ;
						$this->titulo_eng = $row_p1['titulo_eng'] ;
					    $this->contenido_esp = $row_p1['contenido_esp'] ;
						$this->contenido_eng = $row_p1['contenido_eng'] ;
						$this->ubicacion=$row_p1['ubicacion'] ;
					    $this->identificador=$row_p1['identificador'] ;
					   
					    
					
						
					}
				}
	}
		
		
}