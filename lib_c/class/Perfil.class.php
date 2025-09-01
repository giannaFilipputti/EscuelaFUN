<?php
class Perfil
{
    public $id;
    public $cod;
    public $perfil;

    public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;

    public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_perfiles";
	}

    public function getOne($cod)
	{
		$db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE codigo = :cod LIMIT 1";
		$bind = array(
			':cod' => $cod
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
