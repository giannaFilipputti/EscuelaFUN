<?php
class Diapositiva
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;
	public $capitulo;

	public $estado;
	public $row;

	public $modulo;
	public $pag = 1;
	public $limit = 250;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_ponencias_ima";
	}




	public function agregar($ponencia, $video, $orden)
	{
		$db = Db::getInstance();
		$this->id = $db->lastInsertId();
		$data = array(
			'ponencia' => $ponencia,
			'video' => $video,
			'orden' => $orden
		);
		$db->insert($this->tabla, $data);
	}
	public function agregarImg($ponencia, $img, $orden)
	{
		$db = Db::getInstance();
		$this->id = $db->lastInsertId();
		$data = array(

			'ponencia' => $ponencia,
			'nombre' => $img,
			'orden' => $orden
		);
		$db->insert($this->tabla, $data);
	}

	public function agregarLink($imagen, $top, $xleft, $ancho, $alto, $url, $orden)
	{
		$db = Db::getInstance();
		$this->id = $db->lastInsertId();
		$data = array(

			'imagen' => $imagen,
			'top' => $top,
			'xleft' => $xleft,
			'ancho' => $ancho,
			'alto' => $alto,
			'url' => $url,
			'orden' => $orden
		);
		echo "aded";
		$db->insert("com_ponencias_ima_link", $data);
	}




	public function modificar($comentario,$tiempo_limpio,$id)
	{
		if(empty($id)){
			header("Location: ponencias_act_tiempo.php?id=" . $id);
		} else {
			$db = Db::getInstance();
			$data = array(
				'comentario' => $comentario,
				'comentario_limpio' => $tiempo_limpio

			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			// header("Location: modulos.php");
		}
	}

	public function modificarTexto($texto_html,$texto,$id)
	{
		if(empty($id)){
			header("Location: ponencias_act_tiempo.php?id=" . $id);
		} else {
			$db = Db::getInstance();
			$data = array(
				'texto_html' => $texto_html,
				'texto' => $texto

			);
			//$db->insert('com_proyectos', $data);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

			// header("Location: modulos.php");
		}
	}

	

	public function modificarLink($id, $top, $xleft, $ancho, $alto, $url)
	{
		if (empty($id)) {
			// header("Location: ponencias_up_link.php?id=" . $id);
		} else {
			$db = Db::getInstance();
			$data = array(
				'top' => $top,
				'xleft' => $xleft,
				'ancho' => $ancho,
				'alto' => $alto,
				'url' => $url,
			);
			//$db->insert('com_proyectos', $data);

			$db->update("com_ponencias_ima_link", $data, 'id = :id', array(':id' => $id));

			// header("Location: modulos.php");
		}
	}

	public function modificarOrden($orden, $id)
	{
		if (empty($id)) {
			header("Location: ponencias_up.php?id=".$id);
		} else {

			$db = Db::getInstance();
			$data = array(
				'orden' => $orden
			);
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}


	public function getAll($ponencia)
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id";
		$bind = array(
			':id' => '0'
		);


		if (!empty($ponencia)) {
			$sql .= " AND ponencia = :ponencia";
			$bind[":ponencia"] = $ponencia;
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

			$this->getVideos();
		}
	}

	
	public function getLastOrdenIma($contenido)
	{
		$db = Db::getInstance();
		$sql = "SELECT orden FROM " . $this->tabla . " WHERE ponencia = :contenido ORDER BY orden DESC LIMIT 1";
		$bind = array(
			'contenido' => $contenido
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

	public function getPrimera($ponencia)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE ponencia = :ponencia ORDER BY orden LIMIT 1";
		$bind = array(
			':ponencia' => $ponencia
		);



		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			$this->row = $row_p;
			$this->getVideos();
		}
	}

	public function getVideos()
	{
		foreach ($this->row as $key => $value) {
			//$conty
			$db = Null;
			$db = Db::getInstance();
			$sql = "SELECT * FROM com_ponencias_ima_link WHERE imagen = :imagen ORDER BY orden";
			$bind = array(
				':imagen' => $this->row[$key]['id']
			);



			$cont = $db->run($sql, $bind);
			if ($cont == 0) {
				$row_p = "";
			} else {

				$db1 = Db::getInstance();
				$row_p = $db1->fetchAll($sql, $bind);

				$this->row[$key]['links'] = $row_p;
			}
		}
	}

	public function getLink($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_ponencias_ima_link WHERE imagen=:id ORDER BY orden";
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
			$this->row = $row_p;
		}
	}


	public function getLastOrdenLink($imagen)
	{
		$db = Db::getInstance();
		$sql = "SELECT orden FROM com_ponencias_ima_link WHERE imagen = :imagen ORDER BY orden DESC LIMIT 1";
		$bind = array(
			'imagen' => $imagen
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

	public function eliminar($id, $ref)
	{
		if (empty($id)) {
			header("Location: ponencias_up.php?id=" . $ref);
		} else {
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla, "id = :id", $data);
			// header("Location: modulos.php?id=".$curso."");
		}
	}
	
	public function eliminarByPagina($id,$ref)
	{
		if (empty($id)) {
			header("Location: modulos.php?id=" . $ref);
		} else {
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla, "ponencia = :id", $data);
			echo "ok diapo";

			// header("Location: modulos.php?id=".$curso."");
		}
	}

	public function eliminarLink($id, $ref)
	{
		if (empty($id)) {
			header("Location: ponencias_up_link.php?id=" . $ref);
		} else {
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete("com_ponencias_ima_link", "id = :id", $data);
			// header("Location: modulos.php?id=".$curso."");
		}
	}

	public function diapoActual()
	{

		$sql0 = "SELECT id FROM com_ponencias_ima WHERE ponencia = :ponencia AND orden < :orden ORDER BY orden";

		$bind0 = array(
			':ponencia' => $this->pagina,
			':orden' => $this->orden
		);
		$db0 = Db::getInstance();
		$cont0 = $db0->run($sql0, $bind0);

		$this->diapoActual = $cont0 + 1;
	}
	public function diapoActualA($pagina, $orden, $tipo = 0)
	{

		$sql0 = "SELECT id FROM com_ponencias_ima WHERE ponencia = :ponencia AND orden < :orden ORDER BY orden";

		$bind0 = array(
			':ponencia' => $pagina,
			':orden' => $orden
		);
		$db0 = Db::getInstance();
		$cont0 = $db0->run($sql0, $bind0);

		return $cont0 + 1;
	}

	public function diapoTotal()
	{

		$sql0 = "SELECT id FROM com_ponencias_ima WHERE ponencia = :ponencia ORDER BY orden";
		$bind0 = array(
			':ponencia' => $this->pagina
		);
		$db0 = Db::getInstance();
		$cont0 = $db0->run($sql0, $bind0);
		$this->diapoTotal = $cont0;
	}

	public function porcentajeAlumno()
	{

		$sql = "SELECT id FROM com_ponencias_ima";
		$sql .= " WHERE ponencia = :ponencia";

		$bind = array(
			':ponencia' => $this->pagina
		);
		$sql .= " ORDER BY orden";
		$db = Db::getInstance();
		$cont = $db->run($sql, $bind);

		$sql1 = "SELECT id FROM com_alumnos_diapos";
		$sql1 .= " WHERE pagina = :pagina AND alumno = :alumno AND NOT (diapo <=> NULL)";

		$bind1 = array(
			':pagina' => $this->pagina,
			':alumno' => $this->alumno
		);
		$db1 = Db::getInstance();
		$cont1 = $db1->run($sql1, $bind1);
		$porcentaje = ($cont1 * 100) / $cont;
		$this->porcentaje = round($porcentaje);
	}

	public function actAlumno()
	{
		$sql0 = "SELECT id FROM com_alumnos_diapos WHERE diapo = :diapo AND alumno = :alumno LIMIT 1";
		$bind0 = array(
			':diapo' => $this->diapo,
			':alumno' => $this->alumno
		);
		$db0 = Db::getInstance();
		$cont0 = $db0->run($sql0, $bind0);
		if ($cont0 == 0) {
			if (!empty($this->diapo)) {
				$db = Db::getInstance();
				$data = array(
					'alumno' => $this->alumno,
					'diapo' => $this->diapo,
					'pagina' => $this->pagina,
					'fecha' => date('Y-m-d H:i:s')
				);
				$db->insert('com_alumnos_diapos', $data);
			}
		} else {
			//echo "si encontró nada";
			$db1 = Db::getInstance();
			$row_q = $db1->fetchAll($sql0, $bind0);
			$db = Db::getInstance();
			$data = array(
				'fecha' => date('Y-m-d H:i:s')
			);

			$db->update('com_alumnos_diapos', $data, 'id = :id', array(':id' => $row_q[0]['id']));
		}
	}
}
