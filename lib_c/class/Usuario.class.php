<?php
class Usuario
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	public $total_results;
	public $starting_limit;

	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_registro";
	}



	public function agregar()
	{
		if (empty($this->nombre) or empty($this->email) or empty($this->pass)) {
			header("Location: usuarios_add.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'nombre' => $this->nombre,
				'email' => $this->email,
				'pass' => $this->pass,
				'sucursal' => $this->sucursal,
				'nivel' => $this->nivel
			);
			$db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();

			//header("Location: usuarios_up.php?id=".$this->id);
			header("Location: usuarios.php");
		}
	}



	public function modificar()
	{
		if (empty($this->id)) {
			header("Location: usuarios.php");
		} else if (empty($this->email)) {
			header("Location: usuarios_mod.php?id=" . $this->id);
		} else {

			$db = Db::getInstance();
			$data = array(
				'nombre' => $this->nombre,
				'email' => $this->email,
				'sucursal' => $this->sucursal,
				'nivel' => $this->nivel
			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));

			header("Location: usuarios.php");
		}
	}


	public function modificarPass()
	{
		if (empty($this->id)) {
			header("Location: usuarios.php");
		} else if (empty($this->pass)) {
			header("Location: usuarios_mod.php?id=" . $this->id);
		} else {

			$db = Db::getInstance();
			$data = array(
				'pass' => $this->pass
			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));

			header("Location: usuarios.php");
		}
	}

	public function getAll($orden, $email, $nombre, $apellido)
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);

		$this->total_results = $db->run($sql, $bind);

		if (!empty($email)) {
			$sql .= " AND email = '" . $email . "'";
		}
		if (!empty($nombre)) {
			$sql .= " AND nombre LIKE '%" . $nombre . "%'";
		}
		if (!empty($apellido)) {
			$sql .= " AND ape1 LIKE '%" . $apellido . "%'";
		}


		$sql .= " ORDER BY " . $orden;

		if (!empty($this->starting_limit)) {
			$sql .= " LIMIT  $this->starting_limit, $this->limit";
		}

		$cont = $db->run($sql, $bind);
		//  echo $sql;
		if ($cont == 0) {
			$this->row = $row_p = "";
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

	public function getAllCurso($orden, $email, $nombre, $apellido, $curso)
	{

		$db = Db::getInstance();

		$sql = "SELECT " . $this->tabla . ".* FROM " . $this->tabla . " INNER JOIN com_cursos_registro ON " . $this->tabla . ".id = com_cursos_registro.usuario WHERE com_cursos_registro.curso = :curso";
		$bind = array(
			':curso' => $curso
		);

		$this->total_results = $db->run($sql, $bind);

		if (!empty($email)) {
			$sql .= " AND " . $this->tabla . ".email = '" . $email . "'";
		}
		if (!empty($nombre)) {
			$sql .= " AND " . $this->tabla . ".nombre LIKE '%" . $nombre . "%'";
		}
		if (!empty($apellido)) {
			$sql .= " AND " . $this->tabla . ".ape1 LIKE '%" . $apellido . "%'";
		}


		$sql .= " ORDER BY " . $orden;

		if (!empty($this->starting_limit)) {
			$sql .= " LIMIT  $this->starting_limit, $this->limit";
		}

		$cont = $db->run($sql, $bind);
		/*echo $sql;
		print_r($bind);*/

		if ($cont == 0) {
			$this->row = $row_p = "";
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

	public function getAlumnosEncuestas($orden, $email, $nombre, $apellido)
	{
		$db = Db::getInstance();
		$sql = "SELECT com_alumnos.*, com_encuesta_masterclass.*  FROM com_alumnos 
		INNER JOIN com_encuesta_masterclass ON com_alumnos.id = com_encuesta_masterclass.alumno 
		WHERE com_encuesta_masterclass.modulo = :modulo ";

		$bind = array(
			":modulo" => '1'
		);

		$this->total_results = $db->run($sql, $bind);

		if (!empty($email)) {
			$sql .= " AND com_alumnos.email = '" . $email . "'";
		}
		if (!empty($nombre)) {
			$sql .= " AND com_alumnos.nombre LIKE '%" . $nombre . "%'";
		}
		if (!empty($apellido)) {
			$sql .= " AND com_alumnos.ape1 LIKE '%" . $apellido . "%'";
		}

		$sql .= " ORDER BY " . $orden;
		// echo $sql;


		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$this->row = $row_p = "";
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
	public function getAlumnosMaster1($orden, $email, $nombre, $apellido)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos 
		INNER JOIN com_evento_registro ON com_alumnos.id = com_evento_registro.usuario 
		WHERE com_evento_registro.evento = :evento ";

		$bind = array(
			":evento" => '1'
		);

		$this->total_results = $db->run($sql, $bind);

		if (!empty($email)) {
			$sql .= " AND com_alumnos.email = '" . $email . "'";
		}
		if (!empty($nombre)) {
			$sql .= " AND com_alumnos.nombre LIKE '%" . $nombre . "%'";
		}
		if (!empty($apellido)) {
			$sql .= " AND com_alumnos.ape1 LIKE '%" . $apellido . "%'";
		}

		$sql .= " ORDER BY " . $orden;
		// echo $sql;


		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$this->row = $row_p = "";
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
}
