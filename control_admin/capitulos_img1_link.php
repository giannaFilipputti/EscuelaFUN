<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);
if (empty($id)) $id = 'no';
$diapo = new Capitulo();
$diapo->getLink($id);

//   $sql = "SELECT * FROM com_ponencias_ima_link WHERE imagen=".$id." ORDER BY orden";
//   //echo $sql;
//   $result = mysql_query($sql,$link);


?>

<form action="capitulos_link_act.php?id=<?php echo $id ?>" method="post">
    <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
    <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
            <td width="5%" align="center">Orden</td>
            <td width="40%" align="center">Url</td>
            <td width="45%" align="center">Posicion</td>
            <td width="10%" align="center">Acciones</td>

        </tr>
        <?php
        $contador = 1;
        if (!empty($diapo->rowL)) {
            foreach ($diapo->rowL as $Elem) {
                $tiempo = '';


        ?>
                <tr id="table6-row-<?= $Elem['id'] ?>">
                    <td class="dragHandle">&nbsp;</td>

                    <td align="center">
                        <input type="text" name="url_<?php echo $Elem['id'] ?>" value="<?php echo $Elem['url'] ?>" />

                    </td>
                    <td>
                        Top: <input type="text" name="desde_<?php echo $Elem['id'] ?>" value="<?php echo $Elem['desde'] ?>" /> seg <br />
                        Left: <input type="text" name="hasta_<?php echo $Elem['id'] ?>" value="<?php echo $Elem['hasta'] ?>" /> seg <br />
                        Ancho: <input type="text" name="ancho_<?php echo $Elem['id'] ?>" value="<?php echo $Elem['ancho'] ?>" /> % <br />
                        Alto: <input type="text" name="alto_<?php echo $Elem['id'] ?>" value="<?php echo $Elem['alto'] ?>" /> % <br />



                    </td>
                    <td align="center">

                        <a href="capitulos_img_link_elim.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $Elem['capitulo']; ?>" onClick="return confirm('Esta seguro de eliminar este contenido?');"><img border="0" alt="Delete" src="body/elim.gif"></a>

                    </td>



                </tr>
        <?php $contador = $contador + 1;
            }
        } ?>
    </table>
    <div id="AjaxResult"></div>
    <br /><br />
    <script type="text/javascript">
        <? include_once('script_ordenar_pon.php'); ?>
    </script>
    <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
</form>

<br /><br />