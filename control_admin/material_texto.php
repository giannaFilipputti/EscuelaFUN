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
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>

<link href="<?php echo $baseURL;?>plugins/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $baseURL;?>plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo $baseURLcontrol;?>js/funciones.js"></script>

<script type="text/javascript">


function startUpload(id, conditional)
{
	if(conditional.value.length != 0) {
		
		

		$('#'+id).uploadifySettings('scriptData', { 'titulo': remplazos($('#titulo').val()),'tipo': remplazos($('#tipo').val()),'contenido': remplazos($('#contenido').val()), 'curso': <?=$id?> });
		$('#'+id).uploadifyUpload();
	} else
		alert("Debe ingresar un nombre");
}



$(document).ready(function() {
	


	$("#fileUploadname3").uploadify({
		'uploader'  : '<?php echo $baseURL;?>plugins/uploadify/uploadify.swf',
        'script'    : '<?php echo $baseURL;?>material/uploadify.php',
        'cancelImg' : '<?php echo $baseURL;?>plugins/uploadify/cancel.png',
        'folder': '<?php echo $baseURL;?>material',
		'multi': false,
		'buttonText'  : 'Seleccionar Imagen',
	    'fileExt'     : '*.pdf;*.PDF;*.zip;*.ZIP;*.jpg;*.gif;*.png;*.JPG;*.GIF;*.PNG',
        'fileDesc'    : 'Web Image Files (.PDF; .ZIP; .GIF; .PNG; .JPG)',
		'method' : 'post',
		'displayData': 'percentage',
 
		onAllComplete: function (event, queueID, fileObj, response, data) {
			//alert(data);
			$.post("material_listado.php?id=<?=$id?>",   function(data1){            
            /// Ponemos la respuesta de nuestro script en el párrafo recargado  
            $("#imagenes").html(data1);      });
			$('#titulo').attr('value','');			 
			 $('#contenido').val('');
			 
			 $(".check").removeAttr("checked");
			
			
			 
		}
	});

	


});

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
        <h1>Documentaci&oacute;n Complementaria: <?php echo $row['titulo'];?></h1>
      
        <div id="imagenes">
        <h2>Material de Vista (<a href="material.php">Volver</a>)</h2>
        
        
        

<?php



          $sql_1 = "SELECT * FROM com_material WHERE curso = ". $id ." ORDER BY tipo, orden";
          $result_1 = mysql_query($sql_1);
    ?>
      <form action="material_texto_act.php?id=<?php echo $id?>" method="post">
      <input type="submit" />
    <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
        
        <td width="45%" align="center">Nombre</td>
        <td width="15%" align="center">Link</td>
        <td width="25%" align="center">Texto</td>
        <td width="25%" align="center">Tipo</td>
        
        </tr>
        <?php $contador = 1;
		while ($row_1 = mysql_fetch_array($result_1)) { 
		//$descr = strip_tags($row['fra']);
		
		?>
        <tr id="table6-row-<?=$row['id']?>">
         
          <td align="center"><?php echo $row_1['nombre']?><br /><img src="../material/<?php echo $row_1['contenido']?>" width="150" /></td>
          <td><a href="material_up.php?id=<?php echo $row_1['id']?>">PDF</a><br />
              <?php if ($row_1['tipo'] == 'recetas') {?><a href="material_ebook.php?id=<?php echo $row_1['id']?>">eBook</a><?php } ?></td>
          <td align="center">
              
             <textarea id="editor<?php echo $contador?>" name="text_<?php echo $row_1['id']?>"><?php echo $row_1['descripcion']?></textarea>
              
          </td>
          <td><?php echo $row_1['tipo']?></td>
          
        
       
        
      </tr>
      <?php $contador = $contador + 1;
	  } ?>
        </table>
        <input type="submit" />
        </form>
        <div id="AjaxResult"></div>
    <br /><br />
    </div>
    
 
 
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
