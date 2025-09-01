<?php

class UsuarioExam
{
	public $id;
	public $alumno;
	public $modulo;
	public $nota;
	public $aprobado;
	public $noAprobado;

	public $estado;
	public $fecini;
	public $fecfin;
	public $id_exam_mod;

	public $tabla;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	public $datepicker1;
	public $datepicker;
	private $interfaz;

	public $intentos;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_alumnos_exam";
	}

	public function agregarBorrador($usuario, $autor, $fecha, $datos)
	{
		$db = Db::getInstance();
		$this->id = $db->lastInsertId();
		$data = array(
			'usuario' => $usuario,
			'autor' => $autor,
			'fecha' => $fecha,
			'datos' => $datos
		);
		$db->insert("com_exam_borrados", $data);
	}

	public function ampliarFecha($fecin, $alumno, $modulo)
	{
		if (empty($alumno)) {
			 header("Location: usuario.php");
		} else {


			$db = Db::getInstance();
			$data = array(
				'fecin' => $fecin,
			);
			//$db->insert('com_proyectos', $data);

			$db->update("com_alumnos_modulo", $data, 'alumno = :alumno AND modulo = :modulo', array(':alumno' => $alumno, ':modulo' => $modulo));

			// header("Location: usuarios.php");
		}
	}

	public function ampliarFechaById($fecin, $id)
	{
		if (empty($id)) {
			 header("Location: usuario.php");
		} else {


			$db = Db::getInstance();
			$data = array(
				'fecini' => $fecin,
				'fecfin' => null,
				'estado' => 0,
				'nota' => 0,
				'forzar_cierre' => 1
			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			// header("Location: usuarios.php");
		}
	}

	public function getAll()
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id AND ";
		$bind = array(
			':id' => 0
		);

		if (!empty($this->modulo)) {
			$sql .= "modulo = " . $this->modulo . " AND ";
		}

		if (!empty($this->datepicker)) {
			$sql .= "fecfin >= '" . $this->datepicker . "' AND ";
		}

		if (!empty($this->datepicker1)) {
			$this->datepicker1 = $this->datepicker1 . " 23:59:30";
			$sql .= "fecfin <= '" . $this->datepicker1 . "' AND ";
		}

		if (!empty($this->aprobado)) {
			if ($this->aprobado == 2) {
				$this->aprobado = 0;
			}
			$sql .= "aprobado = " . $this->aprobado . " AND ";
		}

		if(!empty($this->noAprobado)){
			$sql .= "aprobado = 0 AND ";
		}
		
		if (empty($this->orden)) {
			$orden = $this->tabla . ".fecfin";
		} else {
			$orden = $this->orden;
		}

		if ($this->tiporden == 'desc') {
			$tiporden = " desc";
		} else {
			$tiporden = "";
		}

		$sql .= "estado = 1 ORDER BY " . $orden ." desc ";
		//   echo $sql;
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$this->row = $row_p;
		}
	}


	public function getOne($alumno, $modulo)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE alumno = :alumno AND modulo = :modulo";
		$bind = array(
			':alumno' => $alumno,
			':modulo' => $modulo
		);
		$total_results = $db->run($sql, $bind);
		$total_pages = ceil($total_results / $this->limit);
		$this->total_pages = $total_pages;

		$starting_limit = ($this->pag - 1) * $this->limit;

		if (empty($this->orden)) {
			$orden = $this->tabla . ".fecini";
		} else {
			$orden = $this->orden;
		}

		if ($this->tiporden == 'desc') {
			$tiporden = " desc";
		} else {
			$tiporden = "";
		}

		if (!empty($this->id)) {
			$sql .= " AND id = '" . $this->id . "'";
		}


		$sql .= " ORDER BY " . $orden . $tiporden . " LIMIT " . $starting_limit . "," . $this->limit;


		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$this->row = $row_p;
		}
	}

	public function getUsuarioRespuesta($id, $alumno, $id_exam_mod)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_resp WHERE respuesta = :id AND alumno = :alumno AND id_exam_mod = :id_exam_mod";
		$bind = array(
			':id' => $id,
			':alumno' => $alumno,
			':id_exam_mod' => $id_exam_mod
		);

		// echo $sql;
		// print_r($bind);
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$this->row =  $row_p;
		}
	}

	public function getUsuarioRespuestaByPregunta($id, $alumno)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_resp WHERE pregunta = :id AND alumno = :alumno";
		$bind = array(
			':id' => $id,
			':alumno' => $alumno,
		);
		$starting_limit = ($this->pag - 1) * $this->limit;

		if (empty($this->orden)) {
			$orden = "fecha";
		} else {
			$orden = $this->orden;
		}

		if ($this->tiporden == 'desc') {
			$tiporden = " desc";
		} else {
			$tiporden = "";
		}

		if (!empty($this->id_exam_mod)) {
			$sql .= " AND id_exam_mod = '" . $this->id_exam_mod . "'";
			// echo $sql;
		}

		$sql .= " ORDER BY " . $orden . $tiporden . " LIMIT " . $starting_limit . "," . $this->limit;
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$this->row = $row_p;
		}
	}

	public function getByModulo($modulo)
	{
		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE modulo = :modulo AND estado = 1 ";
		$bind = array(
			':modulo' => $modulo

		);

		if (!empty($this->aprobado)) {
			$sql .= " AND aprobado = :aprobado";
			$bind[":aprobado"] = $this->aprobado;
		}

		if(!empty($this->noAprobado)){
			$sql .= " AND aprobado = :aprobado ";
			$bind[":aprobado"] = 0 ;
		}

		// echo $this->aprobado;
		// echo $sql."<br>";
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {
			$this->hayelemen = $cont;
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			$longitud = count($row_p);
			//$this->row_p = $row_p;
			$this->row = $row_p;
		}
	}

	public function eliminar($id)
	{

		$db = Db::getInstance();
		$data = array(
			'id' => $id
		);

		$db->delete($this->tabla, "id = :id", $data);
		// header("Location: modulos.php?id=".$curso."");

	}

	public function eliminarExamCap($modulo, $alumno, $id_exam_mod)
	{

		$db = Db::getInstance();
		$data = array(
			'modulo' => $modulo
		);

		$db->delete($this->tabla, "id = :id", $data);
		// header("Location: modulos.php?id=".$curso."");

	}

		
	public function getintentos($alumno,$modulo){
		$db = Db::getInstance();

		$sql = "SELECT id FROM " . $this->tabla . " WHERE alumno = :alumno AND modulo = :modulo ORDER BY fecini ";
		$bind = array(
			':alumno' => $alumno,
			':modulo' => $modulo
		);
		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $cont;
		}
	}
}
