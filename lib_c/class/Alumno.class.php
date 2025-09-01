<?php

class Alumno
{
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $ciudad;
    public $cp;
    public $especialidad;
    public $linkedin;
    public $twitter;
    public $facebook;
    public $idioma;

    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_alumnos";
	
    }
	
	private function getOrden($tabla='com_alumnos')
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
		   header("Location: alumno_add.php");
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
	
	
	public function getAll ()
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE test= 0 AND activado = 1 AND asistir = 1 ORDER BY nombre";
                               //echo "SQL: ".$sql;
    			$bind = array(
        		':id' => $id
    			);
		       
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$conty = 0;
                    $this->row = $row_p;
				}
	}
	public function getTot ()
	{
				$db = Db::getInstance();
				//$sql = "SELECT * FROM ".$this->tabla." WHERE test= 0 AND activado = 1 ORDER BY nombre LIMIT 499, 500";
				$sql = "SELECT * FROM ".$this->tabla." WHERE test= 0 ORDER BY nombre";
                                //echo $sql;
    			$bind = array(
        		':id' => $id
    			);
		       
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$conty = 0;
                    $this->row = $row_p;
				}
	}

	public function getTotJoin ()
	{
				$db = Db::getInstance();
				//$sql = "SELECT * FROM ".$this->tabla." WHERE test= 0 AND activado = 1 ORDER BY nombre LIMIT 499, 500";
				$sql = "SELECT * FROM ".$this->tabla." L ORDER BY nombre";
                             echo $sql;
    			/*$bind = array(
        		':id' => $id
    			);*/
		       
				$cont = $db->run($sql);
				if ($cont == 0) {
					echo "nada";
					$row_p = "";
					
				} else {
					echo "si hay";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$conty = 0;
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
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                    $this->row = $row_p;
				
				}
	}

	public function claveDiploma($id,$clave) {

		$db = Db::getInstance();
			$data = array(
        	'clave_diploma' => $clave

		);

    	//$db->insert('com_proyectos', $data);

		   

		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

	}


	public function getOneSec ($id,$clave)

	{

				$db = Db::getInstance();

				$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id and clave_diploma = :clave  LIMIT 1";

    			$bind = array(
					':id' => $id,
					':clave' => $clave
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
        
        
	public function getIdioma($id)

	{

				$db = Db::getInstance();

				$sql = "SELECT idioma FROM ".$this->tabla." WHERE id = ".$id." LIMIT 1";

                                
                                $bind = array(
                                    ':id' => $id,
                                );

				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                                        
                                        //var_dump($row_p);
                                        
                                    return $row_p;
				}

	}
        
	public function cambiarIdioma($id,$idiom)

	{

            $db = Db::getInstance();
			$data = array(
        	'idioma' => $idiom

		);

    	//$db->insert('com_proyectos', $data);

		   

		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
                   
                   

	}

	public function registrarJoinURL($evento, $alumno, $joinurl){

		$db = Db::getInstance();
			$data = array(
        	'joinurl' => $joinurl

		);

    	//$db->insert('com_proyectos', $data);

		   

		   $db->update('com_alumnos', $data, 'id = :id', array(':id' => $alumno));

	}


	public function getEnc ()
	{
				$db = Db::getInstance();
				//$sql = "SELECT * FROM ".$this->tabla." WHERE test= 0 AND activado = 1 ORDER BY nombre LIMIT 499, 500";
				$sql = "SELECT com_alumnos.email, com_alumnos.id AS idm, com_encuesta.* FROM com_alumnos INNER JOIN com_encuesta ON com_encuesta.alumno = com_alumnos.id  WHERE com_alumnos.id >= :id ORDER BY com_encuesta.fecha";
		   
	
                                //echo $sql;
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
                    $this->row = $row_p;
				}
	}


	public function getEnc2 ()
	{
				$db = Db::getInstance();
				//$sql = "SELECT * FROM ".$this->tabla." WHERE test= 0 AND activado = 1 ORDER BY nombre LIMIT 499, 500";
				$sql = "SELECT com_alumnos.email, com_alumnos.id AS idm, com_encuesta_webinar_2.* FROM com_alumnos INNER JOIN com_encuesta_webinar_2 ON com_encuesta_webinar_2.alumno = com_alumnos.id  WHERE com_alumnos.id >= :id ORDER BY com_encuesta_webinar_2.fecha";
		   
	
                                //echo $sql;
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
                    $this->row = $row_p;
				}
	}
}