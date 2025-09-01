<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($ref);

$mod = new Modulo();
$mod->getOne($id);

$exam = new Examen();
$exam->orden = "pagina, orden1";
$exam->getAll($id);

$examResp = new Examen();
include('header.php');

$cur_mod = New Modulo();
$cur_mod->getModByCurso($ref);

$num_preg = count($exam->row);
$num_preg ++;
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
        <form method="POST" action="examen_add.php?modulo=<?php echo $id; ?>&curso=<?php echo $ref; ?>" id="form">
          <label><span>Numero: </span><input type="text" name="numero" value="<?php echo $num_preg;?>"></label>
         
          <label><span>Cod. Video Vimeo: </span><input type="text" name="video"></label>
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
            //editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );

            // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
            // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
            editor.config.templates_files = ['<?php echo $baseURLcontrol; ?>js/mytemplates.js'];
            CKFinder.setupCKEditor(editor, '<?php echo $baseURL; ?>plugins/ckfinder/');

            // It is also possible to pass an object with selected CKFinder properties as a second argument.
            // CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
          </script>
          <label><span>Explicacion de la respuesta: </span>&nbsp;</label>
          <textarea name="exp_resp" rows="6" cols="60"></textarea>

          <br><br>
          <label><span>Referencia Modulo: </span>&nbsp;</label>
          <select name="mod_ref">
            <?php foreach($cur_mod->row as $modR) { ?>
            <option value="<?php echo $modR['id']?>"<?php if ($mod_ref == $modR['id']) { ?> selected<?php } ?>><?php echo $modR['titulo']?></option>
            <?php } ?>
          </select>

          <input type="hidden" name="cant" id="cant" />

          <div class="fmr_sub">Respuestas</div>

          <div id="div_1">
            <label>
              <span class="small">Respuesta</span>
            </label>
            <input type="text" name="respuesta1" style="width:200px;" /> Correcta?<input type="checkbox" name="correcta1" style="width:40px;" value="1" /><input class="bt_plus" id="1" type="button" value="+" /><input type="hidden" name="laid1" value="" />
            <div class="error_form">
              <br class="clearfloat" />
            </div>
          </div>



          <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
      </div>
      <h2>Preguntas del Examen (<a href="examen_resultados.php?id=<?php echo $id ?>&ref=<?php echo $ref; ?>">Ver preguntas y respuestas</a>)</h2>
      <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
          <td width="15%" align="center">Orden</td>
          <td width="45%" align="center">Pregunta</td>
          <td width="15%" align="center">Resp. (correc)</td>
          <td width="25%" align="center">Acciones</td>

        </tr>
        <?php $conty = 1;
        foreach ($exam->row as $ElemExam) {

          $exam->getExamenRespuesta($ElemExam['id']);

          $examResp->correcta = 1;
          $examResp->getExamenRespuesta($ElemExam['id']);

          //$pagina->getAll($ElemExam['pagina']);

        ?>
          <tr id="table6-row-<?= $ElemExam['id'] ?>">
            <td class="dragHandle"><?php echo $conty; ?></td>
            <td><?php echo "<strong>" . $pagina->row[0]['titulo'] . ":</strong> " . $ElemExam['num'] . "<br>" . strip_tags($ElemExam['pregunta']) ?></td>
            <td align="center"><?php echo count($exam->row) . " (" . count($examResp->row) . ")" ?></td>

            <td align="center">
              <a href="examen_mod.php?id=<?php echo $ElemExam['id']; ?>&ref=<?php echo $id ?>"><img border="0" alt="Modificar" title="Modificar" src="body/modif.gif"></a>
              <a href="examen_elim.php?id=<?php echo $ElemExam['id']; ?>&ref=<?php echo $id ?>" onClick="return confirm('Seguro de eliminar esta pregunta?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>


            </td>



          </tr>
        <?php $conty = $conty + 1;
        } ?>
      </table>
      <div id="AjaxResult"></div>
      <br /><br />
      <script type="text/javascript">
        <?php include_once('script_ordenar_preg.php'); ?>
      </script>


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