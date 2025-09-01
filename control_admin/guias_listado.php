<script src="js/jquery.tablednd.js" type="text/javascript"></script>

<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$db = Db::getInstance();
$sql = "SELECT * FROM com_guias WHERE curso = :curso ORDER BY categoria, subcategoria, orden";
$bind = array(
    ':curso' => $id
);
$result_1 = $db->fetchAll($sql, $bind);
?>
<table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
    <tr class="nodrop nodrag">
        <td width="15%" align="center">Orden</td>
        <td width="45%" align="center">Nombre</td>
        <td width="15%" align="center">Link</td>
        <td width="25%" align="center">Acciones</td>
        <td width="25%" align="center">Categoria</td>

    </tr>
    <?php foreach ($result_1 as $row_1) {
        //$descr = strip_tags($row['fra']);

    ?>
        <tr id="table6-row-<?= $row['id'] ?>">
            <td class="dragHandle">&nbsp;</td>
            <td align="center"><?php echo $row_1['nombre'] ?><br /><img src="../guias/g_<?php echo $row_1['imagen'] ?>" width="150" /></td>
            <td><a href="<?php echo $row_1['url'] ?>"><?php echo $row_1['url'] ?></a></td>
            <td align="center">

                <a href="guias_elim.php?id=<?php echo $row_1['id']; ?>&ref=<?php echo $id ?>" onClick="return confirm('Seguro de eliminar este contenido?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>


            </td>
            <td><?php echo $row_1['categoria'] ?></td>




        </tr>
    <?php } ?>
</table>
<div id="AjaxResult"></div>
<br /><br />
</div>
<script type="text/javascript">
    <? // include_once('script_ordenar_comi.php');
    ?>
</script>