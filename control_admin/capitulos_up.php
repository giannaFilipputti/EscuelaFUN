<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$capitulo = new Capitulo();
$capitulo->getOne($id);

$mod = new Modulo();
$mod->getOne($capitulo->row[0]['modulo']);


$curso = new Curso();
$curso->getOne($mod->row[0]['curso']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<link href="<?php echo $baseURL;?>plugins/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">


function startUpload(id, tipo)
{
	
	
		$('#'+id).uploadifySettings('scriptData', { 'id': <?php echo $id?> });
		$('#'+id).uploadifyUpload();
	
}
</script>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Agregar Imagen al capitulo: <?php echo $capitulo->row[0]['titulo'];?> del modulo: <?php echo $mod->row[0]['titulo'];?></h1>
        <div class="box">
        <input type="hidden" id="esp_titulo" value="1" />
        <h2>Agregar Imagen </h2>
        <div class="botonup"><div id="fileUploadname3">You have a problem with your javascript</div></div>
		<div class="botonup"><a href="javascript:startUpload('fileUploadname3', 'asi')"><img src="body/subir.gif" /></a> |  <a href="javascript:$('#fileUploadname3').fileUploadClearQueue()">Limpiar</a></div>
        
      
       
        
        </div>
        
        <script type="text/javascript">
		$("#fileUploadname3").uploadify({
		'uploader'  : '<?php echo $baseURL;?>plugins/uploadify/uploadify.swf',
        'script'    : '<?php echo $baseURL;?>uploads/capitulos/uploadify.php',
        'cancelImg' : '<?php echo $baseURL;?>plugins/uploadify/cancel.png',
        'folder': '<?php echo $baseURL;?>uploads/capitulos',
		'multi': false,
		'buttonText'  : 'Seleccionar Archivo',
	    'fileExt'     : '*.jpg;*.gif;*.png',
        'fileDesc'    : 'Web Image Files (.JPG, .GIF, .PNG)',
		'method' : 'post',
		'displayData': 'percentage',
		
               'onError' : function (event,ID,fileObj,errorObj) {
                 alert(errorObj.type + ' Error: ' + errorObj.info);
               },
 
		onAllComplete: function (event, queueID, fileObj, response, data) {
			//alert(data);
			$.post("capitulos_up_listado.php?id=<?php echo $id?>",   function(data1){            
            /// Ponemos la respuesta de nuestro script en el párrafo recargado  
            $("#imagenes_asi").html(data1);      });
			
			
			 
		}
	});
	
	
		</script>
       
        
        <div id="imagenes_asi"><?php include('capitulos_up_listado.php') ;?></div>
      
 
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
