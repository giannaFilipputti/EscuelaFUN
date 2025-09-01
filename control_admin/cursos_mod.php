<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';
$curso = new Curso();
$curso->getOne($id);

// $cat = new Categoria();
// $cat->getAll();
include("header.php");
?>


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
        <h1> Cursos</h1>
        <div class="box">
        <h2>Modificar Curso</h2>
        <?php
        $id = $_GET['id'];
		 ?>
        <form method="POST" action="cursos_mod1.php?id=<?php echo $id;?>">
        <label><span>Nombre: </span>
          <input type="text" name="titulo" size="20" value="<?php echo $curso->row[0]['titulo']?>"></label>
         <label><span>CON: </span>
          <input type="text" name="con" size="20" value="<?php echo $curso->row[0]['con']?>"></label>
          
          <label><span>ZON: </span>
          <input type="text" name="zon" size="20" value="<?php echo $curso->row[0]['zon']?>"></label>
           <label><span>Examen unico del curso: </span><input type="checkbox" name="ex_unico" value="1"<?php if ($curso->row[0]['examen'] == 1) { ?> checked="checked"<?php } ?> /></label>
        <label><span>Texto de Bienvenida: </span>&nbsp;</label>
         <textarea id="editor1" name="bienvenida" rows="10" cols="80"></textarea>
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
	editor.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', utf8_encode ($curso->row[0]['bienvenida']));  ?>');

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	editor.config.templates_files = [ '<?php echo $baseURLcontrol;?>js/mytemplates.js' ];
	CKFinder.setupCKEditor( editor, '<?php echo $baseURL;?>plugins/ckfinder/' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
</script>
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
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
