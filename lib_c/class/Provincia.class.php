<?php

class Provincia
{
    public $id;
    public $codigo;
    public $pais;
    public $provincia;

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
		$this->tabla = "com_provincias";
    }

    public function getOne($codigo,$pais)
    {
        $db = Db::getInstance();
		$sql = "SELECT * FROM " . $this->tabla . " WHERE codigo = :codigo AND pais = :pais LIMIT 1";
		$bind = array(
			':codigo' => $codigo,
            ':pais' => $pais
		);
		// echo $sql."<br>";
		// print_r($bind);
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