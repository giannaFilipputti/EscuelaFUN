<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($id);

$mod = new Modulo();
$mod->getModByCurso($id);

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
      <h1>Modulos: <?php echo $curso->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar Modulo al curso </h2>
        <form method="POST" action="modulos_add.php?curso=<?php echo $id; ?>">
          <label><span>Nombre: </span>
            <input type="text" name="titulo" size="20"></label>
          <label><span>Titulo en diploma: </span>
            <input type="text" name="titulo_diploma" size="20"></label>
          <label><span>Creditos: </span>
            <input type="text" name="creditos" size="10"></label>
          <label><span>No. Acreditacion: </span>
            <input type="text" name="no_acred" size="20"></label>
          <label><span>Periodo: </span>
            <input type="text" name="periodo" size="20"></label>


          <label><span>Acreditado desde: </span>
            <input type="text" name="acred_desde" class="datepicker1" size="20" readonly="readonly"></label>

          <label><span>Acreditado hasta: </span>
            <input type="text" name="acred_hasta" class="datepicker1" size="20" readonly="readonly"></label>

          <label><span>Acreditado?: </span>
            <input type="checkbox" name="acreditado" value="1"></label>

          <label><span>Solicitada acreditación?: </span>
            <input type="checkbox" name="solicitada" value="1"></label>


          <label><span>Horas: </span>
            <input type="text" name="horas" size="10" class="numerico"></label>

          <label><span>Color: </span>
            <input type="text" name="color" size="10"></label>

          <label><span>Descripción: </span><textarea name="descripcion" rows="4" cols="40"></textarea></label>

          <label><span>Subtítulo: </span>
            <input type="text" name="subtitulo" size="20"></label>
          <label><span>Video (código Vimeo): </span>
            <input type="text" name="video" size="20"></label>


          <label><span>Introduccion: </span>&nbsp;</label>
          <textarea id="editor1" name="intro" rows="10" cols="80"></textarea>
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


          <div class="fmr_sub">Examen del modulo</div>

          <label><span>Cant de preguntas: </span>
            <input type="text" name="cantpreg" size="10" class="numerico"></label>

          <label><span>Mostrar Preg / pag: </span>
            <input type="text" name="preg_pag" size="10" class="numerico"></label>
          <label><span>Cant. preguntas minima para aprobar: </span>
            <input type="text" name="preg_aprob" size="10" class="numerico"></label>
          <br class="clearfloat" />
          <label><span>Porcentaje aprobacion: </span>
            <input type="text" name="porc_aprob" size="10" class="numerico">%</label>
          <br class="clearfloat" />
          <?php if ($curso->row[0]['examen'] == 1) { ?>
            <label><span>Examen unico del curso: </span><input type="checkbox" name="ex_unico" value="1" /></label>
          <?php } ?>





          <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
      </div>
      <h2>Contenidos del Curso</h2>
      <?php

      ?>
      <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
          <td width="15%" align="center">Orden</td>
          <td width="45%" align="center">Titulo</td>
          <td width="15%" align="center">Capitulos</td>
          <td width="15%" align="center">Duracion</td>
          <td width="25%" align="center">Acciones</td>

        </tr>
        <?php

        if (empty($mod->row)) {
          ?>
          <p>No has creado ningu modulo</p>
          <?php 
        } else {

          foreach ($mod->row as $Elem) {
            //$descr = strip_tags($row['fra']);
        ?>
            <tr id="table6-row-<?php echo $Elem['id'] ?>">
              <td class="dragHandle">&nbsp;</td>
              <td align="center"><?php echo $Elem['titulo'] ?></td>
              <td><a href="capitulos.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Capitulos</a><br />
                <a href="modulos_down.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Descargas</a><br />
                <?php if ($curso->row[0]['examen'] == 0 or ($curso->row[0]['examen'] == 1 && $Elem['examen_unico'] == 1)) { ?>

                  <a href="modulos_acred.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Acreditaciones</a><br />
                <?php } ?>
                <a href="modulos_encuesta.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Encuesta</a><br />
                <br />
              <a href="examen.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Examen</a>
              </td>

              <td align="left"><?php echo Funcion::convertiraMin($Elem['duracion']);?></td>

              <td align="center">
                <a href="modulos_up.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>"><img border="0" alt="Imagen" title="Imagen" src="body/jpg.png"></a>
                <a href="modulos_mod.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>"><img border="0" alt="Modificar" title="Modificar" src="body/modif.gif"></a>
                <a href="modulos_elim.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>" onClick="return confirm('Seguro de eliminar este modulo?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>
                <?php if ($Elem['estado'] == 0) { ?>
                  <a href="modulos_estado.php?st=1&id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>"><img border="0" src="body/suspender.gif" title="Click para Activar"></a>&nbsp;
                <?php } else { ?>
                  <a href="modulos_estado.php?st=0&id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>"><img border="0" src="body/activar.gif" title="Click para Suspender"></a>&nbsp;
                <?php } ?>

                

              </td>



            </tr>
        <?php }
        } ?>
      </table>
      <div id="AjaxResult"></div>
      <br /><br />
      <script type="text/javascript">
        <?php include_once('script_ordenar_mod.php'); ?>
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