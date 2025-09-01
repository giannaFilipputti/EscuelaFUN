<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getAll();

include("header.php");

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
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
        <!-- HASTA AQUI SUBMENU -->
      </div>
      <!-- DESDE AQUI CONTENIDO -->
      <h1> Cursos</h1>
      <h2>Cursos Registradas</h2>
      <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
          <td align="center" width="35%">Curso</td>
          <td align="center" width="15%">Duracion</td>
          <td align="center" width="30%">Contenidos</td>
          <td align="center" width="25%">Elim</td>
        </tr>
        <?php
        foreach ($curso->row as $Elem) {

        ?>

          <tr>
            <td align="left"><?php echo $Elem['titulo'] . " " . $Elem['ciclo']; ?></td>
            <td align="left"><?php echo Funcion::convertiraMin($Elem['duracion']); ?></td>
            <td align="left">
              <a href="contenidos.php?id=<?php echo $Elem['id']; ?>">Contenidos</a><br />
              <a href="comite.php?id=<?php echo $Elem['id']; ?>">Comite Editorial</a><br />
              <a href="modulos.php?id=<?php echo $Elem['id']; ?>">Modulos</a><br />
              <a href="material.php?id=<?php echo $Elem['id']; ?>">Recursos</a><br />
              <a href="guias.php?id=<?php echo $Elem['id']; ?>">Guias</a><br />
              <a href="prelanding.php?id=<?php echo $Elem['id']; ?>">Prelanding</a><br />
              <a href="curso_alumnos.php?id=<?php echo $Elem['id']; ?>">Alumnos</a><br />
            </td>
            <td align="center"><a href="cursos_mod.php?id=<?php echo $Elem['id']; ?>"><img border="0" alt="Modificar" src="body/modif.gif" /></a>&nbsp;<a href="cursos_elim.php?id=<?php echo $Elem['id']; ?>" onClick="return confirm('Esta seguro de borrar este curso?');"><img border="0" alt="Eliminar" src="body/elim.gif"></a>&nbsp;</td>

          </tr>
        <?php } ?>
      </table>
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