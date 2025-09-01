<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$usuario = new Usuario();

$perfil = new Perfil();


      $usuario->limit = 30;
      // echo $usuario->limit;
      $listvar = "";
      $listvaro = "";
      foreach ($_GET as $key => $value) {
        if ($key != 'pag') {
          $listvar .=  $key . "=" . $value . "&";
        }
        if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
          $listvaro .=  $key . "=" . $value . "&";
        }
      }

      if (empty($_GET['orden'])) {
        $orden = 'ape1';
      } else {
        if (empty($_GET['tiporden'])) {
          $orden = $_GET['orden'];
        } else {
          $orden = $_GET['orden'] . " DESC";
        }
      }

      //estos valores los recibo por GET
      if (isset($pag)) {
        $RegistrosAEmpezar = ($pag - 1) * $usuario->limit;
        $PagAct = $pag;
        //echo "aqui vemos";
        //caso contrario los iniciamos
      } else {
        $RegistrosAEmpezar = 0;
        $PagAct = 1;
      }

      //los gets
      $email = "";
      $nombre = "";
      $apellido = "";
      if (!empty($_GET['email'])) {
        $email = $_GET['email'];
      }
      if (!empty($_GET['nombre'])) {
        $nombre = $_GET['nombre'];
      }
      if (!empty($_GET['apellido'])) {
        $apellido = $_GET['apellido'];
      }
      $usuario->starting_limit = $RegistrosAEmpezar;
      $usuario->getAllCurso($orden, $email, $nombre, $apellido, $id);
      

      $NroRegistros = $usuario->total_results;

      $cantproductos = $RegistrosAEmpezar + $usuario->limit;
      if ($cantproductos > $NroRegistros) {
        $cantproductos = $NroRegistros;
      }

      $PagAnt = $PagAct - 1;
      $PagSig = $PagAct + 1;
      $PagUlt = $NroRegistros / $usuario->limit;

      //verificamos residuo para ver si llevará decimales
      $Res = $NroRegistros % $usuario->limit;

      if ($Res > 0)  $PagUlt = floor($PagUlt) + 1;

      echo "<div class=\"paginas\">Alumnos " . ($RegistrosAEmpezar + 1) . "-" . $cantproductos . " de " . $NroRegistros . "</div>";
      echo "<div class=\"paginas\">Pagina " . $PagAct . " de " . $PagUlt . "</div>";


      echo "<div style='padding:10px;'>";
      echo "<div style='position:relative; width:140px; float:left; padding:0px; text-align:right;'>";
      if ($PagAct > 1) {

        echo "<a href='usuarios.php?pag=1&" . $listvar . "'>Primera</a>&nbsp;&nbsp;&nbsp;<a href='usuarios.php?pag=" . $PagAnt . "&" . $listvar . "'>Anterior</a>";
      }
      echo "</div>";
      //echo "<strong>Pagina ".$PagAct."/".$PagUlt."</strong>";
      echo "<div style='position:relative; width:180px; float:right; padding:0px; text-align:left;'>";

      if ($PagAct < $PagUlt) {

        echo "<a href='usuarios.php?pag=" . $PagSig . "&" . $listvar . "'>Siguiente</a>&nbsp;&nbsp;&nbsp;<a href='usuarios.php?pag=" . $PagUlt . "&" . $listvar . "'>Ultima</a>";
      }
      //echo "<a onclick=Pagina('$PagUlt')>Ultimo</a>";
      echo "</div><br class='clearfloat' /></div>";


      $mod = new Modulo();
        $mod->getModByCurso($id);


        if ($usuario->row != "") {
            foreach ($usuario->row as $Elem) {

                $nombre_id = "id_".$Elem['id'];
                $valor_id = ${$nombre_id};

                $nombre_nota = "nota_".$Elem['id'];
                $valor_nota = ${$nombre_nota};

                $nombre_agregar = "agregar_".$Elem['id'];
                $valor_agregar = ${$nombre_agregar};


                $nombre_aprobar = "aprobar_".$Elem['id'];
                $valor_aprobar = ${$nombre_aprobar};
                if (empty($valor_aprobar)) {
                    $valor_aprobar = 0;
                }

                if ($valor_agregar == 1) {

                    echo $modulo.", ".$valor_id.", ".$valor_nota.", ".$valor_aprobar.", ".$fecha."<br>";
                    Examen::saveExamen($modulo, $valor_id, $valor_nota, $valor_aprobar, $fecha);
                }

            }
        }

      ?>