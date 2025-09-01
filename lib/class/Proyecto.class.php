<?php
class Proyecto
{
	public $id;
	public $titulo_esp;
	public $titulo_eng;
	public $cliente;
	public $desc_esp;
	public $objetivos_esp;
	public $carc_esp;
	public $kpi_esp;
	public $desc_eng;
	public $objetivos_eng;
	public $carac_eng;
	public $kpi_eng;
	public $video1;
	public $orden;
	public $orden_lastimg;
	public $estado;
	public $destacado;
	public $img_ppl;
	public $img_gal;
	public $gal_tx_esp;
	public $gal_tx_eng;
	public $videoid;
	public $video;
	public $opiid;
	public $opi_esp;
	public $opi_eng;
	public $opiuser;
	public $opiuser_cargo;
	public $opiuser_img;
	public $video_imagen;
	public $cnt_img_ppl;
	public $cnt_img_gal;
	public $categorias = array();
	public $tipo_galeria;
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
	
    }
	
	private function getOrden($tabla='com_proyectos')
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
	   if (empty($this->titulo_esp)) {
		   header("Location: proyectos_add.php");
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'titulo_esp' => $this->titulo_esp,
        	'titulo_eng' => $this->titulo_eng,
        	'cliente' => $this->cliente,
        	'desc_esp' => $this->desc_esp,
        	'objetivos_esp' => $this->objetivos_esp,
        	'carac_esp' => $this->carac_esp,
        	'kpi_esp' => $this->kpi_esp,
			'desc_eng' => $this->desc_eng,
        	'objetivos_eng' => $this->objetivos_eng,
        	'carac_eng' => $this->carac_eng,
        	'kpi_eng' => $this->kpi_eng,
			'video' => $this->video1,
			'orden' => $this->orden,
        	'fecin' => date('Y-m-d H:i:s'),
			'destacado' => $this->destacado			
		);
    	$db->insert('com_proyectos', $data);
		$this->id = $db->lastInsertId();
		header("Location: proyectos_up.php?id=".$this->id);
	   }
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: proyectos.php");
	   }
		else if (empty($this->titulo_esp)) {
		   header("Location: proyectos_mod.php?id=".$this->id);
	   } else {
			$this->orden = $this->getOrden();
			$db = Db::getInstance();
			$data = array(
        	'titulo_esp' => $this->titulo_esp,
        	'titulo_eng' => $this->titulo_eng,
        	'cliente' => $this->cliente,
        	'desc_esp' => $this->desc_esp,
        	'objetivos_esp' => $this->objetivos_esp,
        	'carac_esp' => $this->carac_esp,
        	'kpi_esp' => $this->kpi_esp,
			'desc_eng' => $this->desc_eng,
        	'objetivos_eng' => $this->objetivos_eng,
        	'carac_eng' => $this->carac_eng,
        	'kpi_eng' => $this->kpi_eng,
			'video' => $this->video1,
			'destacado' => $this->destacado			
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_proyectos', $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: proyectos.php");
	   }
		
    }
	

	
	public function getAll ($tipo = "")
	{
		        if ($this->interfaz==1) {
					$sqlag = " AND estado = 1";
				}
		        else {
					$sqlag = "";
				}
				$db = Db::getInstance();
		        if ($tipo == 'destacados') {
					$sql = "SELECT * FROM com_proyectos WHERE id > :id AND destacado = 1".$sqlag." ORDER BY orden DESC";
    				$bind = array(
        			':id' => '0'
    				);
				} else {
					$sql = "SELECT * FROM com_proyectos WHERE id > :id".$sqlag." ORDER BY orden DESC";
    				$bind = array(
        			':id' => '0'
    				);
					
				}
				
		        
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
						$this->cliente[$conty]=$row_p1['cliente'] ;
						$this->desc_esp[$conty]=$row_p1['desc_esp'] ;
						$this->objetivos_esp[$conty]=$row_p1['objetivos_esp'] ;
					    $this->carac_esp[$conty]=$row_p1['carac_esp'];
						$this->kpi_esp[$conty]=$row_p1['kpi_esp'] ;
						$this->desc_eng[$conty]=$row_p1['desc_eng'] ;
						$this->objetivos_eng[$conty]=$row_p1['objetivos_eng'] ;
					    $this->carac_eng[$conty]=$row_p1['carac_eng'];
						$this->kpi_eng[$conty]=$row_p1['kpi_eng'] ;
					    $this->video1[$conty]=$row_p1['video'] ;
						$this->orden[$conty]=$row_p1['orden'] ;
						$this->estado[$conty]=$row_p1['estado'] ;
						$this->destacado[$conty]=$row_p1['destacado'] ;
					    $this->tipo_galeria[$conty]=$row_p1['tipo_galeria'] ;
					    
					   // imagenes del proyecto 
					   
					   $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT * FROM com_proyectos_img WHERE proyecto = :id1 ORDER BY tipo, orden DESC";
    					$bind2 = array(
        					':id1' => $this->id[$conty]
    					);
					   
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_img = "";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_img = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_img as $row_img1) {	
						  
							if ($row_img1['tipo']==0) {
								$this->img_ppl[$conty]=$row_img1['clave'];
								$this->cont_img_ppl[$conty]=1;
							} else {
								
								$this->img_gal[$conty][$cont]=$row_img1['clave'];
								$this->gal_tx_esp[$conty][$cont]=$row_img1['titulo_esp'];
								$this->gal_tx_eng[$conty][$cont]=$row_img1['titulo_eng'];
								$this->cont_img_gal[$conty]=$cont;
								$cont ++;
							}
						   
						   }
					 }
					   
					   // los videos del proyecto
					   
					   $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT * FROM com_proyectos_videos WHERE proyecto = :id1 ORDER BY orden DESC";
    					$bind2 = array(
        					':id1' => $this->id[$conty]
    					);
					   
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_video = "";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_video = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_video as $row_img1) {	
						  
							
								
								$this->videoid[$conty][$cont]=$row_img1['id'];
						         $this->video[$conty][$cont]=$row_img1['video'];
								$this->video_img[$conty][$cont]=$row_img1['imagen'];
								$cont ++;
							
						   
						   }
					 }

					 // las opiniones del proyecto

					  $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT com_proyectos_equipo.id, com_proyectos_equipo.comentario_esp, com_proyectos_equipo.comentario_eng, com_equipo.nombre, com_equipo.cargo, com_equipo.imagen FROM com_proyectos_equipo INNER JOIN com_equipo ON com_proyectos_equipo.equipo = com_equipo.id WHERE com_proyectos_equipo.proyecto = :id1   ORDER BY com_proyectos_equipo.orden DESC";
    					$bind2 = array(
        					':id1' => $this->id[$conty]
    					);
					   
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_video = "";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_equipo = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_equipo as $row_img1) {	
						  
							
								 $this->opiid[$conty][$cont]=$row_img1['id'];
								 $this->opi_esp[$conty][$cont]=$row_img1['comentario_esp'];
								 $this->opi_eng[$conty][$cont]=$row_img1['comentario_eng'];
						         $this->opiuser[$conty][$cont]=$row_img1['nombre'];
						         $this->opiuser_cargo[$conty][$cont]=$row_img1['cargo'];
						         $this->opiuser_img[$conty][$cont]=$row_img1['imagen'];
								$cont ++;
							
						   
						   }
					 }

					   
					   // las categorias
					   $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT * FROM com_proyectos_categorias WHERE proyecto = :id1";
    					$bind2 = array(
        					':id1' => $this->id[$conty]
    					);
					   
					   //echo $this->id[$conty];
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_img = "";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_img = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_img as $row_img1) {	
						  
							
								
								$this->categorias[$conty][$cont]=$row_img1['categoria'];
								$cont ++;
							
						   
						   }
					 }
					   
					   // lascategorias
						$conty++;
					}
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_proyectos WHERE id = :id LIMIT 1";
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
						$this->cliente=$row_p1['cliente'] ;
						$this->desc_esp=$row_p1['desc_esp'] ;
						$this->objetivos_esp=$row_p1['objetivos_esp'] ;
					    $this->carac_esp=$row_p1['carac_esp'];
						$this->kpi_esp=$row_p1['kpi_esp'] ;
						$this->desc_eng=$row_p1['desc_eng'] ;
						$this->objetivos_eng=$row_p1['objetivos_eng'] ;
					    $this->carac_eng=$row_p1['carac_eng'];
						$this->kpi_eng=$row_p1['kpi_eng'] ;
					    $this->video1=$row_p1['video'] ;
						$this->orden=$row_p1['orden'] ;
						$this->estado=$row_p1['estado'] ;
						$this->destacado=$row_p1['destacado'] ;
					    $this->tipo_galeria=$row_p1['tipo_galeria'] ;
					   
					    $db2 = Db::getInstance();
						$sql2 = "SELECT * FROM com_proyectos_img WHERE proyecto = :id ORDER BY tipo, orden DESC";
    					$bind2 = array(
        					':id' => $id
    					);
					   $row_img = $db2->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_img as $row_img1) {	
						  
							if ($row_img1['tipo']==0) {
								$this->img_ppl=$row_img1['clave'];
								$this->cont_img_ppl=1;
							} else {
								
								$this->img_gal[$cont]=$row_img1['clave'];
								$this->gal_tx_esp[$cont]=$row_img1['titulo_esp'];
								$this->gal_tx_eng[$cont]=$row_img1['titulo_eng'];
								$this->cont_img_gal=$cont;
								$cont ++;
							}
						   
						   }
					   
					   
					    $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT * FROM com_proyectos_videos WHERE proyecto = :id1 ORDER BY orden DESC";
    					$bind2 = array(
        					':id1' => $id
    					);
					  // echo "leemos los videos";
					   
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_video = "";
					//echo "no hay videos";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_video = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_video as $row_img1) {	
						  
							//echo "hay videos";
								
								$this->videoid[$cont]=$row_img1['id'];
						   		$this->video[$cont]=$row_img1['video'];
								$this->video_img[$cont]=$row_img1['imagen'];
								$cont ++;
							
						   
						   }
					 }
					 
					 // las opiniones del proyecto

					  $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT com_proyectos_equipo.id, com_proyectos_equipo.comentario_esp, com_proyectos_equipo.comentario_eng, com_equipo.nombre, com_equipo.cargo, com_equipo.imagen FROM com_proyectos_equipo INNER JOIN com_equipo ON com_proyectos_equipo.equipo = com_equipo.id WHERE com_proyectos_equipo.proyecto = :id1   ORDER BY com_proyectos_equipo.orden DESC";
    					$bind2 = array(
        					':id1' => $id
    					);
					   
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_video = "";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_equipo = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_equipo as $row_img1) {	
						  
							
								 $this->opiid[$cont]=$row_img1['id'];
								 $this->opi_esp[$cont]=$row_img1['comentario_esp'];
								 $this->opi_eng[$cont]=$row_img1['comentario_eng'];
						         $this->opiuser[$cont]=$row_img1['nombre'];
						         $this->opiuser_cargo[$cont]=$row_img1['cargo'];
						         $this->opiuser_img[$cont]=$row_img1['imagen'];
								$cont ++;
							
						   
						   }
					 }  
					   
					   // categorias
					    $db2=null;
					    $db2 = Db::getInstance();
						$sql2 = "SELECT * FROM com_proyectos_categorias WHERE proyecto = :id1";
    					$bind2 = array(
        					':id1' => $this->id
    					);
					   
					   //echo $this->id;
					   $conti = $db2->run($sql2, $bind2);
				if ($conti == 0) {
					$row_img = "";
				} else {
					   $db3=null;
					   $db3 = Db::getInstance();
					   $row_img = $db3->fetchAll($sql2, $bind2);
					   $cont = 1;
					   foreach($row_img as $row_img1) {	
						  
							
								
								$this->categorias[$cont]=$row_img1['categoria'];
								$cont ++;
							
						   
						   }
					 }
					   // fin categorias
						
					}
				}
	}
	
	
	
	
	public function agregarImg($tipo,$valor)
    {
	   
			$this->orden_lastimg = $this->getOrden('com_proyectos_img');
			$db = Db::getInstance();
			$data = array(
			'clave' => $valor,
        	'proyecto' => $this->id,
        	'tipo' => $tipo,
        	'fecha' => date('Y-m-d H:i:s'),
			'orden' => $this->orden_lastimg,
			'estado' => 1,
		);
		
		if ($tipo == 0) {
			$db->delete('com_proyectos_img', "proyecto=:id and tipo = 0" , array(':id' => $this->id));
			
		}
    	$db->insert('com_proyectos_img', $data);
		echo "ok";
		   
		//header("Location: proyectos_up.php?id=".$db->lastInsertId());
	   
		
    }
	
	
	public function agregarVideo($video,$imagen)
    {
		    
 		/*$videoT = new VimeoThumbnail(array(
     		'video_url' => 'https://vimeo.com/224626060'
  		));
  		$url_video = $videoT->thumbnail;*/
	   
			$orden_lastvid = $this->getOrden('com_proyectos_videos');
			$db = Db::getInstance();
			$data = array(
			'proyecto' => $this->id,
        	'video' => $video,
        	'imagen' => $imagen,
        	'fecha' => date('Y-m-d H:i:s'),
			'orden' => $orden_lastvid,
			'estado' => 1,
		);
		
		
    	$db->insert('com_proyectos_videos', $data);
		//echo "ok";
		   
		header("Location: proyectos_video.php?id=".$this->id);
	   
		
    }


    public function agregarEquipo($comentario_esp,$comentario_eng,$equipo)
    {
		    
 		/*$videoT = new VimeoThumbnail(array(
     		'video_url' => 'https://vimeo.com/224626060'
  		));
  		$url_video = $videoT->thumbnail;*/
	   
			$orden_lastvid = $this->getOrden('com_proyectos_equipo');
			$db = Db::getInstance();
			$data = array(
			'proyecto' => $this->id,
        	'equipo' => $equipo,
        	'comentario_esp' => $comentario_esp,
        	'comentario_eng' => $comentario_eng,
			'orden' => $orden_lastvid,
        	'fecin' => date('Y-m-d H:i:s')
		);
		
		
    	$db->insert('com_proyectos_equipo', $data);
		//echo "ok";
		   
		header("Location: proyectos_equipo.php?id=".$this->id);
	   
		
    }
	
	
		public function getSigAnt ($tipo)
	{
		      if ($this->interfaz==1) {
					$sqlag = " AND estado = 1";
				}
		        else {
					$sqlag = "";
				}
				$db = Db::getInstance();
		       if ($tipo == 'sig') {
				   $sql = "SELECT * FROM com_proyectos WHERE orden < :orden".$sqlag." ORDER BY orden DESC LIMIT 1";
			   } else {
				   $sql = "SELECT * FROM com_proyectos WHERE orden > :orden".$sqlag." ORDER BY orden LIMIT 1";
				   
			   }
				
			 $bind = array(
        		':orden' => $this->orden
    			);
    			
		        
				$cont = $db->run($sql, $bind);
				
		      if ($cont == 0) {
					
					
					if ($tipo == 'sig') {
						$sql = "SELECT * FROM com_proyectos WHERE id <> :id".$sqlag." ORDER BY orden DESC LIMIT 1";
					} else {
						$sql = "SELECT * FROM com_proyectos WHERE id <> :id".$sqlag." ORDER BY orden LIMIT 1";
				   		
					}
				  
				  $bind = array(
        		':id' => $this->id
    			);
    			
					
				} 
				
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				   foreach($row_p as $row_p1) {
					   
						//$this->getOne($row_p1['id']);
					   return $row_p1['id'];
						
					
				}
	}
	
	
	
		
}