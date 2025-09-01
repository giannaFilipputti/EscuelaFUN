<?php
class Indexador
{
	public $id;
	public $id_tabla;
	public $tabla;
	public $texto;
	public $nombre;
	public $curso;
	public $nom_pag;

	public $estado;
	public $row;

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
		$this->tabla = "com_indexador";
	}


	public function agregar($id_tabla, $tabla, $texto, $curso,$nombre)
	{
	

			$db = Db::getInstance();
			$this->id = $db->lastInsertId();
			$data = array(
				'id_tabla' => $id_tabla,
				'tabla' => $tabla,
				'texto' => $texto,
				'curso' => $curso,
				'nombre' => $nombre
			);
			$db->insert($this->tabla, $data);

			//header("Location: modulos_up.php?id=".$this->id);
	
	}

	public function agregarDiapo($id_tabla, $tabla, $texto, $nombre)
	{


			$db = Db::getInstance();
			$this->id = $db->lastInsertId();
			$data = array(
				'id_tabla' => $id_tabla,
				'tabla' => $tabla,
				'texto' => $texto,
				'nombre' => $nombre
			);
			$db->insert($this->tabla, $data);

			//header("Location: modulos_up.php?id=".$this->id);
			// header("Location: modulos.php");
	
	}

	public function agregarTexto($id_tabla, $tabla, $texto, $nombre,$nom_pag)
	{
			$db = Db::getInstance();
			$this->id = $db->lastInsertId();
			$data = array(
				'id_tabla' => $id_tabla,
				'tabla' => $tabla,
				'texto' => $texto,
				'nombre' => $nombre,
				'nom_pag' => $nom_pag
			);
			$db->insert($this->tabla, $data);

			//header("Location: modulos_up.php?id=".$this->id);
			// header("Location: modulos.php");
	
	}





	public function modificar($texto, $curso, $id)
	{
		if (empty($id)) {
			header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'texto' => $texto,
				'curso' => $curso
			);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}
	public function modificarDiapo($texto, $nombre, $id)
	{
		if (empty($id)) {
			header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'texto' => $texto,
				'nombre' => $nombre
			);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}

	public function modificarTexto($texto, $curso,$nom_pag, $id)
	{
		if (empty($id)) {
			header("Location: modulos.php");
		} else {

			$db = Db::getInstance();
			$data = array(
				'texto' => $texto,
				'curso' => $curso,
				'nom_pag' => $nom_pag
			);

			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		}
	}

	public function getAll($id_tabla, $tabalNom)
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id_tabla = :id_tabla AND tabla = :tablaNom ";
		$bind = array(
			':id_tabla' => $id_tabla,
			':tablaNom' => $tabalNom
		);
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
}
