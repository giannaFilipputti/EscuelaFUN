<?php

class Pais

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



	public $img_ppl;



	public $cnt_img_ppl;



	private $interfaz;





	public function __construct($interfaz = 0)

	{

		$this->interfaz = $interfaz;

		$this->tabla = "com_paises";
	}






	public function getAll($tipo)
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

				$orden = "pais";
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

	public function getOneByCod($codigo)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE codigo = :codigo LIMIT 1";
		$bind = array(
			':codigo' => $codigo
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
}
