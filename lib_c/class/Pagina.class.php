<?php
class Pagina
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;
	public $capitulo;
	public $alumno;

	public $estado;
	public $row;

	public $modulo;
	public $pag = 1;
	public $limit = 40;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_capitulo_contenidos";
	}


	public function agregar($capitulo, $titulo, $subtitulo, $autor, $tipo, $contenido, $orden, $permisos)
	{
		if (empty($capitulo)) {
			header("Location: paginas_add.php");
		} else {

			$db = Db::getInstance();
			$this->id = $db->lastInsertId();
			$data = array(
				'capitulo' => $capitulo,
				'titulo' => $titulo,
				'subtitulo' => $subtitulo,
				'autor' => $autor,
				'tipo' => $tipo,
				'contenido' => $contenido,
				'imagen' => "0",
				'estado' => "1",
				'orden' => $orden,
				'permisos' => $permisos
			);
			$db->insert($this->tabla, $data);
		}
	}



	public function modificar($id, $titulo, $subtitulo, $autor, $tipo, $contenido, $video, $permisos)
	{
		if (empty($id)) {
			header("Location: paginas_mod.php?id=" . $id);
		} else {

			$db = Db::getInstance();
			$data = array(
				'titulo' => $titulo,
				'subtitulo' => $subtitulo,
				'autor' => $autor,
				'tipo' => $tipo,
				'contenido' => $contenido,
				'video' => $video,
				'permisos' => $permisos
			);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}

	public function modificarEstado($estado, $id)
	{
		if (empty($id)) {
			header("Location: paginas.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'estado' => $estado
			);
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			//header("Location: modulos.php");
		}
	}

	public function modificarOrden($orden, $id)
	{
		if (empty($id)) {
			header("Location: paginas_up.php?id=".$id);
		} else {

			$db = Db::getInstance();
			$data = array(
				'orden' => $orden
			);
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}



	public function getAll($capitulo)
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);


		if (!empty($capitulo)) {
			$sql .= " AND capitulo = :capitulo";
			$bind[":capitulo"] = $capitulo;
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
		// echo $sql;
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$this->hayelemen = $cont;
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			$longitud = count($row_p);
			for ($i = 0; $i < $longitud; $i++) {

				//echo $row_p1['nombre'] ;
				// $row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'], 1);
				$conty++;
			}
			//$this->row_p = $row_p;
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

	public function porcentajeAlumno($id, $salida = 0)
	{

		$sql = "SELECT id FROM com_ponencias_ima";
		$sql .= " WHERE ponencia = :ponencia";

		$bind = array(
			':ponencia' => $id
		);
		$sql .= " ORDER BY orden";
		$db = Db::getInstance();
		$cont = $db->run($sql, $bind);
		// echo $sql;
		$sql1 = "SELECT id FROM com_alumnos_diapos";
		$sql1 .= " WHERE pagina = :pagina AND alumno = :alumno AND NOT (diapo <=> NULL)";

		$bind1 = array(
			':pagina' => $id,
			':alumno' => $this->alumno
		);
		$db1 = Db::getInstance();
		$cont1 = $db1->run($sql1, $bind1);
		$porcentaje = ($cont1 * 100) / $cont;
		if ($salida == 0) {
			$this->porcentaje = $porcentaje;
		} else {
			return round($porcentaje);
		}
	}


	public function getOne($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
		$bind = array(
			':id' => $id
		);
		
		$cont = $db->run($sql, $bind);
		// echo $sql;
		if ($cont == 0) {
			$row_p = "";
		} else {
			
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);


			$this->row = $row_p;

			$this->contadorPag();
		}
	}

	public function eliminar($id,$curso,$ref){
		if(empty($id)){
			header("Location: paginas.php?id=".$ref."&ref=".$curso);
		}else{
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla,"id = :id",$data);
		}
	}

	public function eliminarByCapitulo($id,$curso,$ref){
		if(empty($id)){
			header("Location: paginas.php?id=".$ref."&ref=".$curso);
		}else{
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla,"capitulo = :id",$data);
			// header("Location: modulos.php?id=".$curso."");
		}
	}

	public function contadorPag()
	{

		$sql = "SELECT id FROM " . $this->tabla . "";
		$sql .= " WHERE orden < :orden AND capitulo = :capitulo ORDER BY orden";

		$bind = array(
			':orden' => $this->row[0]['orden'],
			':capitulo' => $this->row[0]['capitulo']
		);

		//echo $sql;
		//print_r($bind);

		$db = null;
		$db = Db::getInstance();

		$cont = $db->run($sql, $bind);

		$this->contActual = $cont + 1;

		$sql1 = "SELECT id FROM " . $this->tabla . "";
		$sql1 .= " WHERE capitulo = :capitulo ORDER BY orden";

		$bind1 = array(
			':capitulo' => $this->row[0]['capitulo']
		);



		$db1 = null;
		$db1 = Db::getInstance();

		$cont1 = $db1->run($sql1, $bind1);

		$this->contTotal = $cont1;
	}


	public function registrarAcceso()
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_paginas WHERE alumno = :alumno AND pagina = :pagina LIMIT 1";
		$bind = array(
			':alumno' => $this->alumno,
			':pagina' => $this->row[0]['id']
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {

			$db1 = Db::getInstance();
			$data1 = array(
				'alumno' => $this->alumno,
				'pagina' => $this->row[0]['id'],
				'fecin' => date('Y-m-d H:i:s')
			);
			//print_r($data1);
			$db1->insert('com_alumnos_paginas', $data1);
		} else {

			// no pasa nada si ya se registró el acceso
		}
	}

	static function verificarAcceso($alumno, $pagina)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_paginas WHERE alumno = :alumno AND pagina = :pagina LIMIT 1";
		$bind = array(
			':alumno' => $alumno,
			':pagina' => $pagina
		);
		/*
	echo $sql;
	print_r($bind);*/

		$cont = $db->run($sql, $bind);
		return $cont;
	}
}
