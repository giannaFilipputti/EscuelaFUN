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
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_exam_preg";
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
			for ($i = 0; $i < $longitud; $i++) {

				//echo $row_p1['nombre'] ;
				$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'], 1);


				$conty++;
			}
			//$this->row_p = $row_p;
			$this->row = $row_p;
		}
	}

	public function reiniciarExam()
	{
		$ex_estado = $this->getEstado();
		//echo "<br>estado:".$ex_estado;
		if ($ex_estado == 2) {
			$this->iniciarExamen();
		}
	}

	public function iniciarExamen()
	{
		$db1 = Db::getInstance();
		$data1 = array(
			'alumno' => $this->alumno,
			'modulo' => $this->modulo,
			'fecini' => date('Y-m-d H:i:s'),
			'pag' => '1'
		);
		//print_r($data1);
		$db1->insert('com_alumnos_exam', $data1);
		$this->id = $db1->lastInsertId();

		$this->seleccionarPreguntas($this->id);
	}

	static function aprobarExamen($modulo, $user)
	{

		$db = Db::getInstance();
		$bind = array(
			':alumno' => $user,
			':modulo' => $modulo
		);

		$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno ORDER BY fecini DESC";


		/*
		echo $sql;
		print_r($bind);*/


		$cont = $db->run($sql, $bind);

		if ($cont == 0) {



			$db1 = Db::getInstance();
			$data1 = array(
				'alumno' => $user,
				'modulo' => $modulo,
				'nota' => '10',
				'aprobado' => '1',
				'estado' => '1',
				'fecini' => '2020-12-15 00:00:00',
				'fecfin' => '2020-12-15 00:00:00',
				'pag' => '1',
				'forzar_cierre' => 1
			);
			//print_r($data1);
			$db1->insert('com_alumnos_exam', $data1);
			//$this->id = $db1->lastInsertId();

		}
	}

	private function seleccionarPreguntas($id)
	{

		$db = Db::getInstance();


		$sql = "SELECT com_exam_preg.* FROM com_exam_preg"
			. " WHERE com_exam_preg.modulo = :modulo";
		$sql .= " ORDER BY com_exam_preg.orden1";
		$bind = array(
			':modulo' => $this->modulo
		);
		/*echo $sql;
		print_r($bind);*/

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {

			//echo "no hay preguntas";
			$row_p = "";
		} else {

			//echo "si hay preguntas";

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			$x = 0;
			//$num = 40;
			$num = Modulo::getCantPreg($this->modulo);

			while ($x < $num) {
				$max = count($row_p);
				$num_aleatorio = rand(0, $max);
				if (!in_array($row_p[$num_aleatorio], $valores)) {
					array_push($valores, $row_p[$num_aleatorio]);


					$db2 = Db::getInstance();
					$sql2 = "SELECT com_alumnos_resp.id FROM com_alumnos_resp WHERE id_exam_mod=:id_exam_mod AND pregunta = :pregunta AND alumno = :alumno";
					$data2 = array(
						'id_exam_mod' => $this->id,
						'pregunta' => $row_p[$num_aleatorio]['id'],
						'alumno' => $this->alumno,

					);
					$cont2 = $db2->run($sql2, $data2);
					if ($cont2 >= 20) {
						$x = 20;
					} else {
						if (!empty($row_p[$num_aleatorio]['id'])) {
							$data = array(
								'id_exam_mod' => $this->id,
								'pregunta' => $row_p[$num_aleatorio]['id'],
								'alumno' => $this->alumno,
								'fecha' => date('Y-m-d H:i:s'),
								'orden' => $x,
								'valor' => $num_aleatorio
							);
							$db->save('com_alumnos_resp', $data, "id_exam_mod=:id_exam_mod AND pregunta = :pregunta AND alumno = :alumno", array('id_exam_mod' => $this->id, 'pregunta' => $row_p[$num_aleatorio]['id'], 'alumno' => $this->alumno));
							unset($row_p[$num_aleatorio]);
							$row_p = array_values($row_p);
							$x++;
						}
					}
				}
			}
		}
	}
	public function checkPlazo()
	{

		$mod = new Modulo();
		$mod->alumno = $this->alumno;
		//echo $this->modulo;
		$modulo = $mod->getOne($this->modulo);

		//print_r($modulo);


		$acred_hasta = $modulo[0]['acred_hasta'] . " 23:59:59";

		//echo $acred_hasta;

		$acred_hasta1 = strtotime($acred_hasta . "+ 3 hours");
		$acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
		//echo "acreditado hasta".$acred_hasta;




		$sql = "SELECT * FROM com_cursos_registro WHERE usuario = :alumno AND curso = :curso LIMIT 1";
		$bind = array(
			':alumno' => $this->alumno,
			':curso' => $this->curso
		);

		$db = Db::getInstance();
		$cont = $db->run($sql, $bind);


		if ($cont == 0) {

			//echo "No encontro registro";

		} else {


			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			//$fecha = $row_p[0]['fecin'];
			$duracion_alum_mod = strtotime($row_p[0]['fecfin']);
		}


		$mod_date = date("Y-m-d H:i:s", $duracion_alum_mod);

		//echo $mod_date."<br>";

		if ($acred_hasta < $mod_date) {
			$fec_alum_mod = $acred_hasta;
		} else {
			$fec_alum_mod = $mod_date;
		}
		/* echo $acred_hasta ." < ". $mod_date;
										echo "<br>".$fec_alum_mod;*/

		//$fec_alum_mod = $acred_hasta;

		/*echo $fec_alum_mod."<br>";
		echo date('Y-m-d H:i:s');*/

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

		//echo "Duracion".$duracion;

		if ($duracion == '-') {
			$this->forzar_cierre = 1;
			$this->cerrarExam();
			return 1;
		} else {
			$this->duracion = $duracion;
			return 0;
		}
	}

	public function cerrarExam($id = 0)
	{
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

			foreach ($row_p as $row_p1) {
				$db_preg = null;
				$db_preg = Db::getInstance();
				$sql_preg = "SELECT com_exam_preg.*, com_alumnos_resp.respuesta AS user_resp FROM com_exam_preg INNER JOIN com_alumnos_resp ON com_exam_preg.id = com_alumnos_resp.pregunta WHERE com_exam_preg.modulo=:modulo AND com_alumnos_resp.alumno = :alumno AND com_alumnos_resp.id_exam_mod = :id_exam_mod";
				$bind_preg = array(
					':modulo' => $this->modulo,
					':alumno' => $this->alumno,
					':id_exam_mod' => $this->id

				);
				if ($db_preg->run($sql_preg, $bind_preg) > 0) {

					$db_preg1 = null;
					$db_preg1 = Db::getInstance();
					$row_preg = $db_preg1->fetchAll($sql_preg, $bind_preg);


					foreach ($row_preg as $row_men3) {
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

							foreach ($row_resp as $row_men4) {
								$nota = $nota + $row_men4['correcta'];
							}
						}
					}
				}

				//
				$mod = new Modulo();
				$mod->alumno = $this->alumno;
				//echo "modulo".$this->modulo;

				$elMod = $mod->getOne($this->modulo);
				//print_r($mod->row);

				//echo $elMod[0]['preg_aprob']." - ".$nota;
				if ($elMod[0]['preg_aprob'] <= $nota) {
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
					'fecfin' => date('Y-m-d H:i:s'),
					'forzar_cierre' => $this->forzar_cierre
				);

				$db_up->update('com_alumnos_exam', $data_up, 'id = :id', array(':id' => $row_p1['id']));


				// finalizamos el modulo

			}
		}
	}

	public function getEstado()
	{

		$this->aprobado = 0;

		$db = Db::getInstance();
		$bind = array(
			':alumno' => $this->alumno,
			':modulo' => $this->modulo
		);

		$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno ORDER BY fecini DESC";


		/*
		echo $sql;
		print_r($bind);*/


		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			//$this->iniciarExamen();

			$this->id = "";
			$this->nota = "";
			$this->fecfin = "";
			return  5;
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$this->id = $row_p[0]['id'];
			$this->nota = $row_p[0]['nota'];
			$this->fecfin = $row_p[0]['fecfin'];
			//echo "fecha fin: ".$this->fecfin;

			$this->pagactual = $row_p[0]['pag'];
			/*print_r($row_p);
            echo "<br>aprobado: ".$row_p[0]['aprobado'];*/

			if ($row_p[0]['estado'] == 0) {
				$fechaPlazo = strtotime(date('Y-m-d H:i:s'));
				$mod_date = date("Y-m-d H:i:s", $fechaPlazo);

				$fechaini = $row_p[0]['fecini'];
				$fechaPlazoini = strtotime($fechaini . "+ 1 days");
				$fechaini24 = date("Y-m-d H:i:s", $fechaPlazoini);


				//echo $mod_date." - fecha ini: ".$fechaini24;
				if ($mod_date > $fechaini24) {
					//echo "Se cierra";
					$this->forzar_cierre = 1;
					$this->cerrarExam($row_p[0]['id']);
					$this->getEstado();
				} else {
					$this->plazo_examen = $fechaini24;
					return  1;
				}
			} else if ($cont == 1 && $row_p[0]['estado'] == 1) {
				$this->fecfin = $row_p[0]['fecfin'];
				$this->nota = $row_p[0]['nota'];
				if ($row_p[0]['aprobado'] == 1) {
					$this->aprobado = 1;
					return $this->respondioEncuesta();
				} else {
					return 2;
				}
			} else if ($cont > 1 && $row_p[0]['estado'] == 1) {
				$this->fecfin = $row_p[0]['fecfin'];
				$this->nota = $row_p[0]['nota'];
				$this->id = $row_p[0]['id'];
				if ($row_p[0]['aprobado'] == 1) {
					$this->aprobado = 1;
				}
				return $this->respondioEncuesta();
			}
		}
	}

	public function respondioEncuesta()
	{
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



	public function getExam($capitulo)
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
			for ($i = 0; $i < $longitud; $i++) {

				//echo $row_p1['nombre'] ;
				$row_p[$i]['porcentaje'] = $this->porcentajeAlumno($row_p[$i]['id'], 1);


				$conty++;
			}
			//$this->row_p = $row_p;
			$this->row = $row_p;
		}
	}


	public function getPreg($result = 0)
	{

		$db = Db::getInstance();
		$bind = array(
			':modulo' => $this->modulo
		);
		$sql = "SELECT com_exam_preg.*, com_alumnos_resp.respuesta, com_alumnos_resp.correcta AS alum_correc FROM com_exam_preg"
			. " INNER JOIN com_alumnos_resp ON com_exam_preg.id = com_alumnos_resp.pregunta"
			. " WHERE com_exam_preg.modulo = :modulo AND com_alumnos_resp.id_exam_mod = :id_examen AND com_alumnos_resp.alumno = :alumno";
		if ($result == 0) {
			//$sql .= " AND com_exam_preg.pagina = :pagina";

			//$bind[":pagina"] = $this->pagina;


			//$sql .= " GROUP BY com_exam_preg.id ORDER BY com_alumnos_resp.orden";
			$sql .= " ORDER BY com_alumnos_resp.orden";
		} else {
			//$sql .= " GROUP BY com_exam_preg.id ORDER BY com_alumnos_resp.orden";
			$sql .= " ORDER BY com_alumnos_resp.orden";
		}




		$bind[":modulo"] = $this->modulo;
		$bind[":id_examen"] = $this->id;
		$bind[":alumno"] = $this->alumno;


		if ($this->origen == "examen") {
			$total_results = $db->run($sql, $bind);
			$total_pages = ceil($total_results / $this->limit);
			$this->total_pages = $total_pages;


			$starting_limit = ($this->pag) * $this->limit;

			$sql .= " LIMIT " . $starting_limit . "," . $this->limit;
		}




		/*echo $sql;
		print_r($bind);*/



		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			//echo "Preguntas";



			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			//print_r($row_p);
			$conty = 0;
			$longitud = count($row_p);
			for ($i = 0; $i < $longitud; $i++) {

				// leemos todas las respuestas posibles
				$dbp0 = Db::getInstance();
				$sqlp0 = "SELECT * FROM com_exam_resp WHERE pregunta = :pregunta ORDER BY id";
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

					foreach ($row_p10 as $row_p101) {
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
					$row_p[$i]['alumn_corr'] = $row_p1[0]["correcta"];
				}

				// terminamos de leer la respuesta del usuario





				$conty++;
			}
			//$this->row_p = $row_p;
			$this->preg = $row_p;
		}
	}

	public function guardarResp($preg, $resp)
	{
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

	private function getRespRes($resp)
	{
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

	public function actualizarExam()
	{
		$dbp0 = null;
		$dbp0 = Db::getInstance();
		$sqlp0 = "SELECT * FROM com_exam_preg WHERE modulo = :modulo ORDER BY id";

		$bindp0 = array(
			':modulo' => $this->modulo
		);

		// MODIFICAR AQUI CUANDO SEAN OTRO NUMERO DE PREGUNTAS, REVISAR EN LA TABLA DEL MODULO LA CANTIDAD DE PREGUNTAS TOTALES
		//$contp0 = $dbp0->run($sqlp0, $bindp0);

		//$contp0 = 40;

		$contp0 = Modulo::getCantPreg($this->modulo);

		$db = null;
		$db = Db::getInstance();


		$sql = "SELECT com_alumnos_resp.* FROM com_alumnos_resp
						LEFT JOIN com_exam_preg ON com_exam_preg.id = com_alumnos_resp.pregunta
						 WHERE com_alumnos_resp.id_exam_mod = :id_exam_mod AND com_alumnos_resp.alumno = :alumno AND com_exam_preg.modulo = :modulo AND com_alumnos_resp.respuesta <> 0";

		$bind = array(
			':id_exam_mod' => $this->id,
			':alumno' => $this->alumno,
			':modulo' => $this->modulo
		);


		$cont = $db->run($sql, $bind);
		//echo "preguntas contestadas:".$cont ."== totales". $contp0;
		if ($cont == $contp0 && $this->actionBoton == 'fin') {
			//echo "ya contesto todas las preguntas";
			$this->cerrarExam($this->id);
			$this->estadoExamen = 1;
		} else {
			//echo "son: ".$contp0." y contesto: ".$cont."<br>";
			$this->cambiarPagina($this->id, $this->pagNext);
			$this->preguntasTotales = $contp0;
			$this->preguntasRespondidas = $cont;
			$this->estadoExamen = 0;
		}
	}




	private function cambiarPagina($id, $pag)
	{

		$db = Db::getInstance();
		$data = array(
			'pag' => $pag

		);
		//$db->insert('com_proyectos', $data);

		$db->update("com_alumnos_exam", $data, 'id = :id', array(':id' => $this->id));
	}

	static function estadoExamenPag($modulo, $pagina, $alumno)
	{
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

		/*echo $sql;
		print_r($bind);*/

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			//echo "encontro 1";

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			$this->row = $row_p;
		}
	}


	public function getCertificadoValido($clave)
	{



		$db = Db::getInstance();
		$bind = array(
			':clave' => $clave
		);

		$sql = "SELECT com_alumnos_exam.*, com_registro.nombre, com_registro.ape1, com_registro.ape2, com_cursos.titulo  FROM com_alumnos_exam INNER JOIN com_registro ON com_registro.id = com_alumnos_exam.alumno INNER JOIN com_cursos_mod ON com_alumnos_exam.modulo = com_cursos_mod.id INNER JOIN com_cursos ON com_cursos.id=com_cursos_mod.curso WHERE com_alumnos_exam.clave=:clave";


		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			//$this->iniciarExamen();
			return  0;
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}


	static function getEstadoUser($user, $modulo)
	{



		$db = Db::getInstance();
		$bind = array(
			':alumno' => $user,
			':modulo' => $modulo
		);

		$sql = "SELECT * FROM com_alumnos_exam WHERE modulo=:modulo AND alumno = :alumno ORDER BY fecini DESC";


		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			//$this->iniciarExamen();
			return  "Examen no iniciado";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			if ($row_p[0]['estado'] == 1) {
				if ($row_p[0]['aprobado'] == 1) {
					return "<span class=\"verde\">Examen aprobado</span>";
				} else {
					return "<span class=\"rojo\">Examen reprobado</span>";
				}
			} else {
				/*$this->id = $row_p[0]['id'];
				$this->nota = $row_p[0]['nota'];

				$this->pagactual = $row_p[0]['pag'];*/
				/*print_r($row_p);
            	echo "<br>aprobado: ".$row_p[0]['aprobado'];*/
				return "Examen NO FINALIZADO";
			}
		}
	}

	public function getQRcode()
	{
		$db = Db::getInstance();
		$bind = array(
			':id' => $this->id
		);

		$sql = "SELECT * FROM com_alumnos_exam WHERE id=:id LIMIT 1";


		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			//$this->iniciarExamen();
			//	return  "Examen no iniciado";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			if (!empty($row_p[0]['clave'])) {
				return $row_p[0]['clave'];
			} else {
				$clave = uniqid();
				$db = Db::getInstance();
				$data = array(
					'clave' => $clave
				);

				$db->update('com_alumnos_exam', $data, 'id = :id', array(':id' => $this->id));
				return $clave;
			}
		}
	}

	public function generateQR($codigo)
	{
		$tempDir = $_SERVER['DOCUMENT_ROOT'] . "/qr/";

		$codeContents = 'https://fechida.c-pulpro.com/qr.php?codigo=' . $codigo;
		$nameContents = $codigo;
		$this->codigoValid = $codigo;

		// we need to generate filename somehow, 
		// with md5 or with database ID used to obtains $codeContents...
		$fileName = 'qr_' . md5($nameContents) . '.png';

		$pngAbsoluteFilePath = $tempDir . $fileName;
		$urlRelativeFilePath = "/qr/" . $fileName;
		$urlRelativeFilePath1 = "qr/" . $fileName;

		// generating
		//if (!file_exists($pngAbsoluteFilePath)) {
		QRcode::png($codeContents, $pngAbsoluteFilePath);
		//}

		return $urlRelativeFilePath1;
		//echo '<img src="'.$urlRelativeFilePath.'" />';
	}

	public function descargarDiploma($usuario, $certificado)
	{
	}

	public function guardarEncuesta($ep1, $ep2, $ep3, $ep4, $ep5, $ep6, $ep7, $epr, $modulo, $curso, $alumno)
	{

		$db1 = null;
		$db1 = Db::getInstance();
		$data1 = array(
			'curso' => $curso,
			'alumno' => $alumno,
			'modulo' => $modulo,
			'p1' => $ep1,
			'p2' => $ep2,
			'p3' => $ep3,
			'p4' => $ep4,
			'p5' => $ep5,
			'p6' => $ep6,
			'p7' => $ep7,
			'fecha' => date('Y-m-d H:i:s')
		);
		//print_r($data1);
		$db1->insert('com_encuesta', $data1);

		$id = $db1->lastInsertId();

		foreach ($epr as $clave => $valor) {
			$db2 = null;
			$db2 = Db::getInstance();
			$data2 = array(
				'idencuesta' => $id,
				'profesor' => $clave,
				'respuesta' => $valor
			);
			//print_r($data1);
			$db2->insert('com_encuesta_docente', $data2);
		}
		return "Ok";
	}



	public function getAllEncuesta()
	{
		$db = Db::getInstance();
		$bind = array(
			':id' => $this->id
		);

		$sql = "SELECT * FROM com_encuesta ORDER BY p5 DESC LIMIT 10";


		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			//$this->iniciarExamen();
			//	return  "Examen no iniciado";
		} else {
			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p;
		}
	}
}
