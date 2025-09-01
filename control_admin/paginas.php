<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$cap = new Capitulo();
$cap->getAll($ref);

$mod = new Modulo();
$mod->getOne($cap->row[0]['modulo']);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

$pagina = new Pagina();
$pagina->getAll($id);

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
      <h1>Paginas del Capitulo: <?php echo $cap->row[0]['titulo']; ?> del Modulo: <?php echo $mod->row[0]['titulo']; ?> del curso: <?php echo $curso->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar Pagina del Capitulo </h2>
        <form method="POST" action="paginas_add.php?capitulo=<?php echo $id; ?>&curso=<?php echo $ref; ?>">


          <label><span>Titulo Pagina: </span>
            <input type="text" name="titulo_con" size="20"></label>
          <label><span>Sub-Titulo Pagina: </span>
            <input type="text" name="subtitulo_con" size="20"></label>
          <label><span>Autor: </span>
            <input type="text" name="autor_con" size="20"></label>

          <label id="ver_contenido"><span>Tipo Contenido: </span>
            <input type="radio" name="tipo" value="cont">Contenido</label>
          <label id="ver_video"><span>&nbsp;</span>
            <input type="radio" name="tipo" value="video">Diapositivas</label>

          <div id="pag_cont" class="oculto">
            <label><span>Contenido: </span>&nbsp;</label>
            <textarea id="editor1" name="contenido" rows="10" cols="80"></textarea>
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
              editor.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', utf8_encode($row['contenido']));  ?>');

              // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
              // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
              editor.config.templates_files = ['<?php echo $baseURLcontrol; ?>js/mytemplates.js'];
              CKFinder.setupCKEditor(editor, '<?php echo $baseURL; ?>plugins/ckfinder/');

              // It is also possible to pass an object with selected CKFinder properties as a second argument.
              // CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
            </script>
          </div>
          <div id="pag_video" class="oculto">

          </div>




          <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
      </div>
      <h2>Paginas del Capitulo</h2>

      <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
          <td width="15%" align="center">Orden</td>
          <td width="45%" align="center">Titulo</td>
          <td width="45%" align="center">Uploads</td>
          <td width="25%" align="center">Acciones</td>

        </tr>
        <?php 
        foreach($pagina->row as $Elem) {

        ?>
          <tr id="table6-row-<?php echo $Elem['id'] ?>">
            <td class="dragHandle">&nbsp;</td>
            <td align="center"><?php echo $Elem['titulo'] ?> (<img src="body/<?php echo $Elem['tipo']; ?>.png" />)</td>

            <td align="center">
              <?php if ($Elem['tipo'] == 'video') { ?>

                <a href="ponencias_up.php?id=<?php echo $Elem['id']; ?>">Diapositivas</a>
              <?php } ?>
            </td>

            <td align="center">
              <a href="paginas_mod.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" alt="Modificar" title="Modificar" src="body/modif.gif"></a>
              <a href="paginas_elim.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>" onClick="return confirm('Seguro de eliminar este modulo?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>&nbsp;<a href="paginas_print.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>" target="_blank"><img src="body/print.png" /></a> <a href="paginas_down.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img src="body/pdf_icon.png" /></a>&nbsp;
              <?php if ($Elem['estado'] == 0) { ?>
                <a href="paginas_estado.php?st=1&id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" src="body/suspender.gif" title="Click para Activar"></a>&nbsp;
              <?php } else { ?>
                <a href="paginas_estado.php?st=0&id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" src="body/activar.gif" title="Click para Suspender"></a>&nbsp;
              <?php } ?>

            </td>



          </tr>
        <?php } ?>
      </table>
      <div id="AjaxResult"></div>
      <br /><br />
      <script type="text/javascript">
        <?php include_once('script_ordenar_pag.php'); ?>
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