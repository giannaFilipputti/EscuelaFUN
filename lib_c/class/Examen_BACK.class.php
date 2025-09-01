<?php
class Examen
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;
	public $capitulo;
	public $forzar_cierre = 0;
	public $duracion;

	public $estado;
	public $row;
	public $preg;

	public $modulo;
	public $pagina;
	public $pag = 1;
	public $limit = 40;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_exam_preg";
	
    }
	

		
	public function agregar ()
    {
	   if (empty($this->marca)) {
		   header("Location: modulos_add.php");
	   } else {
			
			$db = Db::getInstance();
			$data = array(
        	'marca' => $this->marca
		);
    	$db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
		
		//header("Location: modulos_up.php?id=".$this->id);
		   header("Location: modulos.php");
	   }
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: modulos.php");
	   }
		else if (empty($this->marca)) {
		   header("Location: modulos_mod.php?id=".$this->id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'marca' => $this->marca
        			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: modulos.php");
	   }
		
    }
	

	
	public function getAll ($capitulo)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." WHERE id > :id";
    				$bind = array(
        			':id' => '0'
    				);


    				if (!empty($capitulo)) {
					 	$sql .= " AND capitulo = :capitulo";
					 	$bind[":capitulo"] = $capitulo;

					 }

				
					
				
					$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = "orden";
    				} else {
    					$orden = $this->orden;
    				}
    				

    				if ($this->tiporden == 'desc') {
    					$tiporden = " desc";
    				} else {
    					$tiporden = "";
    				}

    				$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 
				
				
    				//echo $sql;

		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					
				   $this->hayelemen = $cont;
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  $longitud = count($row_p);
					for($i=0; $i<$longitud; $i++) {

					    //echo $row_p1['nombre'] ;
						$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'],1);
					   
				
						$conty++;
					}
					//$this->row_p = $row_p;
					$this->row = $row_p;
				}
	}

	public function reiniciarExam() {
		$ex_estado = $this->getEstado();
                //echo "<br>estado:".$ex_estado;
		if ($ex_estado == 2) {
			$this->iniciarExamen();
		}

	} 

	public function iniciarExamen() {
		$db1 = Db::getInstance();
					$data1 = array(
        				'alumno' => $this->alumno,
        				'modulo' => $this->modulo,
        				'fecini' => date('Y-m-d H:i:s')
					);
					//print_r($data1);
    				$db1->insert('com_alumnos_exam', $data1);
    				$this->id = $db1->lastInsertId();
	}
	public function checkPlazo() {

				$mod = new Modulo();
				$mod->alumno = $this->alumno;
				$mod->getOne($this->modulo);
				$acred_hasta = $mod->row[0]['acred_hasta']. " 23:59:59";
			
				
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_alumnos_modulo WHERE alumno = :alumno AND modulo = :modulo LIMIT 1";
    			$bind = array(
					':alumno' => $this->alumno,
					':modulo' => $this->modulo
    			);

				/*echo $sql;
				print_r($bind);*/
                        
                  
				$cont = $db->run($sql, $bind);
				

				if ($cont == 0) {
										
					$mod->registrarAcceso();
					$duracion_alum_mod = strtotime(date('Y-m-d H:i:s')."+ 90 days");	
					
				} else {		
					

					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					//$fecha = $row_p[0]['fecin'];
					$duracion_alum_mod = strtotime($row_p[0]['fecin']."+ 90 days");	

				}
				
					//$duracion_alum_mod = strtotime(date('Y-m-d H:i:s')."+ 90 days");

					$mod_date = date("Y-m-d H:i:s", $duracion_alum_mod);
                                        
                                      // echo $mod_date."<br>";
                                         
					if ($acred_hasta < $mod_date) {
						$fec_alum_mod = $acred_hasta;
					} else {
						$fec_alum_mod = $mod_date;
					}
                                      /* echo $acred_hasta ." < ". $mod_date;
                                        echo "<br>".$fec_alum_mod;*/

					$datetime1 = new DateTime($fec_alum_mod);
					$datetime2 = new DateTime(date('Y-m-d H:i:s'));
					$interval = $datetime1->diff($datetime2);
                                        
                                        /*echo $interval->format('%R')."<br>";
                                        echo $interval->format('%a');*/
                                        
					if ($interval->format('%R') == '-') {
						$duracion = $interval->format('%a');
					} else {
						$duracion = '-';
					}

                                        //echo $duracion;
                                                
					if ($duracion == '-') {
						$this->forzar_cierre = 1;
						$this->cerrarExam();
						return 1;
						
					} else {
						$this->duracion = $duracion;
						return 0;
					}
				
	}

	public function cerrarExam($id=0) {
				$nota = 0;
				$db = null;
				$db = Db::getInstance();
				$bind = array(
        		':alumno' => $this->alumno,
        		':modulo' => $this->modulo
    			);
				if ($id == 0) {
					$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno AND estado = 0 ORDER BY fecini DESC LIMIT 1";
				} else {
					$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno AND estado = 0 AND id = :id ORDER BY fecini DESC LIMIT 1";
					$bind[":id"] = $id;
				}

				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {

					$db1 = null;
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);

					foreach($row_p as $row_p1) {
						$db_preg = null;
						$db_preg = Db::getInstance();
					  	$sql_preg = "SELECT * FROM com_exam_preg WHERE modulo=:modulo";
					  	$bind_preg = array(
        					':modulo' => $this->modulo
    					);
    					if ($db_preg->run($sql_preg, $bind_preg) > 0) {
    						
    						$db_preg1 = null;
    						$db_preg1 = Db::getInstance();
							$row_preg = $db_preg1->fetchAll($sql_preg, $bind_preg);


							foreach($row_preg as $row_men3) {
								$db_resp = null;
								$db_resp = Db::getInstance();
							  	//$sql_resp = "SELECT * FROM com_exam_preg WHERE modulo=:modulo";
							  	$sql_resp = "SELECT * FROM com_alumnos_resp WHERE pregunta=:pregunta AND alumno = :alumno AND id_exam_mod = :id_exam_mod";
							  	$bind_resp = array(
							  		':pregunta' => $row_men3['id'],
							  		':alumno' => $this->alumno,
							  		':id_exam_mod' => $row_p1['id']
		    					);
		    					if ($db_resp->run($sql_resp, $bind_resp) > 0) {
		    						$db_resp1 = null;
		    						$db_resp1 = Db::getInstance();
									$row_resp = $db_resp1->fetchAll($sql_resp, $bind_resp);

									foreach($row_resp as $row_men4) {
										$nota = $nota + $row_men4['correcta']; 
									}

								}

							}
									
						}

						//
						$mod = new Modulo();
						$mod->alumno = $this->alumno;
						$mod->getOne($this->modulo);
						if ($mod->row[0]['preg_aprob'] <= $nota) {
			   				$aprobado = 1;
			   				$this->aprobado = 1;
			   			} else {
				 			$aprobado = 0;  
				 			$this->aprobado = 0;
				   		}
				   		$db_up = null;
				   		$db_up = Db::getInstance();
						$data_up = array(
        					'nota' => $nota,
        					'aprobado' => $aprobado,
        					'estado' => '1',
        					'fecfin'=> date('Y-m-d H:i:s'),
        					'forzar_cierre' => $this->forzar_cierre        			
						);
		   
		   				$db_up->update('com_alumnos_exam', $data_up, 'id = :id', array(':id' => $row_p1['id']));

			   
			   // finalizamos el modulo

					}

				}
				

	}

	public function getEstado() {

				$this->aprobado= 0;

				$db = Db::getInstance();
				$bind = array(
        		':alumno' => $this->alumno,
        		':modulo' => $this->modulo
    			);
				
				$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno ORDER BY fecini DESC";
				

				$cont = $db->run($sql, $bind);

				if ($cont == 0) {
					$this->iniciarExamen();
					return  1;
				} else { 
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					$this->id = $row_p[0]['id'];
                                        /*print_r($row_p);
                                        echo "<br>aprobado: ".$row_p[0]['aprobado'];*/

					if ($row_p[0]['estado'] == 0) {						
						return  1;
					} else if ($cont == 1 && $row_p[0]['estado'] == 1) {
						if ($row_p[0]['aprobado'] == 1) {
							$this->aprobado = 1;
							$this->fecFin = $row_p[0]['fecfin'];
							return $this->respondioEncuesta();
						} else {
							return 2;
						}
					} else if ($cont > 1 && $row_p[0]['estado'] == 1) {
						$this->id = $row_p[0]['id'];
						$this->fecFin = $row_p[0]['fecfin'];
						if ($row_p[0]['aprobado'] == 1) {
							$this->aprobado = 1;
						}
						return $this->respondioEncuesta();

					} 
				}


	}

	public function respondioEncuesta(){
				$db = Db::getInstance();
				$bind = array(
        		':alumno' => $this->alumno,
        		':modulo' => $this->modulo
    			);
				
				$sql = "SELECT * FROM com_encuesta WHERE modulo=:modulo AND alumno = :alumno LIMIT 1";
				

				$cont = $db->run($sql, $bind);

				if ($cont == 0) {
					return 3;
				} else {
					return 4;
				}

	}

	

	public function getExam ($capitulo)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." WHERE id > :id";
    				$bind = array(
        			':id' => '0'
    				);


    				if (!empty($capitulo)) {
					 	$sql .= " AND capitulo = :capitulo";
					 	$bind[":capitulo"] = $capitulo;

					 }

				
					
				
					$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = "orden";
    				} else {
    					$orden = $this->orden;
    				}
    				

    				if ($this->tiporden == 'desc') {
    					$tiporden = " desc";
    				} else {
    					$tiporden = "";
    				}

    				$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 
				
				
    				//echo $sql;

		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					
				   $this->hayelemen = $cont;
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  $longitud = count($row_p);
					for($i=0; $i<$longitud; $i++) {

					    //echo $row_p1['nombre'] ;
						$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'],1);
					   
				
						$conty++;
					}
					//$this->row_p = $row_p;
					$this->row = $row_p;
				}
	}


	public function getPreg ($result = 0)
	{
		      
				$db = Db::getInstance();
		         	$bind = array(
        				':modulo' => $this->modulo
    				);
					$sql = "SELECT com_exam_preg.*, com_cursos_mod_cap.caso AS cap_caso, com_cursos_mod_cap.titulo AS cap_titulo, com_capitulo_contenidos.titulo AS pagina_titulo, com_capitulo_contenidos.subtitulo AS pagina_subtitulo  FROM com_exam_preg"
                                                . " LEFT JOIN com_cursos_mod_cap ON com_exam_preg.capitulo = com_cursos_mod_cap.id"
                                                . " LEFT JOIN com_capitulo_contenidos ON com_exam_preg.pagina = com_capitulo_contenidos.id"
                                                . " WHERE com_exam_preg.modulo = :modulo";
					if ($result == 0) {
						$sql .= " AND com_exam_preg.capitulo = :capitulo";
						$bind[":capitulo"] = $this->capitulo;
                                                $sql .= " ORDER BY num";
                                        } else {
                                                $sql .= " ORDER BY com_cursos_mod_cap.orden, com_capitulo_contenidos.orden, com_exam_preg.num";
                                        }
					
    				
                                               /* echo $sql;
                                                print_r($bind);*/
				
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					
		
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  $longitud = count($row_p);
					for($i=0; $i<$longitud; $i++) {

						// leemos todas las respuestas posibles
						$dbp0 = Db::getInstance();
						$sqlp0 = "SELECT * FROM com_exam_resp WHERE pregunta = :pregunta ORDER BY respuesta";
    					$bindp0 = array(
        					':pregunta' => $row_p[$i]['id']
    					);
    					$contp0 = $dbp0->run($sqlp0, $bindp0);
    					if ($contp0 == 0) {
							//$row_p[$i]['alumn_resp'] = "";
						} else {
							$dbp10 = null;
							$dbp10 = Db::getInstance();
							$row_p10 = $dbp10->fetchAll($sqlp0, $bindp0);

							foreach($row_p10 as $row_p101) {
					  			$row_p[$i]['respuestas'][$row_p101['id']] = $row_p101['respuesta'];
					  			$row_p[$i]['resp_corr'][$row_p101['id']] = $row_p101['correcta'];		
							}
							
						}


						// leemos la respuesta que dio el usuario
						
						$dbp = null;
						$dbp = Db::getInstance();
						$sqlp = "SELECT * FROM com_alumnos_resp WHERE pregunta = :pregunta AND alumno = :alumno AND id_exam_mod = :id_exam_mod";
    					$bindp = array(
        					':pregunta' => $row_p[$i]['id'],
        					':alumno' => $this->alumno,
        					':id_exam_mod' => $this->id
    					);
    					$contp = $dbp->run($sqlp, $bindp);
    					if ($contp == 0) {
							$row_p[$i]['alumn_resp'] = "";
						} else {
							$dbp1 = null;
							$dbp1 = Db::getInstance();
							$row_p1 = $dbp1->fetchAll($sqlp, $bindp);
							$row_p[$i]['alumn_resp'] = $row_p1[0]["respuesta"];
                            $row_p[$i]['alum_correc'] = $row_p1[0]["correcta"];
						}

						// terminamos de leer la respuesta del usuario



					    
				
						$conty++;
					}
					//$this->row_p = $row_p;
					$this->preg = $row_p;
				}
	}

	public function guardarResp($preg, $resp) {
		$db = null;
		$db = Db::getInstance();
		     
					$sql = "SELECT * FROM com_alumnos_resp WHERE id_exam_mod = :id_exam_mod AND pregunta = :pregunta AND alumno = :alumno LIMIT 1";
    				$bind = array(
        			':id_exam_mod' => $this->id,
        			':pregunta' => $preg,
        			':alumno' => $this->alumno
    				);

				
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$db3 = null;
					$db3 = Db::getInstance();
						$data3 = array(
        					'id_exam_mod' => $this->id,
        					'pregunta' => $preg,
        					'alumno' => $this->alumno,
        					'respuesta' => $resp,
        					'correcta' => $this->getRespRes($resp),
        					'fecha' => date('Y-m-d H:i:s')
						);
    					$db3->insert('com_alumnos_resp', $data3);
					
				} else {
					$db5 = null;
					$db5 = Db::getInstance();
					$row_a5 = $db5->fetchAll($sql, $bind);
					$id_resp = $row_a5[0]['id'];

					$db6 = null;
					$db6 = Db::getInstance();
						$data6 = array(
        					'id_exam_mod' => $this->id,
        					'pregunta' => $preg,
        					'alumno' => $this->alumno,
        					'respuesta' => $resp,
        					'correcta' => $this->getRespRes($resp),
        					'fecha' => date('Y-m-d H:i:s')
						);
    					//$db->insert('com_alumnos_diapos', $data);
    					$db6->update('com_alumnos_resp', $data6, 'id = :id', array(':id' => $id_resp));


				}

	}

	private function getRespRes($resp) {
		$db = null;
		$db = Db::getInstance();
					$sql = "SELECT * FROM com_exam_resp WHERE id = :id LIMIT 1";
    				$bind = array(
        			':id' => $resp
    				);

				
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return 0;
				} else {
					$db8 = null;
					$db8 = Db::getInstance();
					$row_a = $db8->fetchAll($sql, $bind);
					return $row_a[0]['correcta'];

				}

	}

	public function actualizarExam() {
						$dbp0 = null;
						$dbp0 = Db::getInstance();
						$sqlp0 = "SELECT * FROM com_exam_preg WHERE modulo = :modulo ORDER BY id";
    					$bindp0 = array(
        					':modulo' => $this->modulo
    					);
    					$contp0 = $dbp0->run($sqlp0, $bindp0);

    					$db = null;
						$db = Db::getInstance();
		     

						$sql = "SELECT com_alumnos_resp.* FROM com_alumnos_resp
						LEFT JOIN com_exam_preg ON com_exam_preg.id = com_alumnos_resp.pregunta
						 WHERE com_alumnos_resp.id_exam_mod = :id_exam_mod AND com_alumnos_resp.alumno = :alumno AND com_exam_preg.modulo = :modulo";
	    				$bind = array(
	        			':id_exam_mod' => $this->id,
	        			':alumno' => $this->alumno,
	        			':modulo' => $this->modulo
	    				);
		
		        
						$cont = $db->run($sql, $bind);
                                                //echo "preguntas contestadas:".$cont ."== totales". $contp0;
						if ($cont == $contp0) {
							//echo "ya contesto todas las preguntas";
							$this->cerrarExam($this->id);
							$this->estadoExamen = 1;
						} else {
							//echo "son: ".$contp0." y contesto: ".$cont."<br>";
							$this->preguntasTotales = $contp0;
							$this->preguntasRespondidas = $cont;
							$this->estadoExamen = 0;
						}



	}
        
      
        



        static function estadoExamenPag($modulo, $pagina, $alumno) {
						$db = null;
						$db = Db::getInstance();
						$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno ORDER BY fecini DESC LIMIT 1";

						$bind = array(
        					':modulo' => $modulo,
        					':alumno' => $alumno
    					);
						

						$cont = $db->run($sql, $bind);
						if ($cont == 0) {
							return 0;
						} else {
							$db1 = Db::getInstance();
							$row_p = $db1->fetchAll($sql, $bind);
							$id_exam = $row_p[0]['id'];



								$dbp0 = null;
								$dbp0 = Db::getInstance();
								$sqlp0 = "SELECT * FROM com_exam_preg WHERE modulo = :modulo AND pagina = :pagina ORDER BY id";
		    					$bindp0 = array(
		        					':modulo' => $modulo,
		        					':pagina' => $pagina
		    					);
		    					$contp0 = $dbp0->run($sqlp0, $bindp0);

		    					$db6 = null;
								$db6 = Db::getInstance();
				     

								$sql6 = "SELECT com_alumnos_resp.* FROM com_alumnos_resp
								LEFT JOIN com_exam_preg ON com_exam_preg.id = com_alumnos_resp.pregunta
								 WHERE com_alumnos_resp.id_exam_mod = :id_exam_mod AND com_alumnos_resp.alumno = :alumno AND com_exam_preg.modulo = :modulo AND com_exam_preg.pagina = :pagina";
			    				$bind6 = array(
			        			':id_exam_mod' => $id_exam,
			        			':alumno' => $alumno,
			        			':modulo' => $modulo,
		        				':pagina' => $pagina
			    				);
                                                       /*echo $sql6;
                                                        print_r($bind6);*/
                                                        
								$cont6 = $db6->run($sql6, $bind6);
                                                                
                                                             // echo $cont6."-".$contp0."<br>";

								if ($cont6 == $contp0) {
									return 1;
								} else {
									return 0;

								}
						}
					
					

	}

	static function estadoExamenCap($modulo, $capitulo, $alumno) {
		$db = null;
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno ORDER BY fecini DESC LIMIT 1";

		$bind = array(
			':modulo' => $modulo,
			':alumno' => $alumno
		);
		

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return 0;
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$id_exam = $row_p[0]['id'];



				$dbp0 = null;
				$dbp0 = Db::getInstance();
				$sqlp0 = "SELECT * FROM com_exam_preg WHERE modulo = :modulo AND capitulo = :capitulo ORDER BY id";
				$bindp0 = array(
					':modulo' => $modulo,
					':capitulo' => $capitulo
				);
				$contp0 = $dbp0->run($sqlp0, $bindp0);

				$db6 = null;
				$db6 = Db::getInstance();
	 

				$sql6 = "SELECT com_alumnos_resp.* FROM com_alumnos_resp
				LEFT JOIN com_exam_preg ON com_exam_preg.id = com_alumnos_resp.pregunta
				 WHERE com_alumnos_resp.id_exam_mod = :id_exam_mod AND com_alumnos_resp.alumno = :alumno AND com_exam_preg.modulo = :modulo AND com_exam_preg.capitulo = :capitulo";
				$bind6 = array(
				':id_exam_mod' => $id_exam,
				':alumno' => $alumno,
				':modulo' => $modulo,
				':capitulo' => $capitulo
				);
									   /*echo $sql6;
										print_r($bind6);*/
										
				$cont6 = $db6->run($sql6, $bind6);
												
										//	 echo $cont6."-".$contp0."<br>";

				if ($cont6 == $contp0) {
					return 1;
				} else {
					return 0;

				}
		}
	
	

}

	public function porcentajeAlumno($id,$salida=0) {

			$sql = "SELECT id FROM com_ponencias_ima";
		 	$sql .= " WHERE ponencia = :ponencia";
		 					
						$bind = array(
        					':ponencia' => $id
    					);
    		$sql .= " ORDER BY orden";
    		$db = Db::getInstance();
			$cont = $db->run($sql, $bind);

			$sql1 = "SELECT id FROM com_alumnos_diapos";
		 	$sql1 .= " WHERE pagina = :pagina AND alumno = :alumno AND NOT (diapo <=> NULL)";
		 					
						$bind1 = array(
        					':pagina' => $id,
        					':alumno' => $this->alumno
    					);
    		$db1 = Db::getInstance();
			$cont1 = $db1->run($sql1, $bind1);
			$porcentaje = ($cont1 * 100) / $cont;
			if ($salida==0) {
				$this->porcentaje = $porcentaje;
			} else {
				return round($porcentaje);
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

	public function descargaDiploma() {

		$db = Db::getInstance();
			$data = array(
        	'desc_diploma' => '1'
        			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_alumnos_exam', $data, 'id = :id AND alumno = :alumno', array(':id' => $this->id, ':alumno' => $this->alumno));

	}



	
	
	
	
		
}