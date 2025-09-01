<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->getOne($id);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

$acred = new Acreditaciones();
$acred->getAll($id);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= $apptitle ?></title>
  <link href="css/estilos.css" rel="stylesheet" type="text/css" />
  <?php include("scripts.php"); ?>
  <script>
    $(function() {
      $(".datepicker1").datepicker({
        dateFormat: "yy/mm/dd",
        showOn: "button",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date"
      });
    });
  </script>
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
      <h1>Acreditaciones del Modulo: <?php echo $mod->row[0]['titulo']; ?> del curso: <?php echo $curso->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar período de acreditacion al Modulo </h2>
        <form method="POST" action="modulos_acred_add.php?modulo=<?php echo $id; ?>">
          <label><span>Creditos: </span>
            <input type="text" name="creditos" size="10"></label>
          <label><span>No. Acreditacion: </span>
            <input type="text" name="no_acred" size="20"></label>
          <label><span>Periodo: </span>
            <input type="text" name="periodo" size="20"></label>
          <label><span>Horas: </span>
            <input type="text" name="horas" size="10" class="numerico"></label>

          <label><span>Acreditado desde: </span>
            <input type="text" name="acred_desde" class="datepicker1" size="20" readonly="readonly"></label>

          <label><span>Acreditado hasta: </span>
            <input type="text" name="acred_hasta" class="datepicker1" size="20" readonly="readonly"></label>

          <label><span>Acreditado?: </span>
            <input type="checkbox" name="acreditado" value="1"></label>
            <input type="hidden" name="ref" value="<?=$ref?>">


          <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
      </div>
      <h2>Acreditaciones del Modulo</h2>
      <?php
      ?>
      <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center">
        <tr class="nodrop nodrag">
          <td width="45%" align="center">Desde</td>
          <td width="15%" align="center">Hasta</td>
          <td width="25%" align="center">Acciones</td>

        </tr>
        <?php $conty = 1;
        if (!empty($acred->row)) {
          foreach ($acred->row as $Elem) {
            //$descr = strip_tags($row['fra']);
        ?>
            <tr>
              <td align="center"><?php echo $Elem['acred_desde'] ?></td>
              <td align="center"><?php echo $Elem['acred_hasta'] ?></td>

              <td align="center">
                <a href="modulos_acred_mod.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>"><img border="0" alt="Modificar" title="Modificar" src="body/modif.gif"></a>
                <a href="modulos_acred_elim.php?id=<?php echo $Elem['id']; ?>&ref=<?php echo $id ?>&curso=<?php echo $ref; ?>" onClick="return confirm('Seguro de eliminar esta acreditacion?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>



              </td>



            </tr>
        <?php }
        } ?>
      </table>
      <div id="AjaxResult"></div>
      <br /><br />



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