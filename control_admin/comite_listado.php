<script src="js/jquery.tablednd.js" type="text/javascript"></script>

<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$db = Db::getInstance();
$sql_1 = "SELECT * FROM com_comite WHERE curso = :id ORDER BY orden";
$bind = array(
    ':id' => $id
);
$result_1 = $db->fetchAll($sql_1, $bind);
?>
<table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
    <tr class="nodrop nodrag">
        <td width="15%" align="center">Orden</td>
        <td width="45%" align="center">Nombre</td>
        <td width="15%" align="center">Imagen</td>
        <td width="25%" align="center">Acciones</td>

    </tr>
    <?php
    if (!empty($result_1)) {
        foreach ($result_1 as $row_1) {
            //$descr = strip_tags($row['fra']);
    ?>
            <tr id="table6-row-<?php echo $row['id']; ?>">
                <td class="dragHandle">&nbsp;</td>
                <td align="center"><?php echo $row_1['nombre']; ?></td>
                <td><img border="0" src="../comite/g_comite_<?php echo $row_1['id']; ?>.jpg"></td>
                <td align="center">
                    <a href="comite_mod.php?id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>"><img border="0" alt="Eliminar" title="Modificar" src="body/modif.gif"></a>
                    <a href="comite_elim.php?id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>" onClick="return confirm('Seguro de eliminar este contenido?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>
                    <?php if ($row_1['estado'] == 0) { ?>
                        <a href="comite_estado.php?st=1&id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>"><img border="0" src="body/suspender.gif" title="Click para Activar"></a>&nbsp;
                    <?php } else { ?>
                        <a href="comite_estado.php?st=0&id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>"><img border="0" src="body/activar.gif" title="Click para Suspender"></a>&nbsp;
                    <?php } ?>

                </td>



            </tr>
    <?php }
    } ?>
</table>
<div id="AjaxResult"></div>
<br /><br />
</div>
<script type="text/javascript">
    <?php include_once('script_ordenar_comi.php'); ?>
</script>