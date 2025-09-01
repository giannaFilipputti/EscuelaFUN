<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$curso = new Curso();
$curso->getOne($ref);

$mod = new Modulo();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $apptitle ?></title>
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

      <h2>Encuesta del modulo</h2>
      <div class="der"><a href="modulos_encuesta_resp.php?modulo=<?php echo $modulo; ?>&ref=<?php echo $ref; ?>">Ver respuestas</a></div>
      <?php
      $mod->limit = 30;
      $RegistrosAMostrar = 30;
      $listvaro ="";
      $listvar="";

      foreach ($_GET as $key => $value) {
        if ($key != 'pag') {
          $listvar .=  $key . "=" . $value . "&";
        }
        if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
          $listvaro .=  $key . "=" . $value . "&";
        }
      }
      if (empty($_GET['orden'])) {
        $orden = 'fecha DESC';
      } else {
        if (empty($_GET['tiporden'])) {
          $orden = $_GET['orden'];
        } else {
          $orden = $_GET['orden'] . " DESC";
        }
      }

      //estos valores los recibo por GET
      if (isset($pag)) {
        $RegistrosAEmpezar = ($pag - 1) * $mod->limit;
        $PagAct = $pag;
        //echo "aqui vemos";
        //caso contrario los iniciamos
      } else {
        $RegistrosAEmpezar = 0;
        $PagAct = 1;
      }
      $mod->tiporden = $orden;
      $mod->starting_limit = $RegistrosAEmpezar;
      $mod->getAllEncuestaByMod($modulo);

      $NroRegistros = $mod->total_results;
  

      $cantproductos = $RegistrosAEmpezar + $mod->limit;
      if ($cantproductos > $NroRegistros) {
        $cantproductos = $NroRegistros;
      }

      $PagAnt = $PagAct - 1;
      $PagSig = $PagAct + 1;
      $PagUlt = $NroRegistros / $mod->limit;

    
      //verificamos residuo para ver si llevará decimales
      $Res = $NroRegistros % $mod->limit;

      if ($Res > 0)  $PagUlt = floor($PagUlt) + 1;

      echo "<div class=\"paginas\">Usuarios " . ($RegistrosAEmpezar + 1) . "-" . $cantproductos . " de " . $NroRegistros . "</div>";
      echo "<div class=\"paginas\">Pagina " . $PagAct . " de " . $PagUlt . "</div>";


      echo "<div style='padding:10px;'>";
      echo "<div style='position:relative; width:140px; float:left; padding:0px; text-align:right;'>";
      if ($PagAct > 1) {

        echo "<a href='modulos_encuesta_resp.php?pag=1&" . $listvar . "'>Primera</a>&nbsp;&nbsp;&nbsp;<a href='modulos_encuesta_resp.php?pag=" . $PagAnt . "&" . $listvar . "'>Anterior</a>";
      }
      echo "</div>";
      //echo "<strong>Pagina ".$PagAct."/".$PagUlt."</strong>";
      echo "<div style='position:relative; width:180px; float:right; padding:0px; text-align:left;'>";

      if ($PagAct < $PagUlt) {
        echo "<a href='modulos_encuesta_resp.php?pag=" . $PagSig . "&" . $listvar . "'>Siguiente</a>&nbsp;&nbsp;&nbsp;<a href='modulos_encuesta_resp.php?pag=" . $PagUlt . "&" . $listvar . "'>Ultima</a>";
      }
      //echo "<a onclick=Pagina('$PagUlt')>Ultimo</a>";
      echo "</div><br class='clearfloat' /></div>";




      ?>
      <h2>Usuarios ingresados</h2>
      <table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">
        <tr>
          <td align="center" width="30%">Usuario</td>
          <td align="center" width="30%">Email</td>
          <td align="center" width="20%">Fecha</td>
          <td align="center" width="20%">Respuestas</td>
        </tr>
        <?php foreach ($mod->row as $Elem) {
          $usuario = new Usuario();

          $usuario->getOne($Elem['alumno']);
         if(!empty($usuario)){
 
        ?>
          <tr>
            <td align="left"><?php echo $usuario->row[0]['ape1'] . ", " . $usuario->row[0]['nombre']; ?></td>

            <td align="left"><?php echo $usuario->row[0]['email']; ?>
            </td>
            <td align="left"><?php echo $usuario->row[0]['fecha']; ?>
            </td>
            <td align="center"><a href="modulos_encuesta_ficha.php?id=<?php echo $Elem['id']; ?>&modulo=<?php echo $modulo; ?>&ref=<?php echo $ref; ?>">Ver Respuestas</a></td>

          </tr>
        <?php } }?>
      </table>
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