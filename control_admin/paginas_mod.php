<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$pagina = new Pagina();
$pagina->getOne($id);

$capitulo = new Capitulo();
$capitulo->getOne($pagina->row[0]['capitulo']);

$modulo = new Modulo();
$modulo->getOne($capitulo->row[0]['modulo']);

$curso = new Curso();
$curso->getOne($modulo->row[0]['curso']);

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
        <h1>Paginas del Capitulo: <?php echo $capitulo->row[0]['titulo'];?> del Modulo: <?php echo $modulo->row[0]['titulo'];?> del curso: <?php echo $curso->row[0]['titulo'];?></h1>
        <div class="box">
        <h2>Agregar Pagina del Capitulo </h2>
        <form method="POST" action="paginas_mod1.php?id=<?php echo $id;?>&capitulo=<?php echo $capitulo->row[0]['id'];?>&curso=<?php echo $curso->row[0]['id']?>">
       
        <label><span>Titulo Pagina: </span>
          <input type="text" name="titulo_con" size="20" value="<?php echo $pagina->row[0]['titulo']?>"></label>
          <label><span>Sub-Titulo Pagina: </span>
          <input type="text" name="subtitulo_con" size="20" value="<?php echo $pagina->row[0]['subtitulo']?>"></label>
          <label><span>Autor: </span>
          <input type="text" name="autor_con" size="20" value="<?php echo $pagina->row[0]['autor']?>"></label>
         
           <label id="ver_contenido"><span>Tipo Contenido: </span>
          <input name="tipo" type="radio" value="cont"<?php if ($pagina->row[0]['tipo'] == 'cont') { ?> checked="checked"<?php } ?>>Contenido</label>
          <label id="ver_video"><span>&nbsp;</span>
          <input type="radio" name="tipo" value="video"<?php if ($pagina->row[0]['tipo'] == 'video') { ?> checked="checked"<?php } ?>>Video</label>
          
          <div id="pag_cont" <?php if ($pagina->row[0]['tipo'] == 'video') { ?>class="oculto"<?php } ?>>
        <label><span>Contenido: </span>&nbsp;</label>
         <textarea id="editor1" name="contenido" rows="10" cols="80"></textarea>
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
	editor.setData('<?php echo preg_replace("[\n|\r|\n\r]", ' ', utf8_encode ($pagina->row[0]['contenido']));  ?>');

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	editor.config.templates_files = [ '<?php echo $baseURLcontrol;?>js/mytemplates.js' ];
	CKFinder.setupCKEditor( editor, '<?php echo $baseURL;?>plugins/ckfinder/' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
</script>
</div>
       <div id="pag_video"<?php if ($pagina->row[0]['tipo'] == 'cont') { ?>class="oculto"<?php } ?>>
            <label><span>Codigo de Video: </span>
          <input type="text" name="video" size="20" value="<?php echo $pagina->row[0]['video']?>"></label>
       </div> 
          
       
        
       
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
