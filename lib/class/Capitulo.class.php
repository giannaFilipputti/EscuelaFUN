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
	public $limit = 50;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_cursos_mod_cap";
	}



	public function agregar()
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



	public function modificar()
	{
		if (empty($this->id)) {
			header("Location: modulos.php");
		} else if (empty($this->marca)) {
			header("Location: modulos_mod.php?id=" . $this->id);
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



	public function getAll($modulo)
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE modulo = :modulo";
		$bind = array(
			':modulo' => $modulo
		);




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

		/*echo $sql;
		print_r($bind);
*/




		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$this->hayelemen = $cont;
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			//print_r($row_p);
			$conty = 0;
			$longitud = count($row_p);
			for ($i = 0; $i < $longitud; $i++) {

				//echo $row_p1['nombre'] ;
				$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'], 1);


				$conty++;
			}
			return $row_p;
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

			return $row_p;
		}
	}


	public function porcentajeAlumno($id, $salida = 0)
	{

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
		if ($salida == 0) {
			$this->porcentaje = $porcentaje;
		} else {
			return round($porcentaje);
		}
	}

	public function registrarVisita($usuario, $capitulo, $id_mod)
	{


		$db = Db::getInstance();
		$data = array(
			'usuario' => $usuario,
			'capitulo' => $capitulo,
			'modulo' => $id_mod,
			'fecha' => date('Y-m-d H:i:s')
		);

		$db->save('com_capitulo_registro', $data, "usuario=:usuario AND capitulo = :capitulo", array('usuario' => $usuario, 'capitulo' => $capitulo));
	}

	static function videoTrack($user, $video, $porcentaje, $segundos, $segundos_cap, $segundos_mod, $segundos_cur, $id_mod, $id_cur)
	{
		if (empty($user) or empty($video)) {
			//header("Location: categorias_add.php");
			return "err1";
		} else {




			$db1 = Db::getInstance();

			$data1 = array(
				'usuario' => $user,
				'capitulo' => $video,
				'porcentaje' => $porcentaje,
				'segundos' => $segundos,
				'fecreg' => date('Y-m-d H:i:s')

			);

			$db1->save('com_capitulo_registro_det', $data1, "usuario=:usuario AND capitulo = :video AND porcentaje = :porcentaje", array('usuario' => $user, 'video' => $video, 'porcentaje' => $porcentaje));


			$respuesta = Capitulo::actualizarAvance($user, $video, $segundos_cap, $segundos_mod, $segundos_cur, $id_mod, $id_cur);

			return $respuesta;

			//$this->modificarReunionAdmin($id, $email);


		}
	}

	static function actualizarAvance($user, $video, $segundos_cap, $segundos_mod, $segundos_cur, $id_mod, $id_cur)
	{

		$db = Db::getInstance();
		$sql = "SELECT SUM(segundos) AS totseg FROM com_capitulo_registro_det WHERE usuario = :usuario AND capitulo = :video AND porcentaje > 0";
		$bind = array(
			':usuario' => $user,
			':video' => $video
		);

		/*echo $sql;
				print_r($bind);*/

		$cont = $db->run($sql, $bind);



		if ($cont > 0) {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			$suma =  $row_p[0]['totseg'];
			$porc = ceil(($suma * 100) / $segundos_cap);

			if ($porc > 100) {
				$porc = 100;
			}


			$db2 = Db::getInstance();

			$data2 = array(
				'usuario' => $user,
				'capitulo' => $video,
				'modulo' => $id_mod,
				'duracion' => $suma,
				'porcentaje' => $porc,
				'fecha' => date('Y-m-d H:i:s')
			);

			$db2->save('com_capitulo_registro', $data2, "usuario = :usuario AND capitulo = :video", array('usuario' => $user, 'video' => $video));

			$respuesta = array();
			$respuesta = Modulo::actualizarAvance($user, $segundos_mod, $segundos_cur, $id_mod, $id_cur);

			$porc_cap = $porc;
			$respuesta['capitulo'] = $porc_cap;
		} else {
			$respuesta = "";
		}

		return $respuesta;
	}


	public function checkVisita($usuario, $capitulo)
	{

		$db = Db::getInstance();
		$sql = "SELECT duracion, porcentaje FROM com_capitulo_registro WHERE capitulo = :capitulo and usuario = :usuario LIMIT 1";
		$bind = array(
			':usuario' => $usuario,
			':capitulo' => $capitulo
		);

		$cont = $db->run($sql, $bind);
		//return $cont;
		if ($cont > 0) {


			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p[0];
		} else {
			return 0;
		}
	}

	public function checkTarea($curso, $modulo, $capitulo)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_tareas WHERE curso = :curso AND modulo = :modulo AND capitulo = :capitulo LIMIT 1";
		$bind = array(
			':curso' => $curso,
			':modulo' => $modulo,
			':capitulo' => $capitulo
		);

		$cont = $db->run($sql, $bind);
		return $cont;
	}

	public function checkTarea_archivos($curso, $modulo, $capitulo)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_tareas_archivos WHERE curso = :curso AND modulo = :modulo AND capitulo = :capitulo LIMIT 1";
		$bind = array(
			':curso' => $curso,
			':modulo' => $modulo,
			':capitulo' => $capitulo
		);

		$cont = $db->run($sql, $bind);
		return $cont;
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
			return "";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}
}
