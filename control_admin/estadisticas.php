<?php

use FontLib\Table\Type\head;

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getAll();
$mod = new Modulo();
$exam = new Examen();

include("header.php");

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
      <h1>Estadisticas</h1>
      <h2>Examenes Realizados</h2>
      <?php

      foreach ($curso->row as $Elem) {
      ?>
        <h1><?php echo $Elem['titulo'] ?></h1>
        <?php
        if ($Elem['examen'] == 1) {
          // $sql_mod = "SELECT * FROM com_cursos_mod WHERE curso = ".$Elem['id']." AND examen_unico = 1 ORDER BY orden";
          $mod->ex_unico = 1;
          $mod->getModByCurso($Elem['id']);
        } else {
          //  $sql_mod = "SELECT * FROM com_cursos_mod WHERE curso = ".$Elem['id']." ORDER BY orden";
          $mod->getModByCurso($Elem['id']);
        }
          foreach ($mod->row as $ElemMod) {
            $usuExam = new UsuarioExam();
            $usuApro = new UsuarioExam();
            $usuNoApro = new UsuarioExam();
            
            $usuExam->getByModulo($ElemMod['id']);
            if (!empty($usuExam->row)) {
              $NroRegistrosc = count($usuExam->row);
            } else {
              $NroRegistrosc = 0;
            }

            $usuNoApro->estado = 1;
            $usuNoApro->noAprobado = 1;
            $usuNoApro->getByModulo($ElemMod['id']);
            if (!empty($usuNoApro->row)) {
              $NroRegistros0 = count($usuNoApro->row);
            } else {
              $NroRegistros0 = 0;
            }


            $usuApro->estado = 1;
            $usuApro->aprobado = 1;
            $usuApro->noAprobado = 0;
            $usuApro->getByModulo($ElemMod['id']);
            if (!empty($usuApro->row)) {
              $NroRegistros1 = count($usuApro->row);
            } else {
              $NroRegistros1 = 0;
            }


        ?>
            <?php if ($Elem['examen'] == 1) { ?>
              <h2>Examen Unico</h2>
            <?php } else { ?>
              <h2><?php echo $ElemMod['titulo'] ?></h2>
            <?php } ?>


            <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
              <tr>
                <td align="center" width="40%">Realizados</td>
                <td align="center" width="35%">Aprobados</td>
                <td align="center" width="25%">No Aprobados</td>
              </tr>

              <tr>
                <td align="center"><a href="resultados_bus1.php?modulo=<?php echo $ElemMod['id'] ?>"><?php echo $NroRegistrosc; ?></a></td>
                <td align="center"><a href="resultados_bus1.php?modulo=<?php echo $ElemMod['id'] ?>&aprobado=1"><?php echo $NroRegistros1; ?></a></td>
                <td align="center"><a href="resultados_bus1.php?modulo=<?php echo $ElemMod['id'] ?>&aprobado=0"><?php echo $NroRegistros0; ?></a></td>


              </tr>

            </table>
            <br /><br />
      <?php }
        }
       ?>
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