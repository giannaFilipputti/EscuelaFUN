<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);
if (empty($id)) $id = 'no';

$ponencia = new Diapositiva();
$ponencia->getAll($id);

?>
<p id="monstar_img" rel="ocultar">Mostrar / ocultar imagenes</p>
<p><a href="ponencias_texto.php?id=<?php echo $id; ?>">Actualizar textos de diapositivas para búsquedas</a></p>

<form action="ponencias_act_tiempo.php?id=<?php echo $id ?>" method="post">
    <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
    <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
            <td width="5%" align="center">Orden</td>
            <td width="20%" align="center">Imagen</td>
            <td width="70%" align="center" class="img_ponencias">Notas</td>
            <td width="5%" align="center">Acciones</td>

        </tr>
        <?php
        $contador = 1;
        if (!empty($ponencia->row)) {
            foreach ($ponencia->row as $Elem) {

                $destacado = new PonenciaDestacado();
                $destacado->getTypeDestacado($Elem['id']);

                $masreciente = new PonenciaDestacado();
                $masreciente->getTypeMasreciente($Elem['id']);

                $tiempo = '';


        ?>
                <tr id="table6-row-<?= $Elem['id'] ?>">
                    <td class="dragHandle">&nbsp;</td>

                    <td align="center">
                        <?php if (empty($Elem['video'])) { ?>
                            <img border="0" class="img_ponencias" src="<?php echo $baseURL; ?>uploads/ponencias/<?php echo $Elem['ponencia'] ?>/<?php echo $Elem['nombre'] ?>?id=<?= mt_rand(0, 5) ?>" width="350" /><br /><?php echo $Elem['nombre'] ?>
                            <br />
                            URL: <?php echo $Elem['id'] ?><br />
                            <a href="ponencias_up_link.php?id=<?php echo $Elem['id'] ?>">Administrar Links</a>
                        <?php } else { ?>
                            <iframe src="https://player.vimeo.com/video/<?php echo $Elem['video'] ?>?api=1" width="220" height="110" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><br><?php echo $Elem['video'] ?>
                                <br />
                            <a href="ponencias_up_link.php?id=<?php echo $Elem['id'] ?>">Administrar Links</a>
                                <?php }  ?>
                    </td>
                    <td class="img_ponencias"><textarea id="editor<?php echo $contador ?>" name="temp_<?php echo $Elem['id'] ?>"><?php echo $Elem['comentario'] ?></textarea>

                        <script type="text/javascript">
                            var editor<?php echo $contador ?> = CKEDITOR.replace('editor<?php echo $contador ?>',

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
                                            '/',
                                            ['Styles', 'Format', 'Font', 'FontSize'],
                                            ['TextColor', 'BGColor'],
                                            ['Maximize', 'ShowBlocks', '-', 'About']

                                        ],
                                    stylesCombo_stylesSet: 'my_styles:<?php echo $baseURLcontrol; ?>js/styles.js',
                                    contentsCss: '<?php echo $baseURLcontrol; ?>css/losstilos.css',


                                });
                            editor<?php echo $contador ?>.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', $Elem['comentario']);  ?>');

                            // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
                            // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
                            editor<?php echo $contador ?>.config.templates_files = ['<?php echo $baseURLcontrol; ?>js/mytemplates.js'];
                            CKFinder.setupCKEditor(editor<?php echo $contador ?>, '<?php echo $baseURL; ?>plugins/ckfinder/');

                            // It is also possible to pass an object with selected CKFinder properties as a second argument.
                            // CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
                        </script>

                    </td>
                    <td align="center">

                        <a href="ponencias_img_elim.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $Elem['ponencia']; ?>" onClick="return confirm('Esta seguro de eliminar este contenido?');"><img border="0" alt="Delete" src="body/elim.gif"></a>

                        <?php if (empty($destacado->row[0]['id'])) {
                         ?>
                            <a href="ponencias_img_estado.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $Elem['ponencia']; ?>&tipo=destacado&st=1" title="Click para quitar de destacados"><img src="body/activa_0.gif"></a>
                        <?php } else { ?>
                            <a href="ponencias_img_estado.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $Elem['ponencia']; ?>&tipo=destacado&st=0" title="Click para agregar a destacados"><img src="body/activa_1.gif"></a>
                        <?php }  ?>



                        <?php if (empty($masreciente->row[0]['id'])) { ?>
                            <a href="ponencias_img_estado.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $Elem['ponencia']; ?>&tipo=masreciente&st=1" title="Click para quitar de Mas Recientes"><img src="body/ofertano.gif"></a>
                        <?php } else { ?>
                            <a href="ponencias_img_estado.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $Elem['ponencia']; ?>&tipo=masreciente&st=0" title="Click para agregar a Mas Recientes"><img src="body/oferta.gif"></a>
                        <?php }  ?>

                    </td>



                </tr>
        <?php $contador = $contador + 1;
            }
        } ?>
    </table>
    <div id="AjaxResult"></div>
    <br /><br />
    <script type="text/javascript">
        <?php include_once('script_ordenar_pon.php'); ?>

        $("#monstar_img").click(function() {

            if ($(this).attr('rel') == 'mostrar') {
                $("#monstar_img").attr("rel", "ocultar");
                $(".img_ponencias").removeClass("oculto");

            } else {
                $(".img_ponencias").addClass("oculto");
                $("#monstar_img").attr("rel", "mostrar");

            }

        });
    </script>
    <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
</form>

<br /><br />