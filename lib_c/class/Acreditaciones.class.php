<?php
class Acreditaciones
{
    public $id;
    public $modulo;
    public $creditos;
    public $no_acred;
    public $horas;
    public $periodo;
    public $acred_desde;
    public $acred_hasta;

    public $estado;
    public $row;
    public $tabla;

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
        $this->tabla = "com_acreditaciones";
    }

    public function agregar($modulo, $creditos, $no_acred, $horas, $periodo, $acred_desde, $acred_hasta)
    {
        if (empty($modulo)) {
			header("Location: modulos_acred.php");
		} else {
            $db = Db::getInstance();
			$this->id = $db->lastInsertId();
            $data = array(
                'modulo' => $modulo,
                'creditos' => $creditos,
                'no_acred' => $no_acred,
                'horas' => $horas,
                'periodo' => $periodo,
                'acred_desde' => $acred_desde,
                'acred_hasta' => $acred_hasta
            );
            $db->insert($this->tabla, $data);
        }
    }

    public function modificar($id, $creditos, $no_acred, $horas, $periodo, $acred_desde, $acred_hasta)
    {
        if (empty($id)) {
			header("Location: modulos_acred.php");
		} else {
            $db = Db::getInstance();
			$this->id = $db->lastInsertId();
            $data = array(
                'creditos' => $creditos,
                'no_acred' => $no_acred,
                'horas' => $horas,
                'periodo' => $periodo,
                'acred_desde' => $acred_desde,
                'acred_hasta' => $acred_hasta
            );
			$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
        }
    }

    public function getAll($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE modulo = :id ORDER BY acred_desde";
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
    public function getOne($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id";
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

    public function eliminar($id,$modulo,$curso){
		if(empty($id)){
			header("Location: modulos_acred.php??id=".$modulo."&ref=".$curso."");
		}else{
			$db = Db::getInstance();
			$data = array(
				'id' => $id
			);

			$db->delete($this->tabla,"id = :id",$data);
			// header("Location: modulos.php?id=".$curso."");
		}
	}
}
