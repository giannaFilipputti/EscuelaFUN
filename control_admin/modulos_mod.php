<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$mod = new Modulo();
$mod->getOne($id);

$curso = new Curso();
$curso->getOne($ref);

// $sql = "SELECT * FROM com_cursos_mod WHERE id=".$id."";
// $result = mysql_query($sql);
// $row = mysql_fetch_array($result);

// $sqlc = "SELECT * FROM com_cursos WHERE id=".$ref."";
// $resultc = mysql_query($sqlc);
// $rowc = mysql_fetch_array($resultc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>

<script>
  $(function() {
    $(".datepicker1").datepicker({
	     dateFormat:"yy/mm/dd",
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
        <?php include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <?php include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Modulos: <?php echo $curso->row[0]['titulo'];?></h1>
        <div class="box">
        <h2>Modificar Modulo al curso </h2>
        <form method="POST" action="modulos_mod1.php?id=<?php echo $id?>&ref=<?php echo $ref;?>">
        <label><span>Nombre: </span>
          <input type="text" name="titulo" size="20" value="<?php echo $mod->row[0]['titulo']?>"></label>
          
          <label><span>Titulo en Diploma: </span>
          <input type="text" name="titulo_diploma" size="20" value="<?php echo $mod->row[0]['titulo_diploma']?>"></label>
          
          <label><span>Creditos: </span>
          <input type="text" name="creditos" size="10" value="<?php echo $mod->row[0]['creditos']?>"></label>
          <label><span>No. Acreditacion: </span>
          <input type="text" name="no_acred" size="20" value="<?php echo $mod->row[0]['no_acred']?>"></label>
          <label><span>Periodo: </span>
          <input type="text" name="periodo" size="20" value="<?php echo $mod->row[0]['periodo']?>"></label>
          
          <label><span>Acreditado desde: </span>
          <input type="text" name="acred_desde" class="datepicker1" size="20" value="<?php echo $mod->row[0]['acred_desde']?>" readonly="readonly"></label>
          
          <label><span>Acreditado hasta: </span>
          <input type="text" name="acred_hasta" class="datepicker1" size="20" value="<?php echo $mod->row[0]['acred_hasta']?>" readonly="readonly"></label>
          
          <label><span>Acreditado?: </span>
          <input type="checkbox" name="acreditado" value="1"<?php if ($mod->row[0]['acreditado'] == 1) { ?> checked="checked"<?php } ?>></label>
          
          <label><span>Solicitada acreditación?: </span>
          <input type="checkbox" name="solicitada" value="1"<?php if ($mod->row[0]['solicitada'] == 1) { ?> checked="checked"<?php } ?>></label>
          
          
         <label><span>Horas: </span>
          <input type="text" name="horas" size="10" class="numerico" value="<?php echo $mod->row[0]['horas']?>"></label>
          
          <label><span>Color: </span>
          <input type="text" name="color" size="10" value="<?php echo $mod->row[0]['color']?>"></label>
          
          <label><span>Descripción: </span><textarea name="descripcion" rows="4" cols="40"><?php echo $mod->row[0]['descripcion']?></textarea></label>
           
            <label><span>Subtítulo: </span>
          <input type="text" name="subtitulo" size="20" value="<?php echo $mod->row[0]['subtitulo']?>"></label>
           <label><span>Video (código Vimeo): </span>
          <input type="text" name="video" size="20" value="<?php echo $mod->row[0]['video']?>"></label>
           
          
          <label><span>Introduccion: </span>&nbsp;</label>
         <textarea id="editor1" name="intro" rows="10" cols="80"></textarea>
         <script type="text/javascript">


	var editor = CKEDITOR.replace( 'editor1',

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
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    '/',
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']

        ], 
		stylesCombo_stylesSet: 'my_styles:<?php echo $baseURLcontrol;?>js/styles.js',
     contentsCss : '<?php echo $baseURLcontrol;?>css/losstilos.css',
		

    });
	editor.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', utf8_encode ($row['intro']));  ?>');

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	editor.config.templates_files = [ '<?php echo $baseURLcontrol;?>js/mytemplates.js' ];
	CKFinder.setupCKEditor( editor, '<?php echo $baseURL;?>plugins/ckfinder/' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
</script>
          
          <div class="fmr_sub">Examen del modulo</div>
        <label><span>Mostrar Preg / pag: </span>
          <input type="text" name="preg_pag" size="10" class="numerico" value="<?php echo $mod->row[0]['preg_pag']?>"></label>
        <label><span>Cant. preguntas minima para aprobar: </span>
          <input type="text" name="preg_aprob" size="10" class="numerico" value="<?php echo $mod->row[0]['preg_aprob']?>"></label>
          <br class="clearfloat" />
        <label><span>Porcentaje aprobacion: </span>
          <input type="text" name="porc_aprob" size="10" class="numerico" value="<?php echo $mod->row[0]['porc_aprob']?>">%</label>
          <br class="clearfloat" />
          <?php if ($curso->row[0]['examen'] == 1) { ?>
          <label><span>Examen unico del curso: </span><input type="checkbox" name="ex_unico" value="1"<?php if ($mod->row[0]['examen_unico'] == 1) { ?> checked="checked"<?php } ?> /></label>
         <?php } ?>
        
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
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
