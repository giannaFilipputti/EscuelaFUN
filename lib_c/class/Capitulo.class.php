<?php
class Capitulo
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $modulo;
	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_cursos_mod_cap";
	
    }
	

	

	public function agregar($id,$caso,$modulo,$titulo,$titulo_eng,$autor,$orden,$resena_autor,$revista, $duracion,$tema,$sub_menu,$video)
	{
		/*if (empty($caso)) {
			header("Location: capitulos.php?id=".$modulo);
		} else {*/

			$db = Db::getInstance();
			

			$data = array(
				'id' => $id,
				'caso' => $caso,
				'modulo' => $modulo,
				'titulo' => $titulo,
				'titulo_eng' => $titulo_eng,
				'autor' => $autor,
				'resena_autor' => $resena_autor,
				'revista' => $revista,
				'duracion' => $duracion,
				'tema' => $tema,
				'orden' => $orden,
				'estado' => "1",
				'sub_menu' => $sub_menu,
				'video' => $video
			);
			$db->insert($this->tabla, $data);

			$duracioncap = $this->getDuracionAllMod($modulo);
			$mod = Modulo::actualizarDuracion($modulo, $duracioncap);
		//}
	}



	public function modificar($id,$caso,$modulo,$titulo,$titulo_eng,$autor,$resena_autor,$revista,$duracion,$tema,$sub_menu,$video)
	{
		if (empty($id)) {
			header("Location: capitulos_mod.php?id=" . $modulo);
		} else {

			$db = Db::getInstance();
			$data = array(
				'caso' => $caso,
				'modulo' => $modulo,
				'titulo' => $titulo,
				'titulo_eng' => $titulo_eng,
				'autor' => $autor,
				'resena_autor' => $resena_autor,
				'revista' => $revista,
				'duracion' => $duracion,
				'tema' => $tema,
				'estado' => "1",
				'sub_menu' => $sub_menu,
				'video' => $video

			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			$duracioncap = $this->getDuracionAllMod($modulo);
			//echo "Duracion cap: ".$duracioncap;
			$mod = Modulo::actualizarDuracion($modulo, $duracioncap);

		}
	}

	public function modificarEstado($estado, $id)
	{
		if (empty($id)) {
			header("Location: capitulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'estado' => $estado
			);
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}

	
	public function modificarOrden($orden, $id)
	{
		if (empty($id)) {
			header("Location: capitulos.php?id=".$id);
		} else {

			$db = Db::getInstance();
			$data = array(
				'orden' => $orden
			);
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}

	public function getDuracionAllMod($modulo) {
		$db = Db::getInstance();
		$sql = "SELECT SUM(duracion) AS dur FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);
		
		if (!empty($modulo)) {
			$sql .= " AND modulo = :modulo";
			$bind[":modulo"] = $modulo;
		}

		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			$row_p = "";
		} else {

			$this->hayelemen = $cont;
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p[0]['dur'];
		}

	}

	
	public function getAll($modulo = "")
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);
		
		if (!empty($modulo)) {
			$sql .= " AND modulo = :modulo";
			$bind[":modulo"] = $modulo;
		}


		$total_results = $db->run($sql, $bind);
		$total_pages = ceil($total_results / $this->limit);
		$this->total_pages = $total_pages;


		$starting_limit = ($this->pag - 1) * $this->limit;

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

		$sql .= " ORDER BY " . $orden . $tiporden . " LIMIT " . $starting_limit . "," . $this->limit;
		//   echo $sql;
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$this->hayelemen = $cont;
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			$longitud = count($row_p);
			// for($i=0; $i<$longitud; $i++) {

			//     //echo $row_p1['nombre'] ;
			// 	$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'],1);


			// 	$conty++;
			// }
			$this->row = $row_p;
		}
	}
	
	public function getLastOrden()
	{
		$db = Db::getInstance();
		$sql = "SELECT orden FROM " . $this->tabla . " ORDER BY orden DESC LIMIT 1";
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

	public function getLastId()
	{
		$db = Db::getInstance();
		$sql = "SELECT id FROM " . $this->tabla . " ORDER BY id DESC LIMIT 1";
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

	public function getCapDown($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_cap_down WHERE capitulo = :id ORDER BY ubicacion, orden";
		$bind = array(
			':id' => $id
		);
		
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = array();
			$this->row = $row_p;
		} else {
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

	

	public function eliminar($id,$curso,$ref){
		if(empty($id)){
			header("Location: capitulos.php?id=".$ref."&ref=".$curso);
		}else{
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla,"id = :id",$data);
		}
	}

	public function eliminarByMod($id,$ref){
		if(empty($id)){
			header("Location: modulos.php?id=" . $ref);
		}else{
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla,"modulo = :id",$data);
		}
	}

	public function porcentajeAlumno($id,$salida=0) {

			$sql = "SELECT com_ponencias_ima.id FROM com_ponencias_ima
			LEFT JOIN com_capitulo_contenidos ON com_capitulo_contenidos.id = com_ponencias_ima.ponencia
			LEFT JOIN com_cursos_mod_cap ON com_capitulo_contenidos.capitulo = com_cursos_mod_cap.id";
		 	$sql .= " WHERE com_cursos_mod_cap.id = :capitulo";
		 					
						$bind = array(
        					':capitulo' => $id
    					);
    		$sql .= " ORDER BY com_ponencias_ima.orden";
    		$db = Db::getInstance();
			$cont = $db->run($sql, $bind);

			$sql1 = "SELECT com_alumnos_diapos.id FROM com_alumnos_diapos
			LEFT JOIN com_ponencias_ima ON com_alumnos_diapos.diapo = com_ponencias_ima.id
			LEFT JOIN com_capitulo_contenidos ON com_capitulo_contenidos.id = com_ponencias_ima.ponencia
			LEFT JOIN com_cursos_mod_cap ON com_capitulo_contenidos.capitulo = com_cursos_mod_cap.id";
		 	$sql1 .= " WHERE com_cursos_mod_cap.id = :capitulo AND alumno = :alumno AND NOT (com_alumnos_diapos.diapo <=> NULL)";
		 					
						$bind1 = array(
        					':capitulo' => $id,
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

	public function registrarAcceso() {

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_capitulo WHERE alumno = :alumno AND capitulo = :capitulo LIMIT 1";
		$bind = array(
		':alumno' => $this->alumno,
		':capitulo' => $this->row[0]['id']
		);
		
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {

			$db1 = Db::getInstance();
			$data1 = array(
				'alumno' => $this->alumno,
				'capitulo' => $this->row[0]['id'],
				'fecin' => date('Y-m-d H:i:s')
			);
			//print_r($data1);
			$db1->insert('com_alumnos_capitulo', $data1);
		} else {
			
			// no pasa nada si ya se registró el acceso
		}

}

static function verificarAcceso($alumno, $capitulo) {

	$db = Db::getInstance();
	$sql = "SELECT * FROM com_alumnos_capitulo WHERE alumno = :alumno AND capitulo = :capitulo LIMIT 1";
	$bind = array(
	':alumno' => $alumno,
	':capitulo' => $capitulo
	);
/*
	echo $sql;
	print_r($bind);*/
	
	$cont = $db->run($sql, $bind);
	return $cont;
	

}


public function agregarLink($capitulo, $desde, $hasta, $ancho, $alto, $url, $orden)
	{
		$db = Db::getInstance();
		$this->id = $db->lastInsertId();
		$data = array(

			'capitulo' => $capitulo,
			'desde' => $desde,
			'hasta' => $hasta,
			'ancho' => $ancho,
			'alto' => $alto,
			'url' => $url,
			'orden' => $orden
		);
		echo "aded";
		$db->insert("com_capitulo_ima_link", $data);
	}


	public function eliminarLink($id, $ref)
	{
		if (empty($id)) {
			header("Location: capitulos_img_link.php?id=" . $ref);
		} else {
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete("com_capitulo_ima_link", "id = :id", $data);
			// header("Location: modulos.php?id=".$curso."");
		}
	}


	public function getLink($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_capitulo_ima_link WHERE capitulo=:id ORDER BY desde";
		$bind = array(
			':id' => $id
		);
		// echo $sql;
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			$this->rowL = $row_p;
		}
	}



	
	
	
	
		
}