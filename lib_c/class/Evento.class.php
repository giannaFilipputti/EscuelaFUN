<?php

class Evento
{
	public $id;
	public $categoria_esp;
	public $categoria_eng;
	public $proyecto;
	public $orden;


    public function __construct()
    {
       // echo "<p>Class X</p>";
	    $this->tabla = "com_eventos";
	
    }
	
	private function getOrden($tabla='com_eventos')
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
	
	public function registrarEvento ($titulo, $autor, $cargo, $fecha, $estado, $youtube)
    {
	   if (empty($titulo)) {
		   //header("Location: categorias_add.php");
		   return "err1";
	   } else {
			
			$db = Db::getInstance();
			$data = array(
				'cod_id' => uniqid(),
        	'titulo' => $titulo,
			'autor' => $autor,
			'cargo' => $cargo,
        	'fecha' => $fecha,
			'youtube' => $youtube,
			'activo' => $estado
			
		);
		
    	$db->insert('com_eventos', $data);
		
		$id = $db->lastInsertId();
		
		
		
		
		$friendly_url = "evento-".$id;
		$db = Null;
		$db = Db::getInstance();
			$data = array(
        	'friendly_url' => $friendly_url
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
		   
		   
		   
		   $contenido = "<a id=\"votar1\" class=\"votar1\"><i class=\"material-icons\">send</i> VOTAR</a>";
		   
		   $archivo = fopen("botones/boton_".$id.".php", "w");
			fwrite($archivo, $contenido);
			fclose($archivo);  		
		
		
	   }
		
    }
	
	public function activarEncuesta ($id, $encuesta)
    {
		
		$db = Null;
		$db = Db::getInstance();
			$data = array(
        	'encuesta' => $encuesta
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
		   
		   if ($encuesta == 1) {
			   
			   // "<a id=\"votar\" class=\"votar\"><i class=\"material-icons\">send</i> VER ENCUESTA</a>";
		   
		   $contenido = "
				  
				  
				  
				  <script>$(document).ready(function($)
    {
		

	
					var url = \"cargar_votacion.php?id=<?php echo $id;?>\";
					$.ajax({
                    type: \"POST\",
                    url: url,
                   
                    success: function(data)
                    {
                     
                     
                            $(\"#espacio_voto\").html(data);
							
							
                         
                                

                    }
                  });
				 
				  });</script>";
		    } else {
				$contenido = "<a id=\"votar1\" class=\"votar1\"><i class=\"material-icons\">send</i> ENCUESTA DESHABILITADA</a>
				
				<script>$(document).ready(function($)
    {
		

	
					var url = \"cargar_votacion_vacia.php?id=<?php echo $id;?>\";
					$.ajax({
                    type: \"POST\",
                    url: url,
                   
                    success: function(data)
                    {
                     
                     
                            $(\"#espacio_voto\").html(data);
							
							
                         
                                

                    }
                  });
				  });</script>
				  
				  ";
				}
		   
		   $archivo = fopen("botones/boton_".$id.".php", "w");
			fwrite($archivo, $contenido);
			fclose($archivo);
			
			
		
		}
	public function registrarMaterial ($titulo, $tipo, $descripcion, $url)
    {
	   if (empty($titulo)) {
		   //header("Location: categorias_add.php");
		   return "err1";
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'titulo' => $titulo,
			'tipo' => $tipo,
			'descripcion' => $descripcion,
			'url' => $url,
        	'fecha' => date('Y-m-d H:i:s')
			
		);
		
    	$db->insert('com_materiales', $data);
		
		$id = $db->lastInsertId();
		
		
		
		
	   }
		
	}
	
	public function estadoMaterial ($id, $estado)
    {			
			$db = Db::getInstance();
			$data = array(
        		'estado' => $estado			
			);
		   
		   $db->update('com_materiales', $data, 'id = :id', array(':id' => $id));


		  

   			//$this->modificarReunionAdmin($id, $email);
		
		
	
		
    }
	
	
	public function modificarEvento ($id, $titulo, $autor, $cargo, $fecha, $estado, $youtube, $facebook, $cod_facebook)
    {
	   if (empty($titulo)) {
		   //header("Location: categorias_add.php");
		   return "err1";
	   } else {
			
			
		
		$db = Null;
		$db = Db::getInstance();
			$data = array(
        	'titulo' => $titulo,
			'autor' => $autor,
			'cargo' => $cargo,
        	'fecha' => $fecha,
			'cod_youtube' => $youtube,
			'facebook' => $facebook,
			'cod_facebook' => $cod_facebook,
			'activo' => $estado
		);

		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
   		
		
		
	   }
		
    }
	
	public function modificarMaterial ($id, $titulo, $tipo, $descripcion, $url)
    {
	   if (empty($titulo)) {
		   //header("Location: categorias_add.php");
		   return "err1";
	   } else {
			
			
		
		$db = Null;
		$db = Db::getInstance();
			$data = array(
        	'titulo' => $titulo,
			'tipo' => $tipo,
			'descripcion' => $descripcion,
			'url' => $url,
		);

		   
		   $db->update('com_materiales', $data, 'id = :id', array(':id' => $id));
   		
		
		
	   }
		
    }


    public function contadorEventos() {
    	$db = Db::getInstance();

			$sql = "SELECT * FROM ".$this->tabla; 
					$sql .= " WHERE id > :id";
					$bind = array(
	        			':id' => '0'
	    			);	
	    

	    			$cont = $db->run($sql, $bind);

	    			return $cont;
	}
	
	
	public function getAll ($tipo = '', $limit = 1)
	{
				$db = Db::getInstance();
				$sql = "SELECT ".$this->tabla.".* FROM ".$this->tabla; 
				$sql .= " WHERE ".$this->tabla.".id > :id";
				$bind = array(
        		':id' => '0'
    			);				
				
				$date = new DateTime();
				$date->modify('-10 hours');;
				$lafechoa=  $date->format('Y-m-d H:i:s');
				
				//echo "Tipo".$tipo;
				if ($tipo == 'proximos') {
					$sql .= " AND ".$this->tabla.".fecha >= :fecha"; 
					$bind[':fecha'] = $lafechoa;
				} else if ($tipo == 'pasados') {
					$sql .= " AND ".$this->tabla.".fecha < :fecha"; 
					$bind[':fecha'] = $lafechoa;					
				}
				
				
				if ($limit == 0) {
					$limite = "";
					
				} else {
					$limite = " LIMIT ".$limit;
				} 
				
				
				if ($tipo == 'pasados') {
					$sql .= " ORDER BY fecha DESC ".$limite;
					
				} else {
					$sql .= " ORDER BY fecha ".$limite;
				}
								
				/*echo $sql;
				print_r($bind);
echo "<br><br>";	*/	
				
    			
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   return $row_p;
				}
	}
	
	
	
	public function getDestacados ($tipo = 'evento')
	{
				$db = Db::getInstance();
				$sql = "SELECT com_".$tipo.".* FROM com_".$tipo; 
				$sql .= " WHERE com_".$tipo.".id > :id AND destacado = 1";
				$bind = array(
        		':id' => '0'
    			);				
				
				
			
					$sql .= " ORDER BY fecha DESC LIMIT 1";
					
				
				/*echo $sql;
				print_r($bind);
echo "<br><br>";		*/	
				
    			
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				     return $row_p;
				}
	}
	
	
	public function getAllMaterial ($tipo = 0, $destacado = 0)
	{
				$db = Db::getInstance();
				$sql = "SELECT com_materiales.* FROM com_materiales"; 
				$sql .= " WHERE com_materiales.id > :id";
				$bind = array(
        		':id' => '0'
				);
				
				if ($tipo != 0) {
					$sql .= " AND com_materiales.tipo = :tipo";
					$bind[':tipo'] = $tipo ;
				}
				
				
				if ($destacado == 1) {
					$sql .= " AND com_materiales.destacado = :destacado";
					$bind[':destacado'] = "1";
				}
				
				
			
					$sql .= " ORDER BY fecha DESC";
					
				
				/*echo $sql;
				print_r($bind);
echo "<br><br>";		*/	
				
    			
		       //echo $sql;
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				     return $row_p;
				}
	}
	
	public function inscribir($evento, $usuario) {
		
		$check = Evento::verificarAsistencia($evento, $usuario);
		
		if ($check == 0) {
			$db = Db::getInstance();
			$data = array(
        	'evento' => $evento,
        	'usuario' => $usuario,
			'fecin' => date('Y-m-d H:i:s')
			
			);
			$db->insert('com_evento_registro', $data);
		}
		
		
		   
		
		
		
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					return $row_p;
				   
				}
	}

	public function getOnebyCod ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE cod_id = :id LIMIT 1";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					return $row_p;
				   
				}
	}
	
	
	public function getVoting ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_exam_preg WHERE webinar = :id LIMIT 1";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
				
				$respuesta = array();
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					
					$respuesta['pregunta'] = "";
					$respuesta['respuestas'] = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					//echo $row_p[0];
					$respuesta['pregunta'] = $row_p[0];
					$respuesta['respuestas'] = $this->getVotingResp($row_p[0]['id']);
				   
				}
				
				return $respuesta;
	}
	
	
	public function getRespuesta ($id, $alumno)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_alumnos_resp WHERE pregunta = :id AND alumno = :alumno LIMIT 1";
    			$bind = array(
					':id' => $id,
					':alumno' => $alumno
    			);
				
				/*echo $sql;
				print_r($bind);*/
				
				$respuesta = array();
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					//echo $row_p[0];
					return  $row_p[0]['respuesta'];
				   
				}
				
				return $respuesta;
	}
	
	
	public function getVotingResp ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_exam_resp WHERE pregunta = :id ORDER BY id";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
				
				$respuesta = array();
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					return $row_p;
					
				   
				}
	}
	
	public function votar ($alumno, $pregunta, $respuesta) {
		 $db = Db::getInstance();
			$data = array(
                            'pregunta' => $pregunta,
                            'alumno' => $alumno,
                            'respuesta' => $respuesta
                        );
                        
           
                
                $db->save('com_alumnos_resp', $data, "pregunta=:pregunta AND alumno = :alumno" , array('pregunta' => $pregunta, 'alumno' => $alumno));
                 
	}
	
	
	public function registrarPreguntaV($id, $pregunta, $preguntaid, $respuesta1, $respuesta2, $respuesta3, $respuesta4, $respuesta5, $respuesta6, $respuesta7, $respuesta1id, $respuesta2id, $respuesta3id, $respuesta4id, $respuesta5id, $respuesta6id, $respuesta7id) {
		
		if (empty($preguntaid)) {
				$db = Db::getInstance();
				$data = array(
				'webinar' => $id,
				'pregunta' => $pregunta
				
				);
				$db->insert('com_exam_preg', $data);
				$preguntaid = $db->lastInsertId();
			
			} else {
				
				$db = Db::getInstance();
				$data = array(
				'pregunta' => $pregunta
				);
			   
			   $db->update('com_exam_preg', $data, 'id = :id', array(':id' => $preguntaid));
				
			}
			
			for( $i= 1 ; $i <= 7 ; $i++ ) {
				$variable = "respuesta".$i;
				$variableid = "respuesta".$i."id";
				
					if (empty(${$variableid})) {
					$db = Db::getInstance();
					$data = array(
					'pregunta' => $preguntaid,
					'respuesta' => ${$variable}
					
					);
					$db->insert('com_exam_resp', $data);
					
				
					} else {
						
						$db = Null;
						$db = Db::getInstance();
						$data = array(
						'respuesta' => ${$variable}
						);
					   
					   $db->update('com_exam_preg', $data, 'id = :id', array(':id' => ${$variableid}));
						
					} 
				
				
				}
		
	}
	
	public function getMaterial ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_materiales WHERE id = :id LIMIT 1";
    			$bind = array(
					':id' => $id
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					return $row_p;
				   
				}
	}
	

	public function elimMaterial ($id) {
		$db = Db::getInstance();
        $db->delete("com_materiales", "id=:id", array(':id' => $id));
	} 
	public function actualizarFoto($valor,$id) {
        
        $db = Db::getInstance();
			$data = array(
                            'imagen' => $valor
                        );

		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
        
    }
	
	public function actualizarArchivo($valor,$id,$ext,$nombre) {
        
        $db = Db::getInstance();
			$data = array(
                            'nombre' => $nombre,
							'clave' => $valor,
							'ext' => $ext
                        );

		   
		   $db->update('com_materiales', $data, 'id = :id', array(':id' => $id));
        
    }
	
	public function actualizarFotoM($valor,$id) {
        
        $db = Db::getInstance();
			$data = array(
                            'imagen' => $valor
                        );

		   
		   $db->update('com_materiales', $data, 'id = :id', array(':id' => $id));
        
    }
	
	
	public function actualizarFotoG($valor,$id,$tipo) {
        
        $db = Db::getInstance();
			$data = array(
                            'imagen' => $valor
                        );

		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
        
    }

    public function actualizarFotoG1($valor,$id,$tipo) {
        
        $db = Db::getInstance();
			$data = array(
                            'imagen1' => $valor
                        );

		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
        
    }


    public function actualizarFotoG2($valor,$id,$tipo) {
        
        $db = Db::getInstance();
			$data = array(
                            'imagen2' => $valor
                        );

		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));
        
    }
	
	
	public function getOnebyURL ($evento,$proximos=0)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE friendly_url = :url";
    			$bind = array(
					':url' => $evento
    			);
				if ($proximos == 1) {
					$date = new DateTime();
					$date->modify('-6 hours');;
					$lafechoa=  $date->format('Y-m-d H:i:s');									
									//echo "Tipo".$tipo;
									if ($tipo == 'proximos') {
										$sql .= " AND fecha >= :fecha"; 
										$bind[':fecha'] = $lafechoa;
									}
					
				}
				
				$sql .= " LIMIT 1";
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$this->row = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$this->row = $row_p;
				   
				}
	}
	
	
	
	static function verificarAsistencia($evento, $user) {
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_evento_registro WHERE evento = :evento AND usuario = :user";
				$bind = array(
        		':evento' => $evento,
				':user' => $user
    			);
				
				/*echo $sql;
				print_r($bind);*/
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					
					//echo "no hay";
					return 0;
					
				} else {
					//echo "si hay";
					return 1;
				}
		
	}
	
	public function getRegistrados($evento) {
        
        $db = Db::getInstance();
				//$sql = "SELECT * FROM com_alumnos WHERE id > :id ORDER BY ape1";


        $sql = "SELECT com_alumnos.*, com_evento_registro.fecin AS Rfecin FROM com_alumnos INNER JOIN com_evento_registro ON com_evento_registro.usuario = com_alumnos.id WHERE com_evento_registro.evento = :id  ORDER BY com_evento_registro.fecin";
    			$bind = array(
					':id' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					//echo "encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
        
    }

    public function cerrarEvento ($id, $estado)
    {			
			$db = Db::getInstance();
			$data = array(
        		'cerrado' => $estado			
			);
		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));

   			//$this->modificarReunionAdmin($id, $email);
		
	}
	
	public function onlineEvento ($id, $estado)
    {			
			$db = Db::getInstance();
			$data = array(
        		'online' => $estado			
			);
		   
		   $db->update('com_eventos', $data, 'id = :id', array(':id' => $id));

   			//$this->modificarReunionAdmin($id, $email);
		
    }


    static function getRegistradosAcceso($evento,$usuario) {
        
        $db = Db::getInstance();
				//$sql = "SELECT * FROM com_alumnos WHERE id > :id ORDER BY ape1";


        $sql = "SELECT com_evento_acceso.fecha FROM com_evento_acceso WHERE com_evento_acceso.evento = :evento AND com_evento_acceso.usuario = :usuario ORDER BY com_evento_acceso.fecha LIMIT 1";
    			$bind = array(
					':evento' => $evento,
					':usuario' => $usuario
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					//echo "encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p[0]['fecha'];
				   
				}
        
    }



    static function checkAsistencia($evento,$usuario) {
        
        $db = Db::getInstance();
				$sql = "SELECT * FROM com_evento_registro WHERE evento = :evento AND usuario = :usuario LIMIT 1";
    			$bind = array(
					':evento' => $evento,
					':usuario' => $usuario
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "0";
				} else {
					return "1";
				   
				}
        
    }
	
	static function getProvincia($provincia,$pais) {
        
        $db = Db::getInstance();
				$sql = "SELECT provincia FROM com_provincias WHERE codigo = :codigo AND pais = :pais LIMIT 1";
    			$bind = array(
					':codigo' => $provincia,
					':pais' => $pais
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {

					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p[0]['provincia'];
				   
				}
        
    }
	
	static function verificarTipo($evento, $user) {
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_evento_registro WHERE evento = :evento AND usuario = :user";
				$bind = array(
        		':evento' => $evento,
				':user' => $user
    			);
				
				/*echo $sql;
				print_r($bind);*/
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					
					//echo "no hay";
					return 0;
					
				} else {
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					
					
					if ($row_p[0]['tipo'] == 0) {
						return 1;
					} else {
						return $row_p[0]['tipo'];
					}
					
				}
		
	}
	
	public function checkEncuesta ($evento) {
		
		$lacoo = $_COOKIE["encuesta_".$evento];
		if ($lacoo == 1) {
			return 1;
		} else {
			return 0;
		}
		
		
	}
	/*
	public function guardarEncuesta($p1, $p2, $p5, $p6, $alumno) {
 //echo $p1.", ".$p2.", ".$p5.", ".$p6;
					$db1 = null;
					$db1 = Db::getInstance();
					$data1 = array(
						'alumno' => $alumno,
        				'evento' => $this->row[0]['id'],
        				'p1' => $p1,
        				'p2' => $p2,
        				'p5' => $p5,
        				'p6' => $p6,
        				'fecha' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_evento_encuesta', $data1);
					
					setcookie("encuesta_".$this->row[0]['id'],'1',time() + 365 * 24 * 60 * 60);
					

	}*/


	public function guardarEncuesta($p1, $p2, $p3, $p4, $p6, $modulo) {

		$db1 = null;
		$db1 = Db::getInstance();
		$data1 = array(
			'alumno' => $this->alumno,
			'modulo' => $modulo,
			'p1' => $p1,
			'p2' => $p2,
			'p3' => $p3,
			'p4' => $p4,
			'p6' => $p6,
			'fecha' => date('Y-m-d H:i:s')
		);
		//print_r($data1);
		$db1->insert('com_encuesta_masterclass', $data1);

}


static function getEncuestaUser($modulo, $alumno) {

$db = Db::getInstance();
$sql = "SELECT * FROM com_encuesta_masterclass WHERE alumno = :alumno AND modulo = :modulo LIMIT 1";
$bind = array(
':alumno' => $alumno,
':modulo' => $modulo
);

$cont = $db->run($sql, $bind);
if ($cont == 0) {

return 0;
} else {

return 1;
}

}

	
	public function getRoles($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT rol FROM com_evento_rol WHERE evento = :evento";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$resultado = array();
					foreach($row_p as $row_p1) {
						$resultado[] = $row_p1['rol'];
					}					
					return $resultado;
				   
				}
		
	}
	
	public function getDisciplinas($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT disciplina FROM com_evento_disciplina WHERE evento = :evento";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$resultado = array();
					foreach($row_p as $row_p1) {
						$resultado[] = $row_p1['disciplina'];
					}					
					return $resultado;
				   
				}
		
	}
	
		public function registrarEntrada($evento,$user,$ip) {
			
			
			$db1 = null;
					$db1 = Db::getInstance();
					$data1 = array(
						'usuario' => $user,
        				'evento' => $evento,
        				'ip' => $ip,
        				'fecha' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_evento_acceso', $data1);
					
					
		
		$db = Db::getInstance();
			$data = array(
        	'entrada' => '1'
		);
		   
		   $db->update('com_evento_registro', $data, 'evento = :evento AND usuario= :usuario', array(':evento' => $evento,':usuario' => $user));
		   
		
	}
	
	
	public function registrarPregunta($evento,$user,$ip,$pregunta) {
			
			
			$db1 = null;
					$db1 = Db::getInstance();
					$data1 = array(
						'evento' => $evento,
						'usuario' => $user,
						'pregunta' => $pregunta,
        				'fecha' => date('Y-m-d H:i:s'),        				
        				'ip' => $ip
					);
					//print_r($data1);
    				$db1->insert('com_preguntas_webinar', $data1);
					
					
		
		
		
	}

	public function registrarPreguntaVideo($evento,$user,$ip,$pregunta) {
			
			
		$db1 = null;
				$db1 = Db::getInstance();
				$data1 = array(
					'evento' => $evento,
					'usuario' => $user,
					'pregunta' => $pregunta,
					'fecha' => date('Y-m-d H:i:s'),        				
					'ip' => $ip
				);
				//print_r($data1);
				$db1->insert('com_preguntas_video', $data1);		
	
	
	
}
	
	
	public function getPregunta($evento,$usuario) {
		
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_preguntas_webinar WHERE evento = :evento and usuario = :usuario ORDER BY fecha DESC";
    			$bind = array(
					':evento' => $evento,
					':usuario' => $usuario
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					//echo "encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
		
	}


	public function getPreguntaVideo($evento,$usuario) {
		
		$db = Db::getInstance();
				$sql = "SELECT * FROM com_preguntas_video WHERE evento = :evento and usuario = :usuario ORDER BY fecha DESC";
    			$bind = array(
					':evento' => $evento,
					':usuario' => $usuario
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					//echo "encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
		
	}
	
	
	public function getPreguntaPonente($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT com_preguntas_webinar.*, com_alumnos.nombre, com_alumnos.ape1 FROM com_preguntas_webinar LEFT JOIN com_alumnos ON com_preguntas.usuario = com_alumnos.id WHERE com_preguntas.evento = :evento ORDER BY com_preguntas.fecha DESC";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					//echo "encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
		
	}
	public function getPreguntaPonenteFav($evento) {
		
		$db = Db::getInstance();
				$sql = "SELECT com_preguntas_webinar.*, com_alumnos.nombre, com_alumnos.ape1 FROM com_preguntas_webinar LEFT JOIN com_alumnos ON com_preguntas_webinar.usuario = com_alumnos.id WHERE com_preguntas_webinar.evento = :evento AND com_preguntas_webinar.favorito = 1 ORDER BY com_preguntas_webinar.fecha DESC";
    			$bind = array(
					':evento' => $evento
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					//echo "encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p;
				   
				}
		
	}

	static function getEspecialidad($especialidad) {
        
        $db = Db::getInstance();
				$sql = "SELECT especialidad FROM com_especialidades WHERE id = :id LIMIT 1";
    			$bind = array(
					':id' => $especialidad
    			);
				
				/*echo $sql;
				print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {

					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
									
					return $row_p[0]['especialidad'];
				   
				}
        
    }
	public function changeFav($id, $fav) {
        
        $db = Db::getInstance();
			$data = array(
                            'favorito' => $fav
                        );

		   
		   $db->update('com_preguntas_webinar', $data, 'id = :id', array(':id' => $id));
        
    }
		
		
		
}