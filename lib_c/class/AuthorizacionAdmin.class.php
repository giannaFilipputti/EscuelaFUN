<?php

class AuthorizacionAdmin
{
	public $login = "";
	public $rowff = array();
	public $ape1;
	public $ape2;
	public $nombre;
	public $dni;
	public $perfil;
	public $especialidad;
	public $numcolegiado;
	public $email;
	public $pais;
	public $provincia;
	public $poblacion;
	public $ciudad;
	public $direccion;
	public $cp;
	public $telefono;
	public $fax;
	public $empresa;
	public $usu_tipo;
	public $test;
	public $tipo_test;
	public $servicio;
	public $activado;
	public $newsletter = 0;
	public $logueado;

	private $pass;


	public function __construct()
	{
		// echo "<p>Class X</p>";

	}

	public function auth()
	{

		$this->login = $_COOKIE["admin_idx"];
		if (empty($this->login)) {
			header("Location: intro.php?err=5");
		} else {
			$db = Db::getInstance();
			$sql = "SELECT * FROM com_users WHERE id = :id";
			$bind = array(
				':id' => $this->login
			);

			$cont = $db->run($sql, $bind);




			if ($cont > 0) {
				$db1 = Db::getInstance();
				$rowff1 = $db1->fetchRow($sql, $bind);


				//echo "<br><strong>entro aqui".$rowff1['clave']."</strong> - ".$_COOKIE["clave"]."<br>";
				if ($rowff1['clave'] != $_COOKIE["clave"]) {
					header("Location: index.php?err=3");
					die();
					//echo "error en la clave";
				}
				$this->rowff = $rowff1;

				$this->logueado = 1;
			} else {
				header("Location: index.php?err=4");
			}
		}
	}

	public function auth_off()
	{

		$this->login = $_COOKIE["admin_idx"];
		// echo $_COOKIE["admin_idx"]." - ".$_COOKIE["admin_jkx"];
		if (empty($this->login)) {
			//header("Location: index.php?err=5");
			$this->logueado = 0;
		} else {
			$db = Db::getInstance();
			$sql = "SELECT * FROM com_users WHERE id = :id";
			$bind = array(
				':id' => $this->login
			);

			$cont = $db->run($sql, $bind);




			if ($cont > 0) {
				$db1 = Db::getInstance();
				$rowff1 = $db1->fetchRow($sql, $bind);



				$this->rowff = $rowff1;
				$this->logueado = 1;
			} else {
				//header("Location: index.php?err=4");
				$this->logueado = 0;
			}
		}
	}


	public function updateVideo()
	{

		$db = Db::getInstance();
		$data = array(
			'video' => 1
		);


		$db->update('com_users', $data, 'codusuario = :codusuario', array(':codusuario' => $this->login));
	}
	public function checkNews()
	{

		$db = Db::getInstance();
		$sql = "SELECT * FROM com_newsletter WHERE user = :user";
		$bind = array(
			':user' => $this->rowff['id']
		);

		$cont = $db->run($sql, $bind);

		if ($cont > 0) {
			$this->newsletter = 1;
		} else {
			$this->newsletter = 0;
		}
	}
	public function  logIn($login, $pass)
	{
		$pass1 = sha1(md5(trim($pass)));
		//$pass1 = $pass;
		$db = Db::getInstance();
		$sql = "SELECT * FROM com_users WHERE login = :email";
		$bind = array(
			':email' => $login
		);
		$cont = $db->run($sql, $bind);
		$cont = $db->run($sql, $bind);
		//echo "Contador:".$cont;

		if ($cont > 0) {
			//echo "entra aqui";
			$db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			foreach ($rowff1 as $rowff) {
				if ($rowff['pass'] != $pass1) {
					header("Location: index.php?err=2");
				} else {



					$clave00 = uniqid();
					setcookie("admin_jkx", $rowff['email']);
					setcookie("admin_idx", $rowff['id']);
					setcookie("clave", $clave00);

					$data = array(
						'clave' => $clave00
					);

					$db = Db::getInstance();
					$db->update('com_users', $data, 'id = :id', array(':id' => $rowff['id']));


					header("Location: intro.php");							//echo "entro";

				}
			}
		} else {
			header("Location: index.php?err=1");
		}
	}



	public function modificar($pass1, $pass2, $pass)
	{
		$npass1 = sha1(md5(trim($pass1)));
		$npass2 = sha1(md5(trim($pass2)));
		$npass = sha1(md5(trim($pass)));

		if ($this->pass != $npass) {
			header("Location: cuenta.php?err=1");
			die();
		}
		if (!empty($pass1) and ($npass1 != $npass2)) {
			header("Location: cuenta.php?err=2");
			die();
		}

		$db = Db::getInstance();
		$data = array(
			'nombre' => $this->username
		);

		if (!empty($pass1)) {
			$data["pass"] = $npass1;
			echo "cambia el pass por" . $npass1 . " --";
		}
		//$db->insert('com_proyectos', $data);

		$db->update('com_users', $data, 'id = :id', array(':id' => $this->id));
		header("Location: cuenta.php?act=OK");
	}


	public function getOut()
	{

		$clave00 = uniqid();
		setcookie("admin_jkx", "");
		setcookie("admin_idx", "");
		setcookie("clave", "");
		header("Location: index.php");
	}
}
