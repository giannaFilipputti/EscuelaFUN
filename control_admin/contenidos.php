<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($id);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= $apptitle ?></title>
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
      <h1>Contenidos: <?php echo $curso->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar Contenido al curso </h2>
        <form method="POST" action="contenidos_add.php?curso=<?php echo $id; ?>">
          <label><span>Nombre: </span>
            <input type="text" name="titulo" size="20"></label>
          <label><span>En menu: </span>
            <input name="menu" type="checkbox" value="1" /></label>
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
            //editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );

            // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
            // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
            editor.config.templates_files = ['<?php echo $baseURLcontrol; ?>js/mytemplates.js'];
            CKFinder.setupCKEditor(editor, '<?php echo $baseURL; ?>plugins/ckfinder/');

            // It is also possible to pass an object with selected CKFinder properties as a second argument.
            // CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
          </script>


          <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
      </div>
      <h2>Contenidos del Curso</h2>
      <?php
      $db = Db::getInstance();
      $sql_1 = "SELECT * FROM com_contenidos WHERE curso = :curso ORDER BY orden";
      $bind = array(  
        ':curso' => $id
      );
      $result_1 = $db->fetchAll($sql_1, $bind);
      ?>
      <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
          <td width="15%" align="center">Orden</td>
          <td width="45%" align="center">Titulo</td>
          <td width="15%" align="center">Menu</td>
          <td width="25%" align="center">Acciones</td>

        </tr>
        <?php foreach ($result_1 as $row_1) {
          //$descr = strip_tags($row['fra']);
        ?>
          <tr id="table6-row-<?= $row_1['id'] ?>">
            <td class="dragHandle">&nbsp;</td>
            <td align="center"><?php echo $row_1['titulo'] ?></td>
            <td><img border="0" src="body/activa_<?php echo $row_1['menu']; ?>.gif"></td>
            <td align="center">
              <a href="contenidos_mod.php?id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>"><img border="0" alt="Modificar" title="Modificar" src="body/modif.gif"></a>
              <a href="contenidos_elim.php?id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>" onClick="return confirm('Seguro de eliminar este contenido?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>
              <?php if ($row_1['estado'] == 0) { ?>
                <a href="contenidos_estado.php?st=1&id=<?= $row_1['id']; ?>&ref=<?php echo $id ?>"><img border="0" src="body/suspender.gif" title="Click para Activar"></a>&nbsp;
              <?php } else { ?>
                <a href="contenidos_estado.php?st=0&id=<?= $row_1['id']; ?>&ref=<?php echo $id ?>"><img border="0" src="body/activar.gif" title="Click para Suspender"></a>&nbsp;
              <?php } ?>

            </td>



          </tr>
        <?php } ?>
      </table>
      <div id="AjaxResult"></div>
      <br /><br />
      <script type="text/javascript">
        <?php include_once('script_ordenar_cont.php'); ?>
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