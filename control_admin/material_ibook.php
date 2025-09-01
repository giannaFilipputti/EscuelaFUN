<? include("../includes/conn.php");
include("auto.php");
include("../includes/extraer_variables.php");



$sql1 = "SELECT * FROM com_material WHERE id=".$id."";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_array($result1);


$sql0 = "SELECT * FROM com_cursos WHERE id=".$row1['curso']."";
$result0 = mysql_query($sql0);
$row0 = mysql_fetch_array($result0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
<link href="<?php echo $baseURL;?>plugins/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">


function startUpload(id, tipo)
{
	
	
		$('#'+id).uploadifySettings('scriptData', { 'id': <?=$id?> });
		$('#'+id).uploadifyUpload();
	
}
</script>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <? include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <? include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Descarga del Material: <?php echo $row1['nombre'];?> del curso: <?php echo $row0['titulo'];?></h1>
        <div class="box">
        <input type="hidden" id="esp_titulo" value="1" />
        <h2>Agregar PDF para material </h2>
        <div class="botonup"><div id="fileUploadname3">You have a problem with your javascript</div></div>
		<div class="botonup"><a href="javascript:startUpload('fileUploadname3', 'asi')"><img src="body/subir.gif" /></a> |  <a href="javascript:$('#fileUploadname3').fileUploadClearQueue()">Limpiar</a></div>
        
      
       
        
        </div>
        
        <script type="text/javascript">
		$("#fileUploadname3").uploadify({
		'uploader'  : '<?php echo $baseURL;?>plugins/uploadify/uploadify.swf',
        'script'    : '<?php echo $baseURL;?>material/uploadify_book.php',
        'cancelImg' : '<?php echo $baseURL;?>plugins/uploadify/cancel.png',
        'folder': '<?php echo $baseURL;?>material',
		'multi': false,
		'buttonText'  : 'Seleccionar Archivo',
	    'fileExt'     : '*.pdf;*.PDF;*.zip;*.ZIP;*.epub;*.EPUB;',
        'fileDesc'    : 'Web Image Files (.PDF;.ZIP;.EPUB;)',
		'method' : 'post',
		'displayData': 'percentage',
		
               'onError' : function (event,ID,fileObj,errorObj) {
                 alert(errorObj.type + ' Error: ' + errorObj.info);
               },
 
		onAllComplete: function (event, queueID, fileObj, response, data) {
			//alert(data);
			$.post("materiales_ebook_listado.php?id=<?=$id?>",   function(data1){            
            /// Ponemos la respuesta de nuestro script en el párrafo recargado  
            $("#imagenes_asi").html(data1);      });
			
			
			 
		}
	});
	
	
		</script>
       
        
        <div id="imagenes_asi"><? include('materiales_ebook_listado.php') ;?></div>
      
 
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
