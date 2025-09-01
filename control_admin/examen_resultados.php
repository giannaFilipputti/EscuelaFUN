<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($ref);

$mod = new Modulo();
$mod->getOne($id);

$capitulo = new Capitulo();

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

      <h1>Examen de: <?php if ($curso->row[0]['examen'] == 1) {
                        echo $curso->row[0]['titulo'] . "daed";
                      } else {
                        echo $mod->row[0]['titulo'];
                      } ?></h1>


      <?php
      $capitulo->getOne($id);
      if (!empty($capitulo)) {
        $preg_aprob = $mod->row[0]['preg_aprob'];

        $exam->modulo = $capitulo->row[0]['modulo'];
        $exam->orden = "orden1";
        $exam->getAll($capitulo->row[0]['id']);

        $NroRegistrosc = count($exam->row);


        foreach ($exam->row as $Elem) {
      ?>
          <div class="cpreg">
            <div class="pregunta"><?php echo $Elem['pregunta']; ?></div>
            <div class="lasresp">
              <?php
              $exam->getExamenRespuesta($Elem['id']);

              foreach ($exam->row as $ElemResp) {
                $uncomen = '';
              ?>


                <div class="respuesta<?php if ($ElemResp['correcta'] == 1) {
                                        $uncomen = '(Respuesta Correcta)' ?> correcta<?php } ?>">&bull; <?php echo $ElemResp['respuesta'] . " " . $uncomen; ?></div>

              <?php

              }

              ?>

              <div><strong><i><?php echo $Elem['exp_resp']; ?></i></strong></div>
            </div>
            <div class="respresul">&nbsp;</div>
            <br class="clearfloat" />
          </div>
        <?php

        } ?>


      <?php }
      ?>





      <br /><br />



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