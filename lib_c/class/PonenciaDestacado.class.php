<?php

class PonenciaDestacado
{
    public $id;
    public $id_ima;
    public $tipo;
    public $titulo;
    public $subtitulo;
    public $descr;
    public $orden_destacado;
    public $orden_masreciente;
    public $curso;
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
        $this->tabla = "com_ponencias_destacados";
    }

    public function agregar($id_ima, $tipo, $orden, $curso)
    {
        $db = Db::getInstance();
        $this->id = $db->lastInsertId();

        $data = array(
            'id_ima' => $id_ima,
            'tipo' => $tipo,
            'orden_'.$tipo.'' => $orden,
            'curso' => $curso
        );
        $db->insert($this->tabla, $data);

    }

    public function getTypeDestacado($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE id_ima = :id AND tipo = 'destacado' LIMIT 1";
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

    public function getTypeMasreciente($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE id_ima = :id AND tipo = 'masreciente' LIMIT 1";
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

    public function getPonencia($id, $tipo)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE id_ima = :id AND tipo = :tipo LIMIT 1";
        $bind = array(
            ':id' => $id,
            'tipo' => $tipo
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

    public function getByTipo($tipo)
    {
        $db = Db::getInstance();
        $sql = "SELECT orden_" . $tipo . " FROM " . $this->tabla . " WHERE id > :id ORDER BY orden_" . $tipo . " DESC LIMIT 1";
        $bind = array(
            ':id' => '0'
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

    public function eliminar($id,$tipo,$ref){
		if(empty($id)){
			header("Location: ponencias_up.php?id=".$ref);
		}else{
			$db = Db::getInstance();
			$data = array(
				'id_ima' => $id,
                'tipo' => $tipo
			);

			$db->delete($this->tabla,"id_ima = :id_ima and tipo = :tipo ",$data);
		}
	}
}
