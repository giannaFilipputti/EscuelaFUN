<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
extract($_GET);
if (empty($id)) $id = 'no'; 

$ponencia = new Diapositiva();
$ponencia->getAll($id);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts1.php");?>

<script type="text/javascript">
$(document).ready(function() {
  
  
  $('#img_upload').uploadify({
    'uploader'  : '<?php echo $baseURL;?>plugins/uploadify/uploadify.swf',
    'script'    : '<?php echo $baseURL;?>uploads/diapositivas.php',
    'cancelImg' : '<?php echo $baseURL;?>plugins/uploadify/cancel.png',
    'folder'    : '<?php echo $baseURL;?>uploads/ponencias/<?php echo $id?>/',
    'auto'      : true,
	'multi'       : true,
	'buttonText'  : 'Agregar Imagenes',
	'scriptData'  : {'contenido':<?=$id?>},
	
	'onComplete' : function(event, queueID, fileObj, response, data) {
      $.post("ponencias_img1.php?id=<?=$id?>",   function(data1){            
       /// Ponemos la respuesta de nuestro script en el párrafo recargado  
      $("#imagenes1").html(data1);      }); 
	  //alert("Successfully uploaded: "+response);
    }
	
	
  });
  
  
 
  
});
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
     
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Ponencias </h1>
        
        
        <div id="imagenes1">
		
		  <?php  

          // $sql = "SELECT * FROM com_ponencias_ima WHERE ponencia=".$id." ORDER BY orden";
          // //echo $sql;
          // $result = mysql_query($sql,$link);
		   
		  
    ?>
    
    <form action="ponencias_act_texto.php?id=<?php echo $id?>" method="post">
    <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
   <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
        <td width="5%" align="center">Orden</td>
        <td width="20%" align="center">Imagen</td>
        <td width="70%" align="center" class="img_ponencias">Texto para busquedas</td>
        
      
        </tr>
        <?php 
		$contador = 1;
		foreach($ponencia->row as $Elem){
			$tiempo = '';
			
			
			?>
           <tr id="table6-row-<?=$row['id']?>">
          <td class="dragHandle">&nbsp;</td>
          
       <td align="center">
       <?php if (empty($Elem['video'])) { ?>
         <img border="0" class="img_ponencias" src="<?php echo $baseURL;?>uploads/ponencias/<?php echo $Elem['ponencia']?>/<?php echo $Elem['nombre']?>?id=<?=mt_rand(0,5)?>" width="350" /><br /><?php echo $Elem['nombre']?>
         <br />
         URL: <?php echo $Elem['id']?><br />
         <a href="ponencias_up_link.php?id=<?php echo $Elem['id']?>">Administrar Links</a>
       <?php } else { ?>
       <iframe src="http://player.vimeo.com/video/<?php echo $Elem['video']?>?api=1" width="220" height="110" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
       <?php }  ?></td>
       <td class="img_ponencias"><textarea id="editor<?php echo $contador?>" name="text_<?php echo $Elem['id']?>"><?php echo $Elem['texto']?></textarea>
       
       <script type="text/javascript">


	var editor<?php echo $contador?> = CKEDITOR.replace( 'editor<?php echo $contador?>',

    {

        toolbar :

        [

            ['Source','-','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
   
    '/',
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['BidiLtr', 'BidiRtl' ],
    ['Link','Unlink','Anchor'],
    '/',
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']

        ], 
		stylesCombo_stylesSet: 'my_styles:<?php echo $baseURLcontrol;?>js/styles.js',
     contentsCss : '<?php echo $baseURLcontrol;?>css/losstilos.css',
		

    });
	editor<?php echo $contador?>.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', $Elem['texto']);  ?>');

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	editor<?php echo $contador?>.config.templates_files = [ '<?php echo $baseURLcontrol;?>js/mytemplates.js' ];
	CKFinder.setupCKEditor( editor<?php echo $contador?>, '<?php echo $baseURL;?>plugins/ckfinder/' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
</script>

</td>
       
       
        
      </tr>
        <?php $contador = $contador + 1;
		} ?>
        </table>
         <div id="AjaxResult"></div>
    <br /><br />
    
        <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
        </form>
      
    <br /><br />
       
        </div>
            
            
    <br /><br />

    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <?php include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
