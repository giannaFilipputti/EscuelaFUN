<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$usuExam = new UsuarioExam();

$exam = new Examen();
$mod = new Modulo();
$curso = new Curso();
$usuario = new Usuario();

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

      <h1>Exámenes</h1>
      <?php
      $listvar = "";
      $listvaro = "";
      // $aprobado = "";
      foreach ($_GET as $key => $value) {
        if ($key != 'pag') {
          $listvar .=  $key . "=" . $value . "&";
        }
        if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
          $listvaro .=  $key . "=" . $value . "&";
        }
      }

      if (!empty($modulo)) {
        $usuExam->modulo = $modulo;
      }

      if (!empty($datepicker)) {
        $usuExam->datepicker = $datepicker;
      }

      if (!empty($datepicker1)) {
        $usuExam->datepicker1 = $datepicker1;
      }

      if (isset($aprobado)) {
        if ($aprobado != 0) {
          $usuExam->aprobado = $aprobado;
        } else if ($aprobado == "") {
          $usuExam->aprobado = "";
        } else {
          $usuExam->noAprobado = 1;
        }
      }
      // if ($aprobado != 0) {
      //   $usuExam->aprobado = $aprobado;
      // }else if(!isset($aprobado)){
      //   $usuExam->aptobado = "";
      // }else{
      //   $usuExam->noAprobado = 1;
      // }


      $usuExam->getAll();
      ?>
      <div style="text-align:right; padding:10px"><a href="resultados_bus_csv.php?<?php echo $listvaro ?>">Descargar CSV</a></div>
      <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
          <td align="center" width="25%">Capítulo / Curso</td>
          <td align="center" width="25%">Alumno</td>
          <td align="center" width="15%">Estado</td>
          <td align="center" width="20%">Inicio / Fin</td>
          <td align="center" width="15%">Ver Respuestas</td>
        </tr>
        <?php
        if (!empty($usuExam->row)) {
          foreach ($usuExam->row as $Elem) {

            $exam->getByModulo($Elem['modulo']);

            $NroRegistrosc = count($exam->row);

            $porcentaje = round(($Elem['nota'] * 100) / $NroRegistrosc);

            $mod->getOne($Elem['modulo']);
            $curso->getOne($mod->row[0]['curso']);
            $usuario->getOne($Elem['alumno']);
        ?>
            <tr>
              <td align="left"><?php if ($curso->row[0]['examen'] == 1) { ?><?php echo $curso->row[0]['titulo']; ?><?php } else { ?><?php echo $mod->row[0]['titulo']; ?> (<?php echo $curso->row[0]['titulo']; ?>)<?php } ?></td>
              <td align="left"><?php echo html_entity_decode($usuario->row[0]['ape1'] . " " . $usuario->row[0]['ape2'] . ", " . $usuario->row[0]['nombre']) ?><br /><?php echo $usuario->row[0]['email']; ?>
                <br /><?php echo $usuario->row[0]['codusuario']; ?>
              </td>

              <td align="left"><?php if ($Elem['estado'] == 0) { ?>No Finalizado<?php } else { ?>
                Finalizado (<?php echo $Elem['nota'] ?> (<?php echo $porcentaje; ?>%) - <?php if ($Elem['aprobado'] == 0) { ?><span style="color:#FF0000">NO<?php } else { ?><span style="color:#0000FF"><?php } ?> Aprobado</span>)
                  <?php } ?>

              </td>
              <td align="left"><?php echo $Elem['fecini']; ?> <br /><?php if ($Elem['estado'] == 1) {
                                                                      echo $Elem['fecfin'];
                                                                    } ?></td>
              <td align="center"><?php if ($Elem['estado'] == 1) { ?><a href="usuarios_respuestas.php?id=<?php echo $Elem['id']; ?>&alumno=<?php echo $Elem['alumno']; ?>&modulo=<?php echo $Elem['modulo']; ?>">Ver Respuestas</a><?php } ?></td>

            </tr>
        <?php }
        } ?>
      </table>
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