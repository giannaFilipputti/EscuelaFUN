<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$exam = new Examen();
$exam->getOne($id);

$mod = new Modulo();
$mod->getOne($exam->row[0]['modulo']);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);


$pagina = new Pagina();

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
      <h1>Examen del Modulo: <?php echo $mod->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar Pregunta al examen</h2>
        <form method="POST" action="examen_mod1.php?id=<?php echo $id; ?>&ref=<?php echo $ref; ?>" id="form">
          <label><span>Numero: </span><input type="text" name="numero" value="<?php echo $exam->row[0]['num'] ?>"></label>
         
          <label><span>Cod. Video Vimeo: </span><input type="text" name="video" value="<?php echo $exam->row[0]['video'] ?>">
          </label>
          <label><span>Pregunta: </span>&nbsp;</label>
          <textarea id="editor1" name="pregunta" rows="6" cols="60"></textarea>
          <script type="text/javascript">
            var editor = CKEDITOR.replace('editor1',

              {

                toolbar:

                  [

                    ['Source', '-', 'Preview', '-', 'Templates'],
                    ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Print', 'SpellChecker', 'Scayt'],
                    ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],

                    '/',
                    ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                    ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'],
                    ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                    ['BidiLtr', 'BidiRtl'],
                    ['Link', 'Unlink', 'Anchor'],
                    ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
                    '/',
                    ['Styles', 'Format', 'Font', 'FontSize'],
                    ['TextColor', 'BGColor'],
                    ['Maximize', 'ShowBlocks', '-', 'About']

                  ],
                stylesCombo_stylesSet: 'my_styles:<?php echo $baseURLcontrol; ?>js/styles.js',
                contentsCss: '<?php echo $baseURLcontrol; ?>css/losstilos.css',


              });
            editor.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', $exam->row[0]['pregunta']);  ?>');

            // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
            // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
            editor.config.templates_files = ['<?php echo $baseURLcontrol; ?>js/mytemplates.js'];
            CKFinder.setupCKEditor(editor, '<?php echo $baseURL; ?>plugins/ckfinder/');

            // It is also possible to pass an object with selected CKFinder properties as a second argument.
            // CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
          </script>
          <label><span>Explicacion de la respuesta: </span>&nbsp;</label>
          <textarea name="exp_resp" rows="6" cols="60"><?php echo $exam->row[0]['exp_resp'] ?></textarea>


          <div class="fmr_sub">Respuestas</div>

          <?php


          $uncont = 1;
          $exam->getExamenRespuesta($exam->row[0]['id']);
          //  $sql_res = "SELECT * FROM com_exam_resp WHERE pregunta=".$row_preg['id']."";
          //        $result_res = mysql_query($sql_res);
          $cant_res = count($exam->row);
          foreach ($exam->row as $ElemResp) {; ?>
            <div id="div_<?php echo $uncont; ?>">
              <label>
                <span class="small">Respuesta</span>
              </label>
              <input type="text" name="respuesta<?php echo $uncont; ?>" style="width:200px;" value="<?php echo $ElemResp['respuesta'] ?>" /> Correcta?<input type="checkbox" name="correcta<?php echo $uncont; ?>" <?php if ($ElemResp['correcta'] == 1) { ?> checked="checked" <?php } ?> value="1" /><?php if ($cant_res == $uncont) { ?><input class="bt_plus" id="<?php echo $uncont; ?>" type="button" value="+" /><?php } ?><input type="hidden" name="laid<?php echo $uncont; ?>" value="<?php echo $ElemResp['id'] ?>" />
              <div class="error_form">
              </div>
              <br class="clearfloat" />
            </div>


          <?php $uncont = $uncont + 1;
          } ?>


          <input type="hidden" name="cant" id="cant" value="<?php echo $uncont ?>" />

          <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
      </div>



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