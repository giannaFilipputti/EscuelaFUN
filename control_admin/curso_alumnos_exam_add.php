<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$usuario = new Usuario();

$perfil = new Perfil();

include('header.php');
?>


<body class="twoColLiqLtHdr">

  <div id="container">
    <div id="header">
      <?php include("cabeza.php"); ?>
      <!-- end #header -->
    </div>
    <div id="sidebar1">
      <?php include("menu.php"); ?>
      <!-- end #sidebar1 -->
    </div>
    <div id="mainContent">
      <div id="submenu">
        <!-- DESDE AQUI SUBMENU -->
        <!-- HASTA AQUI SUBMENU -->
      </div>
      <!-- DESDE AQUI CONTENIDO -->
      <h1> Usuarios</h1>

      <?php
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

      ?>
      <h2>Buscar Usuarios</h2>
      <div style="text-align:right">
        <form action="usuarios.php" method="get">
          Email: <input type="text" name="email" /><br />
          Apellido: <input type="text" name="apellido" /><br />
          Nombre: <input type="text" name="nombre" /><br />

          <input type="submit" />

        </form>
      </div>
      <h2>Usuarios ingresados</h2>

      <form action="curso_alumnos_exam_add1.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Modulo: <select name="modulo">
        <?php foreach ($mod->row as $Elem) { ?>
        <option value="<?php echo $Elem['id'];?>"><?php echo $Elem['titulo'];?></option>
        <?php } ?>
      </select>

      Fecha: <input type="text" name="fecha">
      <table cellpadding="2" cellspacing="0" border="1" width="95%" align="center">
      <td align="center" width="5%">Agregar</td>
          <td align="center" width="20%">Usuario <a href="usuarios.php?<?php echo $listvaro ?>&orden=ape1"><img src="body/orden_up.png"></a> <a href="usuarios.php?<?php echo $listvaro ?>&orden=ape1&tiporden=desc"><img src="body/orden_down.png"></a></td>
          <td align="center" width="10%">Codigo</td>
          <td align="center" width="20%">Email <a href="usuarios.php?<?php echo $listvaro ?>&orden=email"><img src="body/orden_up.png"></a> <a href="usuarios.php?<?php echo $listvaro ?>&orden=email&tiporden=desc"><img src="body/orden_down.png"></a></td>
          <td align="center" width="15%">Nota</td>
          <td align="center" width="15%">Aprobar </td>
          
        </tr>
        <?php
        if ($usuario->row != "") {
          foreach ($usuario->row as $Elem) {
            $perfil = new Perfil();
            $perfil->getOne($Elem['perfil']);


            if (!empty($perfil->row[0]['id'])) {
              $perfil = $perfil->row[0]['perfil'];
            }else{
              $perfil = "";
            }

            if ($Elem['perfil'] == 'ME' && $Elem['especialidad'] != 0) {

              $especialidad = new Especialidad();
              $especialidad->getOne($Elem['id']);

              if (!empty($especialidad->row[0]['id'])) {
                $perfil = $especialidad->row[0]['especialidad'];
              }
            }

            $provincia = "";

            if (!empty($Elem['provincia'])) {

              $provincia = new Provincia();
              $provincia->getOne($Elem['provincia'], $Elem['pais']);

              if (!empty($provincia->row[0]['id'])) {
                $provincia = $provincia->row[0]['provincia'];
              }else{
                $provincia = "";
              }
            } else {
              $pais = new Pais();
              $pais->getOneByCod($Elem['pais']);

              if (!empty($pais->row['id'])) {
                $provincia = $pais->row['pais'];
              }
            }


        ?>
            <tr>
            <td align="left"><input name="agregar_<?php echo $Elem['id']?>" type="checkbox" value="1">
              </td>
                <input name="id_<?php echo $Elem['id']?>" type="hidden" value="<?php echo $Elem['id']?>">
              <td align="left"><?php echo $Elem['ape1'] . " " . $Elem['ape2'] . ", " . $Elem['nombre']; ?></td>
              <td align="left"><?php echo $Elem['codusuario']; ?>
              </td>
              <td align="left"><?php echo $Elem['email']; ?>
              </td>
             
              <td align="left"><input name="nota_<?php echo $Elem['id']?>" type="text" value="">
              </td>
              <td align="left"><input name="aprobar_<?php echo $Elem['id']?>" type="checkbox" value="1">
              </td>
             

            </tr>
        <?php }
        } ?>
      </table>
      <input type="submit" name="Enviar">
      </form>
      <br /><br />
      <!-- HASTA AQUI CONTENIDO -->
    </div>
    <br class="clearfloat" />
    <div id="footer">
      <?php include("pie.php"); ?>
      <!-- end #footer -->
    </div>
    <!-- end #container -->
  </div>
</body>

</html>