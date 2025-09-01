<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);

$pagina = new Pagina();
$pagina->getAll($id);

$cap = new Capitulo();
$cap->getAll($pagina->row[0]['capitulo']);

$mod = new Modulo();
$mod->getOne($cap->row[0]['modulo']);

$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= $apptitle ?></title>
  <link href="css/estilos.css" rel="stylesheet" type="text/css" />
  <?php include("scripts1.php"); ?>


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

      <!-- DESDE AQUI CONTENIDO -->
      <h1> Ponencias </h1>
      <h2>Agregar Imagenes</h2>
      <div class="box">
        <div id="dropzone" class="dropzone"></div>

        <br class="clearfloat" />
      </div>

      <h2>Agregar Videos</h2>
      <div class="box">
        <div>
          <form action="ponencias_up_add.php?contenido=<?php echo $id ?>" method="post">
            <label><span>Codigo Video: </span><input type="text" name="video" id="video" /></label>
            <label><span>&nbsp;</span><input type="submit" value="Enviar" /></label>
          </form>
        </div>
      </div>
      <p><a href="ponencias_up_elim.php?id=<?php echo $id ?>" onClick="return confirm('Esta seguro de eliminar todas las diapositivas?');">Eliminar TODAS las diapostivas</a></p>
      <div id="imagenes1">


        <?php include('ponencias_img1.php'); ?>

      </div>


      <br /><br />

      <!-- HASTA AQUI CONTENIDO -->
    </div>
    <br class="clearfloat" />
    <div id="footer">
      <?php include("pie.php"); ?>
      <script type="text/javascript">
        $(document).ready(function() {
          Dropzone.autoDiscover = false;
          $("#dropzone").dropzone({
            url: "<?php echo $baseURL; ?>uploads/diapositivas.php",
            addRemoveLinks: true,
            dictResponseError: "Ha ocurrido un error en el server",
            acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.gif,.pdf,.JPEG,.JPG,.PNG,.GIF,.PDF',
            uploadMultiple: true,
            maxFiles: 20,
            maxfilesexceeded: function(file) {
              this.removeAllFiles();
              this.addFile(file);
            },
            params: {
              id: '<?php echo $id; ?>',
              contenido: '<?php echo $id; ?>',
              tipo: '0'
            },
            complete: function(file, response) {
              if (file.status == "success") {
                $.post("ponencias_img1.php?id=<?php echo $id ?>", function(data1) {
                  /// Ponemos la respuesta de nuestro script en el párrafo recargado  
                  $("#imagenes1").html(data1);
                });
                this.removeFile(file);

              }
            },
            error: function(file) {
              alert("Error subiendo el archivo " + file.name);
            },
            removedfile: function(file, serverFileName) {
              var name = file.name;

              var element;
              (element = file.previewElement) != null ?
                element.parentNode.removeChild(file.previewElement) :
                false;

            }
          });
          /*

          		$("#fileUploadname3").uploadify({

          		'uploader'  : '<?php echo $baseURL; ?>plugins/uploadify/uploadify.swf',

                  'script'    : '<?php echo $baseURL; ?>pdf/uploadify_pagina.php',

                  'cancelImg' : '<?php echo $baseURL; ?>plugins/uploadify/cancel.png',

                  'folder': '<?php echo $baseURL; ?>pdf',

          		'multi': false,

          		'buttonText'  : 'Seleccionar Archivo',

          	    'fileExt'     : '*.pdf;*.PDF',

                  'fileDesc'    : 'Web Image Files (.PDF)',

          		'method' : 'post',

          		'displayData': 'percentage',

          		

                         'onError' : function (event,ID,fileObj,errorObj) {

                           alert(errorObj.type + ' Error: ' + errorObj.info);

                         },

           

          		onAllComplete: function (event, queueID, fileObj, response, data) {

          			//alert(data);

          			$.post("paginas_descargas.php?id=<?= $id ?>",   function(data1){            

                      /// Ponemos la respuesta de nuestro script en el párrafo recargado  

                      $("#imagenes").html(data1);      });

          			

          			

          			 

          		}

          	});*/


        });
      </script>
      <!-- end #footer -->
    </div>
    <!-- end #container -->
  </div>
</body>

</html>