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

  <link href="<?php echo $baseURL; ?>plugins/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
  <script type="text/javascript" src="<?php echo $baseURL; ?>plugins/uploadify/swfobject.js"></script>
  <script type="text/javascript" src="<?php echo $baseURL; ?>plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
  <script type="text/javascript" src="<?php echo $baseURLcontrol; ?>js/funciones.js"></script>

  <script type="text/javascript">
    function startUpload(id, conditional) {
      if (conditional.value.length != 0) {
        $('#' + id).uploadifySettings('scriptData', {
          'titulo': remplazos($('#titulo').val()),
          'contenido': remplazos($('#contenido').val()),
          'curso': <?= $id ?>
        });
        $('#' + id).uploadifyUpload();
      } else
        alert("Debe ingresar un nombre");
    }



    $(document).ready(function() {



      $("#fileUploadname3").uploadify({
        'uploader': '<?php echo $baseURL; ?>plugins/uploadify/uploadify.swf',
        'script': '<?php echo $baseURL; ?>comite/uploadify.php',
        'cancelImg': '<?php echo $baseURL; ?>plugins/uploadify/cancel.png',
        'folder': '<?php echo $baseURL; ?>comite',
        'multi': false,
        'buttonText': 'Seleccionar Archivo',
        'fileExt': '*.jpg;*.gif;*.png',
        'fileDesc': 'Web Image Files (.JPG, .GIF, .PNG)',
        'method': 'post',
        'displayData': 'percentage',

        onAllComplete: function(event, queueID, fileObj, response, data) {
          //alert(data);
          $.post("comite_listado.php?id=<?= $id ?>", function(data1) {
            /// Ponemos la respuesta de nuestro script en el párrafo recargado  
            $("#imagenes").html(data1);
          });
          $('#titulo').attr('value', '');
          $('#contenido').val('');



        }
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
      <h1>Contenidos: <?php echo $curso->row[0]['titulo']; ?></h1>
      <div class="box">
        <h2>Agregar Contenido al curso </h2>

        <label><span>Nombre: </span>
          <input type="text" name="titulo" id="titulo" size="20"></label>

        <label><span>Descripcion: </span>&nbsp;</label>
        <textarea id="contenido" name="contenido" rows="5" cols="50"></textarea>



        <div class="botonup">
          <div id="fileUploadname3">You have a problem with your javascript</div>
        </div>
        <div class="botonup"><a href="javascript:startUpload('fileUploadname3', document.getElementById('titulo'))"><img src="body/subir.gif" /></a> | <a href="javascript:$('#fileUploadname3').fileUploadClearQueue()">Limpiar</a></div>


      </div>
      <div id="imagenes">
        <h2>Comite</h2>
        <?php include('comite_listado.php'); ?>


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