<?php
class Presenciales
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 20;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

	public $img_ppl;

	public $cnt_img_ppl;

	private $interfaz;


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_presenciales";
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

	public function agregarAlumno($datos)
	{

		//echo $datos['nombre']." - ".$datos['dni']. " - ". $datos['ape1']. " - ".$datos['email'];
		if (empty($datos['nombre']) || empty($datos['dni']) || empty($datos['ape1']) || empty($datos['email'])) {
			return 0;
		} else {

			$clave00 = uniqid();

			$db = Db::getInstance();
			$data = array(
				'ape1' => $datos['ape1'],
				'ape2' => $datos['ape2'],
				'nombre' => $datos['nombre'],
				'email' => $datos['email'],
				'dni' => $datos['dni'],
				'dni1' => $datos['dni1'],
				'pais' => $datos['pais'],
				'region' => $datos['region'],
				'telefono' => $datos['telefono'],
				'clave' => $datos['clave'],
				'pass' => $datos['pass'],
				'club' => $datos['club'],
				'genero' => $datos['genero'],
				'fecnac' => $datos['fecnac'],
				'tipouser' => $datos['tipouser']
			);
			$db->insert('com_registro', $data);
			return $db->lastInsertId();
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



	public function getAll($tipo = '')
	{

		$db = Db::getInstance();

		if (empty($this->escuela)) {


			$sql = "SELECT " . $this->tabla . ".* FROM " . $this->tabla . " WHERE " . $this->tabla . ".id > :id AND " . $this->tabla . ".estado = 1";
			$bind = array(
				':id' => '0'
			);
		} else {
			$tipo = 'todos';

			$sql = "SELECT " . $this->tabla . ".* FROM " . $this->tabla . " INNER JOIN com_escuelas_cursos ON " . $this->tabla . ".id = com_escuelas_cursos.curso WHERE " . $this->tabla . ".id > :id AND " . $this->tabla . ".estado = 1 AND com_escuelas_cursos.escuela = :escuela GROUP BY " . $this->tabla . ".id, com_escuelas_cursos.orden ORDER BY com_escuelas_cursos.orden";
			$bind = array(
				':id' => '0',
				':escuela' => $this->escuela
			);
		}



		if ($tipo == 'todos') {
		} else {
			$total_results = $db->run($sql, $bind);
			$total_pages = ceil($total_results / $this->limit);
			$this->total_pages = $total_pages;


			$starting_limit = ($this->pag - 1) * $this->limit;

			if (empty($this->orden)) {
				if (empty($this->escuela)) {
					$orden = $this->tabla . ".orden";
				} else {
					$orden = "com_escuelas_cursos.orden";
				}
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


		/*echo $sql;
	print_r($bind);*/




		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			/*foreach($row_p as $row_p1) {
					  $conty++;				
					}*/
			return $row_p;
		}
	}




	public function getAllByUser($usuario, $estado = 1)
	{

		$db = Db::getInstance();


		$sql = "SELECT " . $this->tabla . ".* FROM " . $this->tabla . " INNER JOIN com_presenciales_registro ON com_presenciales_registro.curso = " . $this->tabla . ".id WHERE " . $this->tabla . ".id > :id AND " . $this->tabla . ".estado >= :estado AND com_presenciales_registro.usuario = :usuario";
		$bind = array(
			':id' => 0,
			':usuario' => $usuario,
			':estado' => $estado
		);

		/*
		echo $sql;
		print_r($bind);
		*/


		$cont = $db->run($sql, $bind);
		if ($cont == 0) {

			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$conty = 0;
			/*foreach($row_p as $row_p1) {
					  $conty++;				
					}*/
			return $row_p;
		}
	}

	public function getUsuarios()
	{

		$db = Db::getInstance();

		$sql = "SELECT com_registro.*,com_regiones.region,GROUP_CONCAT(cocu.titulo) AS cursos
                FROM com_registro 
                JOIN com_regiones on com_regiones.id = com_registro.region
                LEFT JOIN com_presenciales_registro cure on cure.usuario = com_registro.id 
                LEFT JOIN com_presenciales cocu on cocu.id = cure.curso
                GROUP BY com_registro.id
                ORDER BY com_registro.id ASC";

		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql);
			return $row_p;
		}
	}

	public function reporteAlumnos()
	{

		$db = Db::getInstance();

		$sql = "SELECT core.id,core.nombre,core.ape1,core.ape2,core.email,core.dni,reg.region,GROUP_CONCAT(cocu.titulo,'-',cocu.ciclo SEPARATOR ',') AS cursos FROM com_registro core 
                JOIN com_presenciales_registro cure on cure.usuario = core.id 
                LEFT JOIN com_presenciales cocu on cocu.id = cure.curso
                JOIN com_regiones reg on reg.id = core.region
                GROUP BY core.id ORDER BY core.id ASC";

		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql);
			return $row_p;
		}
	}

	public function getRegiones()
	{

		$db = Db::getInstance();

		$sql = "SELECT id,region FROM com_regiones ORDER BY id ASC";

		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql);
			return $row_p;
		}
	}

	public function getPaises()
	{

		$db = Db::getInstance();

		$sql = "SELECT id,pais, predeterminado FROM com_paises ORDER BY pais ASC";

		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql);
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

	public function getDocentes($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_cursos_docentes WHERE curso = :id ORDER BY orden";
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

	public function guardarEncuesta($p1, $p2, $p3, $p4, $p5, $p6)
	{

		$db1 = null;
		$db1 = Db::getInstance();
		$data1 = array(
			'alumno' => $this->alumno,
			'modulo' => $this->row[0]['id'],
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




	static function getCursosPreinscritos($usuario)
	{
		$db = Db::getInstance();
		$sql = "SELECT com_presenciales_registro.*,  com_presenciales.id AS idC, com_presenciales.acred_prere,  com_presenciales.titulo,  com_presenciales.precio,  com_presenciales.precio1,  com_presenciales.precio2,  com_presenciales.precio3,  com_presenciales.acred_pre, com_presenciales.mailingID, com_presenciales.ciclo, com_presenciales.fecha, com_presenciales.plazo FROM com_presenciales_registro INNER JOIN com_presenciales ON com_presenciales_registro.curso = com_presenciales.id WHERE com_presenciales_registro.usuario = :usuario AND com_presenciales_registro.estado = 0 AND com_presenciales_registro.estadopago = 0";
		$bind = array(
			':usuario' => $usuario
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p;
			//return 1;
		}
	}

	static function getCursosSinPrerequisitos($usuario)
	{
		$db = Db::getInstance();
		$sql = "SELECT com_presenciales_registro.*,  com_presenciales.id AS idC, com_presenciales.acred_prere,  com_presenciales.titulo,  com_presenciales.precio,  com_presenciales.precio1,  com_presenciales.precio2,  com_presenciales.precio3,  com_presenciales.acred_pre FROM com_presenciales_registro INNER JOIN com_presenciales ON com_presenciales_registro.curso = com_presenciales.id WHERE com_presenciales_registro.usuario = :usuario AND com_presenciales_registro.estado = 0 AND com_presenciales_registro.validprerequisitos = 0";
		$bind = array(
			':usuario' => $usuario
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p;
			//return 1;
		}
	}

	static function aceptarPrerequisitos($curso, $usuario, $data4)
	{

		$db4 = Db::getInstance();


		$db4->update('com_presenciales_registro', $data4, 'curso = :curso AND usuario = :usuario', array(':curso' => $curso, ':usuario' => $usuario));
	}

	static function actualizarPago($curso, $usuario, $data4)
	{

		$db4 = Db::getInstance();


		$db4->update('com_presenciales_registro', $data4, 'curso = :curso AND usuario = :usuario', array(':curso' => $curso, ':usuario' => $usuario));
	}

	static function actualizarPagoG($idpago, $usuario, $data4)
	{

		$db4 = Db::getInstance();


		$db4->update('com_pagos', $data4, 'id = :id', array(':id' => $idpago));
	}

	static function updateIDPagoTransf($usuario, $idregistro, $idpago)
	{

		echo $usuario . " - " . $idregistro . " - " . $idpago;
		$db4 = Db::getInstance();
		$data4 = array(
			'idpago' => $idpago
		);


		$db4->update('com_presenciales_registro', $data4, 'id = :id AND usuario = :usuario', array(':id' => $idregistro, ':usuario' => $usuario));
	}

	static function checkInscritoCurso($id, $usuario)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_presenciales_registro WHERE curso = :id AND usuario = :usuario LIMIT 1";
		$bind = array(
			':id' => $id,
			':usuario' => $usuario
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
			return 0;
		} else {

			/*$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
                    return $row_p;*/
			return 1;
		}
	}


	static function getInscritoCurso($id, $usuario)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_presenciales_registro WHERE curso = :id AND usuario = :usuario LIMIT 1";
		$bind = array(
			':id' => $id,
			':usuario' => $usuario
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
			return 0;
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p;
			//return 1;
		}
	}

	static function updateFechasInicio($id,$usuario,$data4) {

		$db = Db::getInstance();
		

		$fecha = date('Y-m-d H:i:s');

		$db->update('com_presenciales_registro', $data4, 'id = :id AND usuario = :usuario', array(':id' => $id, ':usuario' => $usuario));

	}
    

	public function preinscribir($id, $usuario, $estado, $tipouser, $prerequisitos = 0, $fecini = Null, $fecfin = Null)
	{

		$verificar = Presenciales::checkInscritoCurso($id, $usuario);

		if ($verificar == 0) {

			$db1 = null;
			$db1 = Db::getInstance();
			$data1 = array(
				'curso' => $id,
				'usuario' => $usuario,
				'tipouser' => $tipouser,
				'estado' => $estado,
				'fecha' => date('Y-m-d H:i:s'),
				'validprerequisitos' => $prerequisitos,
				'fecpreins' => date('Y-m-d H:i:s'),
				'fecini' => $fecini,
				'fecfin' => $fecfin
			);
			//print_r($data1);
			$db1->insert('com_presenciales_registro', $data1);
		}
	}

	public function getComentarios($curso, $modulo)
	{
		$db = Db::getInstance();
		$sql = "SELECT comco.id,GROUP_CONCAT(core.nombre,' ',core.ape1,' ',core.ape2) as usuario,comco.comentario,comco.fecha,comco.principal,comco.respuesta 
                FROM com_comentarios comco
                JOIN com_registro core on core.id = comco.usuario
                WHERE comco.curso = :curso AND comco.modulo = :modulo AND principal = 1
                GROUP BY comco.comentario,comco.fecha,comco.principal,comco.respuesta,comco.id
                ORDER BY comco.id ASC";

		$bind = array(
			':curso' => $curso,
			':modulo' => $modulo
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

	static function validPrerequisitos($curso, $usuario)
	{
		$result = array();

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_presenciales_registro WHERE curso = :id AND usuario = :usuario LIMIT 1";
		$bind = array(
			':id' => $curso,
			':usuario' => $usuario
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
			//result = "";

		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			$result['documentos'] = array();

			$result['estado'] = $row_p[0]['validprerequisitos'];

			//return 1;

			// carga los documentos
			$db0 = Db::getInstance();
			$sql0 = "SELECT * FROM com_cursos_requisitos WHERE curso = :id AND usuario = :usuario LIMIT 1";
			$bind0 = array(
				':id' => $curso,
				':usuario' => $usuario
			);

			$cont0 = $db0->run($sql0, $bind0);
			if ($cont0 == 0) {
				$row_p = "";
				//return 0;
			} else {

				$db10 = Db::getInstance();
				$row_p0 = $db10->fetchAll($sql0, $bind0);
				$result['documentos'] = $row_p0[0];

				//return 1;
			}

			// termina los documentos
		}

		return $result;
	}

	static function subirPrerequisito($curso, $usuario, $valor, $ext, $nombre)
	{

		$db = Db::getInstance();
		$data = array(
			'curso' => $curso,
			'usuario' => $usuario,
			'codigo' => $valor,
			'nombre' => $nombre,
			'ext' => $ext,
			'fecha' => date('Y-m-d H:i:s')
		);

		/*
	$chequeo = "empezamos";
	$file = fopen("archivo.txt", "w");

fwrite($file, $chequeo." curso ".$curso." . usuario ".$usuario." . peso".$valor." . extension".$ext);

fclose($file);*/


		$db->insert('com_cursos_requisitos', $data);
		return $db->lastInsertId();
	}

	static function getPrerequisito($curso, $usuario)
	{


		$db = Db::getInstance();
		$sql = "SELECT * FROM com_cursos_requisitos WHERE curso = :curso AND usuario = :usuario";
		$bind = array(
			':curso' => $curso,
			':usuario' => $usuario
		);

		/*echo $sql;
		print_r($bind);*/

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			$row_p = "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p;
		}
	}


	static function subirTransferencia($idpago, $usuario, $valor, $ext, $nombre)
	{

		$ruta = "trans_" . $idpago . "_" . $usuario . "_" . $valor . "." . $ext;

		$db = Db::getInstance();
		$data = array(
			'comprobante' => 1,
			'comprobante_ext' => $ruta,
			'fecha' => date('Y-m-d H:i:s')
		);

		$fecha = date('Y-m-d H:i:s');

		$db->update('com_pagos', $data, 'id = :id', array(':id' => $idpago));

		Presenciales::enviarEmail($usuario, $fecha, 0, 2);
	}

	static function activarCurso($curso, $usuario, $tipouser, $monto)
	{

		$db = Db::getInstance();
		$data = array(
			'tipouser' => $tipouser,
			'estado' => 1,
			'monto' => $monto,
			'fecha' => date('Y-m-d H:i:s')
		);

		$fecha = date('Y-m-d H:i:s');

		$db->update('com_presenciales_registro', $data, 'curso = :curso AND usuario = :usuario', array(':curso' => $curso, ':usuario' => $usuario));
	}


	static function registrarPago($user, $cursos, $fechoy, $usu_tipo, $tipopago, $monto)
	{


		$db = Db::getInstance();
		$data = array(
			'cursos' => $cursos,
			'usuario' => $user,
			'tipouser' => $usu_tipo,
			'tipopago' => $tipopago,
			'fecha' => $fechoy,
			'monto' => $monto
		);



		$db->insert('com_pagos', $data);
		return $db->lastInsertId();
	}

	static function elimPreins($id, $usuario)
	{

		$db = Db::getInstance();

		$db->delete('com_presenciales_registro', "id=:id AND usuario=:usuario AND estadopago = 0 AND estado = 0", array(':id' => $id, ':usuario' => $usuario));
	}



	static function elimFormaPago($id, $usuario)
	{


		$nota = "forma de pago modificada del usuario " . $usuario;

		$db = Db::getInstance();
		$data = array(
			'usuario' => 0,
			'nota' => $nota
		);

		//$fecha = date('Y-m-d H:i:s');

		$db->update('com_pagos', $data, 'id = :id AND usuario = :usuario AND estadopago = 0', array(':id' => $id, ':usuario' => $usuario));

		$db0 = Db::getInstance();
		$data0 = array(
			'idpago' => 0
		);

		//$fecha = date('Y-m-d H:i:s');

		$db0->update('com_presenciales_registro', $data0, 'idpago = :id AND usuario = :usuario AND estadopago = 0', array(':id' => $id, ':usuario' => $usuario));
	}


	static function enviarEmail($user, $fecha, $monto, $tipo)
	{

		$datosUser = Alumno::getDatos($user);
		$mailhost = "smtp-pulse.com";
		$maillogin = "filipputti@pulpro.com";
		$mailpass = "mkKfm45Ynr";
		$mailemail = "info@pulpro.com";
		$mailport = 587;
		$mailsecure = "tls";
		$mailfrom = "Capacitaciones PULPRO";

		require('includes/class.phpmailer.php');
		require('includes/class.smtp.php');

		if ($tipo == 1) {

			$nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
			<tr>
			 <td valign=\"top\" align=\"center\"><img src=\"" . $app_url . "img/logo.png\" alt=\"" . $apptitle . "\" width=\"266\" /></td>
			</tr>
			<tr>
			 <td valign=\"top\" align=\"left\">
				 <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
				 <tr>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				 
				   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br><br>
					Estimado/a  " . $datosUser['nombre'] . " " . $datosUser['ape1'] . " " . $datosUser['ape2'] . " <br /><br />
					  ";



			$nota .= "<br>Para finalizar tu inscripción debes transferir " . $monto . " a la siguiente cuenta:<br>
					Banco Estado<br>
																		Capacitaciones PULPRO Spa.<br>
																		Cuenta Vista<br>
																		No. de cuenta: 918-7-010683-7<br>
																		RUT: 77.189.514-k<br>
																		Email: capacitaciones@pulpro.com</font><br><br>
					 </font>
					</td>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				 </tr>
				 
				
				 
				 <tr>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
				   Muchas gracias por su participacion.<br><br>
	
	Cordialmente,<br><br>
	Alianza FECHIDA - Capacitaciones Pulpro
	<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
					</font>
	
	
	
					</td>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				 </tr>
	
				 </table>
			 </td>
			</tr>
	
			</table>";
		} else if ($tipo == 2) {

			$nota = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
			<tr>
			 <td valign=\"top\" align=\"center\"><img src=\"" . $app_url . "img/logo.png\" alt=\"" . $apptitle . "\" width=\"266\" /></td>
			</tr>
			<tr>
			 <td valign=\"top\" align=\"left\">
				 <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
				 <tr>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				 
				   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br><br>
					Estimado/a  " . $datosUser['nombre'] . " " . $datosUser['ape1'] . " " . $datosUser['ape2'] . " <br /><br />
					  ";



			$nota .= "<br>Hemos recibido el comprobante de la transferencia:<br>
		En breve serán verificados los datos y se concretará la inscripcion en el (los) curso(s) seleccionados.
					</font><br><br>
					 </font>
					</td>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				 </tr>
				 
				
				 
				 <tr>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				   <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
				   Muchas gracias por su participacion.<br><br>
	
	Cordialmente,<br><br>
	Alianza FECHIDA - Capacitaciones Pulpro
	<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
					</font>
	
	
	
					</td>
				   <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
				 </tr>
	
				 </table>
			 </td>
			</tr>
	
			</table>";
		}


		$mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->SMTPDebug = 0;
		// 0 = no output, 1 = errors and messages, 2 = messages only.


		/* Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP*/
		$mail->Host = $mailhost;
		if (!empty($mailsecure)) {
			$mail->SMTPSecure = $mailsecure;
		}
		if (!empty($mailport)) {
			$mail->Port = $mailport;
		}




		$mail->From = $mailemail;
		$mail->CharSet = 'UTF-8';

		$mail->FromName = $mailfrom;

		$mail->Subject = "Inscripcion curso";

		$mail->AltBody = "Inscripcion curso";
		$mail->IsHTML(true);

		$mail->MsgHTML($nota);

		/* Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. admin@domitienda.com  */


		$mail->AddAddress($datosUser['email'], $datosUser['email']);
		//$mail->AddBCC('gianna@tba.es', 'test');

		$mail->SMTPAuth = true;


		$mail->Username = $maillogin;
		$mail->Password = $mailpass;


		if (!$mail->Send()) {

			//header("Location: gracias.php?err=1");
			return "2";
		} else {
			// header("Location: gracias.php");
			return "1";
		}
	}


	static function getInfoPago($id, $alumno)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_pagos WHERE id = :id AND usuario = :alumno ORDER BY estado DESC, fecha DESC LIMIT 1";
		$bind = array(
			':id' => $id,
			':alumno' => $alumno
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p;
		}
	}


	static function getUltPago($alumno)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_pagos WHERE usuario = :alumno ORDER BY fecha DESC LIMIT 1";
		$bind = array(
			':alumno' => $alumno
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p[0];
		}
	}

	static function getPagoOne($id)
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_pagos WHERE id = :id ORDER BY fecha DESC LIMIT 1";
		$bind = array(
			':id' => $id
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			return $row_p[0];
		}
	}


	public function getRespuestas($curso, $modulo)
	{
		$db = Db::getInstance();
		$sql = "SELECT GROUP_CONCAT(core.nombre,' ',core.ape1,' ',core.ape2) as usuario,comco.comentario,comco.fecha,comco.principal,comco.respuesta 
                FROM com_comentarios comco
                JOIN com_registro core on core.id = comco.usuario
                WHERE comco.curso = :curso AND comco.modulo = :modulo AND principal = 0
                GROUP BY comco.comentario,comco.fecha,comco.principal,comco.respuesta
                ORDER BY comco.fecha ASC";

		$bind = array(
			':curso' => $curso,
			':modulo' => $modulo
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
	public function getComResp($curso, $modulo)
	{
		$db = Db::getInstance();
		$sql = "SELECT count(*) as total_mensajes FROM com_comentarios WHERE curso = :curso AND modulo = :modulo LIMIT 1";
		$bind = array(
			':curso' => $curso,
			':modulo' => $modulo
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
	public function reporteAlumnos_3($id, $estado)
	{
		if ($estado == 'pagado') {
			$sqlAdd = "AND (cure.estadopago = 2 OR cure.estado = 1)";
		} else if ($estado == 'aceptado') {
			$sqlAdd = "AND (cure.estado > 0)";
		} else {
			$sqlAdd = "";
		}



		$db = Db::getInstance();

		$sql = "SELECT core.id, core.nombre,core.ape1,core.ape2,core.email,core.dni,core.telefono,core.clave,core.genero,core.tipouser,reg.region,cocu.titulo AS cursos, cure.estado, cure.estadopago, cure.validprerequisitos, cure.idpago, cure.floworder, cocu.acred_pre, cocu.ciclo, cure.porcentaje AS porcCurso FROM com_registro core 
		JOIN com_presenciales_registro cure on cure.usuario = core.id 
		JOIN com_presenciales cocu on cocu.id = cure.curso
		LEFT JOIN com_regiones reg on reg.id = core.region
		WHERE cocu.id = :id " . $sqlAdd;
		$sql .= " ORDER BY core.id ASC";

		$bind = array(
			':id' => $id
		);

		/*
		echo $sql;
		print_r($bind);*/

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}


	public function reporteAlumnos_preinscritos($estado)
	{
		if ($estado == 'pagado') {
			$sqlAdd = "AND (cure.estadopago > 0 OR cure.estado = 1)";
		} else if ($estado == 'aceptado') {
			$sqlAdd = "AND (cure.estado > 0)";
		} else {
			$sqlAdd = "";
		}



		$db = Db::getInstance();

		$sql = "SELECT core.id, core.nombre,core.ape1,core.ape2,core.email,core.dni,core.pass,core.telefono,core.clave,core.genero,core.tipouser,reg.region,cocu.titulo AS cursos, cure.estado, cure.estadopago, cure.validprerequisitos, cure.idpago, cure.floworder, cocu.acred_pre, cocu.ciclo FROM com_registro core 
		JOIN com_presenciales_registro cure on cure.usuario = core.id 
		JOIN com_presenciales cocu on cocu.id = cure.curso
		LEFT JOIN com_regiones reg on reg.id = core.region
		WHERE cocu.id > :id " . $sqlAdd;
		$sql .= " ORDER BY core.id ASC";

		$bind = array(
			':id' => 5
		);

		/*
		echo $sql;
		print_r($bind);
		*/

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}


	public function reporteAlumnos_2022($id)
	{

		$db = Db::getInstance();

		$sql = "SELECT core.id,core.nombre,core.ape1,core.ape2,core.email,core.dni,core.telefono,core.clave,core.genero,reg.region,GROUP_CONCAT(cocu.titulo) AS cursos FROM com_registro_2022 core 
		JOIN com_presenciales_registro_2022 cure on cure.usuario = core.id 
		JOIN com_presenciales cocu on cocu.id = cure.curso
		LEFT JOIN com_regiones reg on reg.id = core.region
		WHERE cocu.id = :id
		GROUP BY core.id ORDER BY core.id ASC";

		$bind = array(
			':id' => $id
		);

		$cont = $db->run($sql, $bind);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}


	public function preinscritos_2022()
	{

		$db = Db::getInstance();

		$sql = "SELECT core.id,core.nombre,core.ape1,core.ape2,core.email,core.dni,core.telefono,core.clave,core.genero, core.fecnac, core.region AS regionO, core.pais, core.pass, core.club, core.tipouser,reg.region,GROUP_CONCAT(cocu.titulo SEPARATOR ' - ') AS cursos,GROUP_CONCAT(cocu.id SEPARATOR '-') AS cursosID FROM com_registro_2022 core 
		JOIN com_presenciales_registro_2022 cure on cure.usuario = core.id 
		JOIN com_presenciales cocu on cocu.id = cure.curso
		LEFT JOIN com_regiones reg on reg.id = core.region
		GROUP BY core.id ORDER BY core.email ASC";



		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}

	public function getAll_Simple()
	{

		$db = Db::getInstance();

		$sql = "SELECT id,titulo, ciclo FROM " . $this->tabla . " ORDER BY id ASC";

		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql);
			return $row_p;
		}
	}


	public function getAll_Pagos()
	{

		$db = Db::getInstance();

		$sql = "SELECT com_registro.nombre, com_registro.ape1, com_registro.ape2, com_registro.email, com_registro.telefono, com_pagos.* FROM com_pagos LEFT JOIN com_registro ON com_registro.id = com_pagos.usuario WHERE (com_pagos.usuario <> 0 AND com_pagos.usuario <> '') AND ((com_pagos.tipopago = 2 AND com_pagos.estadopago > 0 AND com_pagos.estadopago < 3) OR com_pagos.tipopago = 1 OR com_pagos.tipopago = 4) GROUP BY com_pagos.id ORDER BY com_pagos.fecha DESC";

		$cont = $db->run($sql);
		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql);
			return $row_p;
		}
	}


	public function getAll_CursosPagos($idpago)
	{

		$db = Db::getInstance();

		$sql = "SELECT com_presenciales.id, com_presenciales.titulo, com_presenciales.ciclo, com_presenciales.acred_pre, com_presenciales.mailingID, com_presenciales.fecha, com_presenciales.plazo FROM com_pagos LEFT JOIN com_presenciales_registro ON  com_presenciales_registro.idpago = com_pagos.id LEFT JOIN com_presenciales ON com_presenciales_registro.curso = com_presenciales.id WHERE com_pagos.id = :idpago ORDER BY com_presenciales.id ASC";
		$bind = array(
			':idpago' => $idpago
		);
		$cont = $db->run($sql, $bind);

		if ($cont == 0) {
			return "";
		} else {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);
			return $row_p;
		}
	}

	static function actualizarAvance($user, $segundos_cur, $id_cur)
	{

		$db = Db::getInstance();
		$sql = "SELECT SUM(duracion) AS totseg FROM com_modulo_registro WHERE usuario = :usuario AND curso = :curso AND porcentaje > 0";
		$bind = array(
			':usuario' => $user,
			':curso' => $id_cur
		);

		/*echo $sql;
				print_r($bind);*/

		$cont = $db->run($sql, $bind);



		if ($cont > 0) {

			$db1 = Db::getInstance();
			$row_p = $db1->fetchAll($sql, $bind);

			$suma =  $row_p[0]['totseg'];
			$porc = ceil(($suma * 100) / $segundos_cur);

			if ($porc > 100) {
				$porc = 100;
			}


			$db2 = Db::getInstance();

			$data2 = array(

				'duracion' => $suma,
				'porcentaje' => $porc
			);

			$db2->update('com_presenciales_registro', $data2, "usuario = :usuario AND curso = :curso", array('usuario' => $user, 'curso' => $id_cur));
		} else {
			$porc = 0;
		}

		return  $porc;
	}

	static function getNotas($curso, $modulo, $capitulo, $usuario)
	{

		$db = Db::getInstance();



		$sql = "SELECT comco.id,UPPER(core.nombre) as nombre,UPPER(core.ape1) as ape1,comco.comentario,comco.tiempo,DATE_FORMAT(comco.fecha, '%d-%m-%Y %H:%i') as fecha,comco.principal,comco.respuesta 
        FROM com_notas comco
        JOIN com_registro core on core.id = comco.usuario
        WHERE comco.capitulo = $capitulo AND comco.usuario = $usuario 
        GROUP BY comco.comentario,comco.fecha,comco.respuesta,comco.id
        ORDER BY comco.tiempo ASC";

		$db->run($sql);
		$row_p = $db->fetchAll($sql);
		return $row_p;
	}
}
