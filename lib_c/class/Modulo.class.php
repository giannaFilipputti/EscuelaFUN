<?php
class Modulo
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
	public $total_results_encuesta;
	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_cursos_mod";
	}



	public function agregar($curso, $titulo, $titulo_diploma, $subtitulo, $descripcion, $intro, $video, $fechoy, $orden, $porc_aprob, $preg_aprob, $preg_pag, $creditos, $no_acred, $horas, $periodo, $acred_desde, $acred_hasta, $acreditado, $solicitada, $ex_unico, $color, $cantpreg)
	{
		if (empty($curso)) {
			header("Location: modulos_add.php");
		} else {

			$db = Db::getInstance();
			$this->id = $db->lastInsertId();
			$data = array(
				'curso' => $curso,
				'titulo' => $titulo,
				'titulo_diploma' => $titulo_diploma,
				'subtitulo' => $subtitulo,
				'descripcion' => $descripcion,
				'intro' => $intro,
				'video' => $video,
				'estado' => "1",
				'fecha' => $fechoy,
				'orden' => $orden,
				'porc_aprob' => $porc_aprob,
				'preg_aprob' => $preg_aprob,
				'preg_pag' => $preg_pag,
				'creditos' => $creditos,
				'no_acred' => $no_acred,
				'horas' => $horas,
				'periodo' => $periodo,
				'acred_desde' => $acred_desde,
				'acred_hasta' => $acred_hasta,
				'acreditado' => $acreditado,
				'solicitada' => $solicitada,
				'examen_unico' => $ex_unico,
				'color' => $color,
				'cantpreg' => $cantpreg
			);
			$db->insert($this->tabla, $data);

			//header("Location: modulos_up.php?id=".$this->id);
			header("Location: modulos.php");
		}
	}



	public function modificar($titulo, $titulo_diploma, $subtitulo, $descripcion, $intro, $video, $porc_aprob, $preg_aprob, $preg_pag, $creditos, $no_acred, $horas, $periodo, $acred_desde, $acred_hasta, $acreditado, $solicitada, $ex_unico, $color, $id)
	{
		if (empty($id)) {
			header("Location: modulos.php");
		}
		// else if (empty($this->marca)) {
		// 	header("Location: modulos_mod.php?id=" . $this->id);
		// }
		else {

			$db = Db::getInstance();
			$data = array(
				'titulo' => $titulo,
				'titulo_diploma' => $titulo_diploma,
				'subtitulo' => $subtitulo,
				'descripcion' => $descripcion,
				'intro' => $intro,
				'video' => $video,
				'porc_aprob' => $porc_aprob,
				'preg_aprob' => $preg_aprob,
				'preg_pag' => $preg_pag,
				'creditos' => $creditos,
				'no_acred' => $no_acred,
				'horas' => $horas,
				'periodo' => $periodo,
				'acred_desde' => $acred_desde,
				'acred_hasta' => $acred_hasta,
				'acreditado' => $acreditado,
				'solicitada' => $solicitada,
				'examen_unico' => $ex_unico,
				'color' => $color

			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			header("Location: modulos.php");
		}
	}

	public function modificarExUnico($id)
	{
		if (empty($this->id)) {
			header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'examen_unico' => "0"
			);
			$db->update($this->tabla, $data, 'curso = :id', array(':id' => $id));

			//header("Location: modulos.php");
		}
	}


	public function modificarEstado($estado, $id)
	{
		if (empty($id)) {
			header("Location: modulos.php");
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
			header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'orden' => $orden
			);
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			//header("Location: modulos.php");
		}
	}

	public function eliminar($id, $curso)
	{
		if (empty($id)) {
			header("Location: modulos.php?id=" . $curso . "");
		} else {
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla, "id = :id", $data);
			// header("Location: modulos.php?id=" . $curso . "");
		}
	}

	static function actualizarDuracion($modulo, $duracion) {

		if (empty($modulo) or empty($duracion)) {
			//header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'duracion' => $duracion
			);
			$db->update('com_cursos_mod', $data, 'id = :id', array(':id' => $modulo));

			$mod = New Modulo();
			$mod->getOne($modulo);
			$curso = $mod->row[0]['curso'];
			//echo "Curso".$curso;
			$duracioncur = $mod->getDuracionAllCur($curso);
			//echo "Duracion Curso".$duracioncur;
			$cursoA = Curso::actualizarDuracion($curso, $duracioncur);

			//header("Location: modulos.php");
		}

	}

	public function getDuracionAllCur($curso) {
		$db = Db::getInstance();
		$sql = "SELECT SUM(duracion) AS dur FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);
		
		if (!empty($curso)) {
			$sql .= " AND curso = :curso";
			$bind[":curso"] = $curso;
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


	public function getAll($tipo = '')
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);

		if ($tipo == 'todos') {
		} else {
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
		}




		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			/*foreach($row_p as $row_p1) {
					  $conty++;				
					}*/
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

	public function getModByCurso($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE curso = :id ORDER BY orden";
		$bind = array(
			':id' => $id
		);

		if (!empty($this->estado)) {
			$sql .= " AND estado = :estado";
			$bind[":estado"] = $this->estado;
		}
		if (!empty($this->ex_unico)) {
			$sql .= " AND examen_unico = :ex_unico";
			$bind[":ex_unico"] = $this->ex_unico;
		}
		// echo $sql;
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

	public function getModOrden($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT orden FROM " . $this->tabla . " WHERE curso = $id" . " ORDER BY orden DESC LIMIT 1";
		$bind = array(
			':curso' => $id
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


	public function getUsuarioModulo($modulo, $id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_modulo WHERE modulo = :modulo AND alumno = :id ORDER BY fecin";
		$bind = array(
			':modulo' => $modulo,
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

	public function registrarAcceso()
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_alumnos_modulo WHERE alumno = :alumno AND modulo = :modulo LIMIT 1";
		$bind = array(
			':alumno' => $this->alumno,
			':modulo' => $this->row[0]['id']
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {

			$db1 = Db::getInstance();
			$data1 = array(
				'alumno' => $this->alumno,
				'modulo' => $this->row[0]['id'],
				'fecin' => date('Y-m-d H:i:s')
			);
			//print_r($data1);
			$db1->insert('com_alumnos_modulo', $data1);
		} else {

			// no pasa nada si ya se registró el acceso
		}
	}

	public function guardarEncuesta($p1, $p2, $p3, $p4, $p5, $p6, $modulo)
	{

		$db1 = null;
		$db1 = Db::getInstance();
		$data1 = array(
			'alumno' => $this->alumno,
			'modulo' => $modulo,
			'p1' => $p1,
			'p2' => $p2,
			'p3' => $p3,
			'p4' => $p4,
			'p5' => $p5,
			'p6' => $p6,
			'fecha' => date('Y-m-d H:i:s')
		);
		//print_r($data1);
		$db1->insert('com_encuesta', $data1);
	}


	static function getEncuestaUser($modulo, $alumno)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_encuesta WHERE alumno = :alumno AND modulo = :modulo LIMIT 1";
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

	public function getAllEncuesta($id, $p, $n)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_encuesta WHERE modulo = :id ";
		$bind = array(
			':id' => $id
		);

		if ($n > 0) {
			$sql .= "AND " . $p . " = :n ";
			$bind[':n'] = $n;
		}

		// $sql .=" LIMIT $this->starting_limit, $this->limit";

		$this->total_results_encuesta = $db->run($sql, $bind);
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

	public function getAllEncuestaByMod($id,$orden = "")
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_encuesta WHERE modulo = :id ";
		$bind = array(
			':id' => $id
		);
		$this->total_results = $db->run($sql, $bind);

		if($orden != ""){
			$sql .= " ORDER BY fecha DESC ";
		}
		
		if (!empty($this->starting_limit)) {
			$sql .= " LIMIT $this->starting_limit, $this->limit";
		}
		// echo $sql;
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

	public function getOneEncuesta($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_encuesta WHERE id = :id ";
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

	public function getModDown($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_mod_down WHERE id = :id ";
		$bind = array(
			':id' => $id
		);
		// ECHO $sql;
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
