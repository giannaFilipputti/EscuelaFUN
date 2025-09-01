<?php

class Curso
{
	public $id;
	public $titulo;
	public $fecha;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 50;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $bienvenida;
	public $examen;
	public $landing;
	public $con;
	public $zon;
	public $entrada;

	private $interfaz;



	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_cursos_2022";
	}

	public function agregar($titulo, $fechoy,$bienvenida, $ex_unico ,$con , $zon)
	{
		if (empty($titulo)) {
			header("Location: cursos_add.php");
		} else {

			$db = Db::getInstance();
			$this->id = $db->lastInsertId();

			$data = array(
				'id' => $this->id,
				'titulo' => $titulo,
				'fecha' => $fechoy,
				'bienvenida' => $bienvenida,
				'examen' => $ex_unico,
				'con' => $con,
				'zon' => $zon

			);
			
			$db->insert($this->tabla, $data);
			

			//header("Location: modulos_up.php?id=".$this->id);
			header("Location: cursos.php");
		}
	}

	public function modificar($id,$titulo, $fechoy,$bienvenida, $ex_unico ,$con , $zon)
	{
		if (empty($id)) {
			 header("Location: cursos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'id' => $id,
				'titulo' => $titulo,
				'fecha' => $fechoy,
				'bienvenida' => $bienvenida,
				'examen' => $ex_unico,
				'con' => $con,
				'zon' => $zon
			);
			//$db->insert('com_proyectos', $data);

			$db->update('com_cursos_2022', $data, 'id = :id', array(':id' => $id));

			 header("Location: cursos.php");
		}
	}

	public function eliminar($id){
		if(empty($id)){
			header("Location: cursos.php");
		}else{
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla,"id = :id",$data);
			header("Location: cursos.php");
		}
	}

	public function modificarAction($id, $encuesta)
	{
		$db = Db::getInstance();
		$data = array(
			'examen' => $encuesta
		);
		//$db->insert('com_proyectos', $data);

		$db->update('com_cursos_2022', $data, 'id = :id', array(':id' => $id));

		header("Location: encuesta.php");
	}

	static function actualizarDuracion($curso, $duracion) {

		if (empty($curso) or empty($duracion)) {
			//header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'duracion' => $duracion
			);
			$db->update('com_cursos_2022', $data, 'id = :id', array(':id' => $curso));

			

			//header("Location: modulos.php");
		}

	}


	public function getAll()
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM ".$this->tabla."";
		$bind = array(
			':id' => '0'
		);

		$total_results = $db->run($sql, $bind);
		$total_pages = ceil($total_results / $this->limit);
		$this->total_pages = $total_pages;


		$starting_limit = ($this->pag - 1) * $this->limit;

		if (empty($this->orden)) {
			$orden = $this->tabla . ".titulo";
		} else {
			$orden = $this->orden;
		}


		if ($this->tiporden == 'desc') {
			$tiporden = " desc";
		} else {
			$tiporden = "";
		}

		 $sql .= " ORDER BY " . $orden . $tiporden . " LIMIT " . $starting_limit . "," . $this->limit;



		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			foreach ($row_p as $row_p1) {
				$conty++;
			}
			$this->row = $row_p;
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
		if ($cont == 0) {
			$row_p = "";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$this->row = $row_p;
		}
	}

}
