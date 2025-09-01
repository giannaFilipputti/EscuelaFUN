<?php
class Area
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
		$this->tabla = "com_escuelas";
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



	public function getAll($tipo = '')
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id > :id ORDER BY orden";
		$bind = array(
			':id' => '0'
		);

		




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


    public function getOne($id)
	{

		$db = Db::getInstance();

		$sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id ORDER BY orden LIMIT 1";
		$bind = array(
			':id' =>$id
		);

		




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
}
