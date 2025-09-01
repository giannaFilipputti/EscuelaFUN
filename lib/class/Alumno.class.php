<?php

class Alumno
{
	public $login = "";
	public $rowff = array();
	public $ape1;
	public $ape2;
	public $nombre;
	public $dni;
	public $perfil;
	public $especialidad;
	public $numcolegiado;
	public $email;
	public $pais;
	public $provincia;
	public $poblacion;
	public $ciudad;
	public $direccion;
	public $cp;
	public $telefono;
	public $fax;
	public $empresa;
	public $usu_tipo;
	public $test;
	public $tipo_test;
	public $servicio;
	public $activado;
	public $newsletter = 0;
	public $logueado;
	
	private $pass;
	

    public function __construct()
    {
       // echo "<p>Class X</p>";
	
    }
	
	
	public function getOne ($id)
    {
		    
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_registro WHERE id = :id";
    			$bind = array(
        		':id' => $id
                );
		
				$cont = $db->run($sql, $bind);
		
		//$cont = $db->run($sql, $bind);
		//echo "Contador:".$cont;
		
		if ($cont > 0){
			//echo "entra aqui";
			$db1 = Db::getInstance();
            $rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			return $rowff1[0];
       		
		  
			
		} else {
			//header("Location: login.php?err=1");
			return "err1";
		}
		
	
	}


	static function getDatos ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_registro WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return"";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                    return $row_p[0];
				
				}
	}
	
	
	
	public function modificar ($pass1,$pass2,$pass)
    {
		$npass1 = sha1(md5(trim($pass1)));
		$npass2 = sha1(md5(trim($pass2)));
		$npass = sha1(md5(trim($pass)));
				
		if ($this->pass != $npass) {
           	header("Location: cuenta.php?err=1");
			die();
		}
		if (!empty($pass1) and ($npass1 != $npass2)) {
			header("Location: cuenta.php?err=2");
			die();
		}
		
			$db = Db::getInstance();
			$data = array(
        	'nombre' => $this->username		
			);
		
		  if (!empty($pass1)) {
		    $data["pass"] = $npass1;
			  echo "cambia el pass por".$npass1." --";
		  }
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_registro', $data, 'id = :id', array(':id' => $this->id));
		header("Location: cuenta.php?act=OK");
	
	}
	
	
	public function getOut ()
    {
				
			
          				
							$clave00 = uniqid();
							setcookie("admin_jko","");
							setcookie("admin_idm","");
							setcookie("clave","");
							header("Location: index.php");
						
       			
		  
		
		
	
	}
	
	public function getUser($id,$clave) {
		
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_mesadedialogo WHERE clave = :clave AND id = :id";
    			$bind = array(
					':id' => $id,
					':clave' => $clave
    			);
		
				$cont = $db->run($sql, $bind);
		
		$cont = $db->run($sql, $bind);
		//echo "Contador:".$cont;
		
		if ($cont > 0){
			//echo "entra aqui";
			$db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			return $rowff1[0];
		  
			
		} else {
			//header("Location: login.php?err=1");
		}
		
    }
    
    public function validar_usuario ($id,$unique_id)
	{
		       
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_registro WHERE id = :id AND unique_id = :unique_id";
    				$bind = array(
                    ':id' => $id,
                    ':unique_id' => $unique_id
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				
				$this->contador = $cont;
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					  
					    
						$this->row = $row_p;
					    
					
				}
	}


	static function existeUsuario ($email)
	{
		       
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_registro WHERE email = :email LIMIT 1";
    				$bind = array(
                    ':email' => $email
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				
				//$this->contador = $cont;
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					    
						return $row_p[0];
					    
					
				}
	}

	static function existeUsuarioDNI ($dni)
	{
		      
		
		$dni = trim($dni);
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_registro WHERE dni = :dni LIMIT 1";
    				$bind = array(
                    ':dni' => $dni
    				);
					
				
		        
				$cont = $db->run($sql, $bind);
				
				//$this->contador = $cont;
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					    
						return $row_p[0];
					    
					
				}
	}

	static function getPrecio ($tipouser, $pais) {

		if ($pais != 19) {
			return 'precio1';
		}
		else if ($tipouser == 2) {
			return 'precio2';
		} else if ($tipouser == 3) {
			return 'precio3';
		} else {
			return 'precio';
		}

	}
		
}