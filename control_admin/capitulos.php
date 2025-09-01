<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->getOne($id);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

$cap = new Capitulo();

$cap->getAll($id);

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
      <h1>Capitulos del Modulo: <?php echo $mod->row[0]['titulo']; ?> del curso: <?php echo $mod->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar Capitulo al Modulo </h2>
        <form method="POST" action="capitulos_add.php?modulo=<?php echo $id; ?>&curso=<?php echo $ref; ?>">
          <label><span>Caso: </span>
            <input type="text" name="caso" size="20"></label>

          <label><span>Titulo Español: </span>
            <input type="text" name="titulo" size="20"></label>

          <label><span>Titulo Ingles: </span>
            <input type="text" name="titulo_eng" size="20"></label>

          <label><span>Video de intro: </span>
            <input type="text" name="video" size="20"></label>

          <label><span>Revista: </span>
            <input type="text" name="revista" size="20"></label>

          <label><span>Tema: </span>
            <input type="text" name="tema" size="20"></label>

          <label><span>Autor: </span>
            <input type="text" name="autor" size="20"></label>

          <label><span>Pestaña de descargas en menu: </span>
            <input type="checkbox" name="sub_menu" value="1"></label>
          <br class="clearfloat" />
          <label><span>Rese&ntilde;a del Autor: </span><textarea name="resena_autor" rows="4" cols="40"></textarea></label>

          <label><span>Video: </span>
            <input type="text" name="video" size="20"></label>

          <div class="fmr_sub">Primera Pagina</div>


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
      <h2>Capitulos del Modulo (<a href="capitulos_indexar_todos.php?modulo=<?php echo $id ?>&ref=<?php echo $ref ?>">indexar todos los capitulos al buscador</a>)</h2>
      <?php
      // $sql_1 = "SELECT * FROM com_cursos_mod_cap WHERE modulo = ". $id ." ORDER BY orden";
      // $result_1 = mysql_query($sql_1);
      ?>
      <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
          <td width="10%" align="center">Orden</td>
          <td width="25%" align="center">Titulo</td>
          <td width="35%" align="center">Video</td>
          <td width="15%" align="center">Capitulos</td>
          <td width="15%" align="center">Acciones</td>

        </tr>
        <?php $conty = 1;

        foreach ($cap->row as $Elem) {
          //$descr = strip_tags($row['fra']);
          // $pagina = new Pagina();
          // $pagina->getAll($Elem['id']);
          // $codigover = '';
          // foreach($pagina->row as $Elem2) {
          //   $codigover = "cod: " . $Elem2['id'];
          // }
        ?>
          <tr id="table6-row-<?php echo $Elem['id'] ?>">
            <td class="dragHandle">&nbsp;</td>
            <td align="center">Capitulo <strong><?php echo $conty ?></strong>: <strong><?php //$codigover; 
                                                                                        echo strlen(urls_amigables($Elem['titulo'])) ?></strong> <?php echo $Elem['caso'] . "<br>" . $Elem['titulo'] ?>
            </td>
            <td>
              <?php if (!empty($Elem['video'])) { ?>
                <iframe src="https://player.vimeo.com/video/<?php echo $Elem['video'] ?>?api=1" width="220" height="110" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><br><?php echo $Elem['video'] ?><br>
                  <?php echo Funcion::convertiraMin($Elem['duracion']);?><br><br>
                  <a href="capitulos_img_link.php?id=<?php echo $Elem['id']?>">Administrar Links</a>


              <?php } ?>


            </td>
            <td><a href="paginas.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Paginas<br /></a><br />
              <a href="capitulos_cap_down.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>">Descargas</a>
             
            </td>

            <td align="center">
              <a href="capitulos_up.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>"><img border="0" alt="Imagen" title="Imagen" src="body/jpg.png"></a>
              <a href="capitulos_mod.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" alt="Modificar" title="Modificar" src="body/modif.gif"></a>
              <a href="capitulos_elim.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>" onClick="return confirm('Seguro de eliminar este modulo?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>
              <?php if ($Elem['estado'] == 0) { ?>
                <a href="capitulos_estado.php?st=1&id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" src="body/suspender.gif" title="Click para Activar"></a>&nbsp;
              <?php } else { ?>
                <a href="capitulos_estado.php?st=0&id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" src="body/activar.gif" title="Click para Suspender"></a>&nbsp;
                <a href="capitulos_down.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img src="body/pdf_icon.png" /></a>&nbsp;
                <a href="capitulos_ppt.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img src="body/ppt.png" title="Subir PPT" alt="Subir PPT" /></a>&nbsp;
                <a href="capitulos_zip.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img src="body/zip.png" /></a>&nbsp;
                &nbsp;<a href="capitulos_print.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>" target="_blank"><img src="body/print.png" /></a>
                &nbsp;<a href="capitulos_indexar.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img src="body/indexar.jpg" title="Indexar al buscador" alt="Indexar al buscador" /></a>
              <?php
                $conty = $conty + 1;
              } ?>

            </td>



          </tr>
        <?php } ?>
      </table>
      <div id="AjaxResult"></div>
      <br /><br />
      <script type="text/javascript">
        <?php include_once('script_ordenar_cap.php'); ?>
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