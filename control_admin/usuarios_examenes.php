<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$usuario = new Usuario();
$usuario->getOne($id);

$modulo = new Modulo();

$curso = new Curso();

$exam = new Examen();

// $usuarioModulo = new Modulo();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $apptitle ?></title>
  <link href="css/estilos.css" rel="stylesheet" type="text/css" />
  <?php include("scripts.php"); ?>
</head>

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

      <h1>Examenes</h1>
      <h2>Examenes tomados por usuario: <?php echo $usuario->row[0]['ape1'] . " " . $usuario->row[0]['ape2'] . ", " . $usuario->row[0]['nombre'] ?></h2>
      <?php
      $examUsuario = new Examen();
      $examUsuario->getUsuarioExamAll($id);
      // $sql = "SELECT * FROM com_alumnos_exam WHERE alumno = ". $id ." ORDER BY fecini";
      //   $result = mysql_query($sql);
      ?>
      <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
          <td align="center" width="30%">Capitulo / Curso</td>
          <td align="center" width="20%">Estado</td>
          <td align="center" width="30%">Inicio / Fin</td>
          <td align="center" width="20%">Ver Respuestas</td>
        </tr>
        <?php
        if (!empty($examUsuario->row)) {
          foreach ($examUsuario->row as $Elem) {

            if (!empty($Elem['modulo'])) {
              $exam->getByModulo($Elem['modulo']);

              $NroRegistrosc = count($exam->row);

              $porcentaje = ($Elem['nota'] * 100) / $NroRegistrosc;

              $modulo->getOne($Elem['modulo']);


              $tituloModulo = $modulo->row[0]['titulo'];
              $curso->getOne($modulo->row[0]['curso']);



              $modulo->getUsuarioModulo($Elem['modulo'], $id);

              $nuevo_ini = strtotime($modulo->row[0]['fecin'] . "+ 30 days");
              $fec_nuevoi = date("Y-m-d H:i:s", $nuevo_ini);

        ?>
              <tr>
                <td align="left"><?php echo $tituloModulo; ?> (<?php echo $curso->row[0]['titulo']; ?>)<br>
                  <span<?php if ($fechoy > $fec_nuevoi) { ?> class="roja" <?php } ?>><?php echo "Ini mod: " . $modulo->row[0]['fecin'] ?></span><br>
                    <a href="usuarios_mod_ampliar.php?modulo=<?php echo $Elem['modulo']; ?>&alumno=<?php echo $id; ?>" onClick="return confirm('Seguro quiere ampliar el plazo de este modulo para <?php echo $usuario->row[0]['ape1'] . " " . $usuario->row[0]['ape2'] . ", " . $usuario->row[0]['nombre'] ?> ?');">Ampliar plazo</a>
                    </br>
                </td>

                <td align="left"><?php if ($Elem['estado'] == 0) { ?>No Finalizado<?php } else { ?>
                  Finalizado (<?php echo $porcentaje ?>% - <?php if ($Elem['aprobado'] == 0) { ?>NO<?php } ?> Aprobado)
                <?php } ?>

                </td>
                <td align="left"><?php echo $Elem['fecini']; ?> <br /><?php if ($Elem['estado'] == 1) {
                                                                        echo $Elem['fecfin'];
                                                                      } ?></td>
                <td align="center"><?php if ($Elem['estado'] == 1) { ?><a href="usuarios_respuestas.php?id=<?php echo $Elem['id']; ?>&alumno=<?php echo $id; ?>&modulo=<?php echo $Elem['modulo']; ?>">Ver Respuestas</a><?php } ?><br />
                  <a href="usuarios_examenes_reset.php?id=<?php echo $Elem['id']; ?>&alumno=<?php echo $id; ?>&modulo=<?php echo $Elem['modulo']; ?>" onClick="return confirm('Se borrarán todas las preguntas del examen, y el resultado final, desea continuar?');">Reiniciar examen</a>
                </td>

              </tr>
        <?php }
          }
        }
        ?>
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