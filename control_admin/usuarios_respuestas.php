<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$usuario = new Usuario();
$usuario->getOne($alumno);

$mod = new Modulo();
$mod->getOne($modulo);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

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
      <h1>Examenes</h1>
      <?php

      if (!empty($mod->row[0]['id'])) {
        $preg_aprob = $mod->row[0]['preg_aprob'];
      ?>
        <h2>Examen de: <?php echo $mod->row[0]['titulo'] ?> del usuario <?php echo $usuario->row[0]['ape1'] . " " . $usuario->row[0]['ape2'] . ", " . $usuario->row[0]['nombre'] ?></h2>
        <?php
        $exam = new Examen();
        $exam->getUsuarioExamOne($id, $alumno, $modulo);


        if (!empty($exam->row[0]['id'])) {
          $id_exam_mod = $exam->row[0]['id'];
          $nota = $exam->row[0]['nota'];

          $exam->getByModulo($modulo);
          $NroRegistrosc = count($exam->row);
          //  echo $NroRegistrosc;
          // echo $nota;
          $porcentaje = ($nota * 100) / $NroRegistrosc;



          if ($nota >= $preg_aprob) {
            $pregfijo = '';
            $claseapro = 'verde';
          } else {
            $pregfijo = 'NO';
            $claseapro = 'roja';
          }
        ?>

          <div class="resuresult curved">El usuario ha obtenido el <span class="<?php echo $claseapro; ?>"><?php echo $porcentaje; ?>%</span> de aciertos en el examen,<br />
            <?php echo $pregfijo; ?> ha aprobado el <span class="<?php echo $claseapro; ?>"><?php echo $mod->row[0]['titulo'] ?></span> del <span class="<?php echo $claseapro; ?>">CURSO <?php echo $curso->row[0]['titulo'] ?></span>
          </div>

          <?php
          $cont_preg = 1;
          foreach ($exam->row as $Elem) {
          ?>
            <div class="cpreg">
              <div class="pregunta"><?php echo $cont_preg . ".- " . $Elem['pregunta']; ?></div>
              <div class="lasresp">
                <?php

                $exam->getExamenRespuesta($Elem['id']);
                foreach ($exam->row as $ElemResp) {
                  $uncomen = '';
                  $usuarioExamn = new UsuarioExam();
                  $usuarioExamn->getUsuarioRespuesta($ElemResp['id'], $alumno, $id_exam_mod);
                  // $exam->getUsuarioRespuesta($ElemResp['id'], $alumno, $id_exam_mod);
                  //echo print_r($usuarioExamn);
                ?>
                  <div class="respuesta<?php if (!empty($usuarioExamn->row[0]['id'])  and $ElemResp['correcta'] == 0) {
                                          $uncomen = '(Tu Respuesta)'; ?> incorrecta<?php 
                                        } else if ($ElemResp['correcta'] == 1) {
                                        $uncomen = '(Respuesta Correcta)' ?> correcta<?php } 
                              ?>">&bull; <?php echo $ElemResp['respuesta'] . " " . $uncomen; ?></div>
                <?php
                }

                $exam->getUsuarioRespuestaByPregunta($Elem['id'], $alumno);
                ?>
              </div>
              <div class="respresul"><img src="body/<?php if ($exam->row[0]['correcta'] == 1) { ?>correcta<?php } else { ?>incorrecta<?php } ?>.png" /></div>
              <br class="clearfloat" />
            </div>
          <?php
            $cont_preg++;
          }
          //}
          ?>

        <?php } else { ?>

          <div class="resuresult curved">No haz realizado el examen de <br />,
            <?php echo $row1['titulo'] ?> del CURSO <?php echo $row_cur['titulo'] ?>
          </div>
      <?php }
      } ?>





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