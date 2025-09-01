<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";

/*
if($authj->rowff['cambiopass'] == 0){

    header("location: misdatos_pass.php");
        
}*/

$curs = new Curso();
$cursos = $curs->getCursosSinPrerequisitos($authj->rowff['id']);


//$acceso = Curso::getInfoPago($idpago, $authj->rowff['id']);


?>
<?php include('header.php'); ?>

<body>
    <!-- Wrapper -->
    <div id="wrapper" class="bg-white">
        <!-- Header Container
        ================================================== -->

        <!-- MENU -->
        <?php include('menu.php'); ?>


        <!-- overlay seach on mobile-->
        <div class="page-content">
            <div class="course-details-wrapper topic-1 uk-light">
                <div class="container p-sm-0">

                    <div uk-grid>
                        <div class="uk-width-2-3@m">

                            <div class="course-details">
                                <h1> Cursos a Inscribir</h1>
                                <p> <?php echo $cursos[0]['bienvenido'] ?> </p>

                                <div class="course-details-info">

                                    <ul>

                                        <!--<li> Last updated 10/2019</li> -->
                                    </ul>

                                </div>
                            </div>
                            <nav class="responsive-tab style-5">
                                <ul uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">

                                    <li><a href="#">Cursos a validar</a></li>
                                </ul>
                            </nav>

                        </div>
                    </div>

                </div>
            </div>

            <div class="container">

                <div class="uk-grid-large mt-4" uk-grid>
                    <div class="uk-width-2-3@m">
                        <ul id="course-intro-tab" class="uk-switcher mt-4">
                            <li>

                                <?php
                                $contador = 0;
                                $notapre = 0;
                                $arrPre = array();
                                $total = 0;
                                foreach ($cursos as $Elem) {
                                    $total = $total + $Elem[$getPrecio]; 
                                    $contador ++;?>

                                    <div class="course-card course-card-list">
                                        <div class="course-card-thumbnail">
                                            <img src="assets/images/course/p<?php echo $Elem['idC'] ?>.jpg" style="max-widht:200px">
                                            <a href="course-intro.html" class="play-button-trigger"></a>
                                        </div>
                                        <div class="course-card-body">

                                            <h4><?php echo $Elem['titulo']; ?></h4>

                                            <h5>Precio: <?php echo $Elem[$getPrecio] ?></h5>

                                            <?php if ($Elem['acred_pre'] == 1) {
                                                 ?>
                                                <?php echo $Elem['acred_prere']; ?>

                                                <?php if ($Elem['validprerequisitos']==1) { ?>
                                                    
                                                    <?php }  else { 
                                                        $arrPre[] = $Elem['idC']; ?>

                                                <div class="formulario">

                                                    <div id="dropzone_<?php echo $Elem['idC']; ?>" class="dropzone"></div>
                                                </div>
                                                <?php }   ?>
                                                <?php $curso = $Elem['idC']; ?>
                                               
                                                <div class="course-details-info" id="info_pre_<?php echo $Elem['idC']; ?>">
                                                <?php
                                                $prerequisitos = Curso::validPrerequisitos($curso, $authj->rowff['id']);  ?>
                                                    <ul>
                                                        <?php if ($prerequisitos['estado'] == 1) { ?>

                                                            <li class="alert alert-success"> <i class="icon-material-outline-check-circle" style="color:#2EAD52"></i> Pre-requisitos validados </li>
                                                        <?php } else if (count($prerequisitos['documentos']) > 0) { ?>
                                                            <li class="alert alert-warning"> <i class="icon-material-outline-check-circle" style="color:#2EAD52"></i> Enviados pre-requisitos (pendiente validación) </li>
                                                        <?php } else { 
                                                            $notapre = 1; ?>
                                                            <li class="alert alert-danger"> <i class="icon-line-awesome-clock-o" style="color:#FDB613"></i> Pendiente envio pre-requisitos </li>
                                                        <?php }  ?>


                                                    </ul>
                                                </div>

                                            <?php } ?>

                                            

                                            <?php if (!empty($getUltPago['id']) && $getUltPago['estadopago'] == 0 && $getUltPago['tipopago'] == 1 && $getUltPago['comprobante'] == 1 ) { ?>
                                            <?php }  else { ?>
                                        <small><a href="curso_preins_elim.php?id=<?php echo $Elem['id']?>" onClick="return confirm('Esta seguro de eliminar la pre-inscripcion en este curso ?');"> <i
                                                class="uil-trash"></i>Eliminar pre-inscripcion</a></small>
                                        <?php } ?>

                                        </div>
                                        
                                    </div>
                                <?php } ?>


                                <?php if (count($arrPre) >0) { ?> 
                                    <p class="alert alert-danger">
                                        Consideraciones:<br>
                                         - No podrá iniciar el curso hasta que acredite los pre-requisitos exigidos.<br>
                                        
                                         - Los estudiantes que no acrediten los pre-requisitos de los cursos que los exigen (Curso Entrenador De Natación Nivel 2 y Nivel 3) deberán presentar el examen de la certificación requerida y aprobarlo antes de iniciar el curso. </p>
                                                <?php } ?>


                            </li>





                        </ul>




                    </div>

                    <div class="uk-width-1-3@m">
                        <div class="course-card-trailer" uk-sticky="top: 10 ;offset:105 ; media: @m ; bottom:true">

                            <div class="course-thumbnail">
                                <!--<img src="../assets/images/course/f<?php echo $cursos[0]['idC'] ?>.png?v=2" alt="">
                            <a class="play-button-trigger show" href="#trailer-modal" uk-toggle> </a>-->
                                <br<br>
                            </div>

                            <!-- video demo model -->
                            <div id="trailer-modal" uk-modal>
                                <div class="uk-modal-dialog">
                                    <button class="uk-modal-close-default mt-2  mr-1" type="button" uk-close></button>


                                    <div class="uk-modal-body">
                                        <h3>&nbsp; </h3>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>

                                    </div>
                                </div>
                            </div>

                            <div class="p-3">

                                <img src="assets/images/course/<?php echo $id ?>.jpg?v=5" alt="">

                                <p class="my-3 text-center">

                                


                                </p>




                            </div>
                        </div>
                    </div>

                </div>





            </div>

        </div>

        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>

    </div>

    <?php if (!empty($idpago) && $idpago == $getUltPago['id']  && ($getUltPago['estadopago'] == 2 or $getUltPago['estadopago'] == 3)) { ?>

                                <div id="modal-example" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body">
                                        <h2 class="uk-modal-title"> Procesamiento de pago</h2>
                                        <?php if ($getUltPago['estadopago'] == 3) { ?>
                                        <p class="rojo">Error! Hubo un error en el procesamiento de su pago, por favor intentelo nuevamente o contacte a su institución bancaria.<br>
                                        <?php } else if ($getUltPago['estadopago'] == 2) { ?>
                                            <p class="verde">Felicidades <?php echo $authj->rowff['nombre']." ".$authj->rowff['ape1']. " ". $authj->rowff['ape2'] ?>!. Su pago fue procesado correctamente. Ya estás inscrito!<br>

                                            <a href="cursos.php" class="btn btn-success"> <i
                                                class="uil-play"></i> Ver cursos </a>
                                            <?php } ?>
                                        
                                        </p>
                                        <p class="uk-text-right">
                                            <button class="uk-button uk-button-default uk-modal-close"
                                                type="button">Cerrar</button>
                                            
                                        </p>
                                    </div>
                                </div>
                                <?php } ?>


    <?php include('cierre.php'); ?>
    <?php if (!empty($idpago) && $idpago == $getUltPago['id']  && ($getUltPago['estadopago'] == 2 or $getUltPago['estadopago'] == 3)) { ?>
    <script> $(function() {
            var modal = UIkit.modal("#modal-example");
            modal.show(); 
        });</script>
        <?php } ?>

    <script src="plugins/dropzone/min/dropzone.min.js?v=2"></script>

    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        <?php foreach ($arrPre as $valor) { ?>

            $("#dropzone_<?php echo $valor ?>").dropzone({
                url: "<?php echo $baseUrl ?>uploads/prerequisitos.php",
                addRemoveLinks: true,
                dictResponseError: "Ha ocurrido un error en el server",
                acceptedFiles: 'image/*,.jpeg,.jpg,.png,.xlsx,.xls,.doc,.docx,.pdf,.ppt,.pptx,.gif,.JPEG,.JPG,.PNG,.XLSX,.XLS,.DOC,.DOCX,.PDF,.PPT,.PPTX,.GIF',
                uploadMultiple: false,
                maxFiles: 1,
                maxfilesexceeded: function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                },
                params: {
                    curso: '<?php echo $valor ?>',
                    usuario: '<?php echo $authj->rowff['id'] ?>'
                },
                complete: function(file, response) {
                    if (file.status == "success") {


                        $("#info_pre_<?php echo $valor ?>").load("curso_checkPre.php?curso=<?php echo $valor; ?>", function() {

                            //$('#statusMsg').html('<span style="color:green;">Gracias por agregar imagen.</p>');

                            alert("Archivo subido correctamente");


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
        <?php } ?>

        <?php if ($trans == 1) { ?>
        $("#dropzone_trans").dropzone({
                url: "<?php echo $baseUrl ?>uploads/transferencias.php",
                addRemoveLinks: true,
                dictResponseError: "Ha ocurrido un error en el server",
                acceptedFiles: 'image/*,.jpeg,.jpg,.png,.xlsx,.xls,.doc,.docx,.pdf,.ppt,.pptx,.gif,.JPEG,.JPG,.PNG,.XLSX,.XLS,.DOC,.DOCX,.PDF,.PPT,.PPTX,.GIF',
                uploadMultiple: false,
                maxFiles: 1,
                maxfilesexceeded: function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                },
                params: {
                    idpago: '<?php echo $getUltPago['id'] ?>',
                    usuario: '<?php echo $authj->rowff['id'] ?>'
                },
                complete: function(file, response) {
                    if (file.status == "success") {


                       // $("#info_pre_<?php echo $valor ?>").load("curso_checkPre.php?curso=<?php echo $valor; ?>", function() {

                            //$('#statusMsg').html('<span style="color:green;">Gracias por agregar imagen.</p>');

                            alert("Se envio el comprobante correctamente, en breve su pago será procesado");
                            location.reload();


                       // });
                        this.removeFile(file);

                    }
                },
                error: function(file, response) {
                    console.log(response);
                    alert("Error subiendo el comprobante " + file.name);
                },
                removedfile: function(file, serverFileName) {
                    var name = file.name;

                    var element;
                    (element = file.previewElement) != null ?
                        element.parentNode.removeChild(file.previewElement) :
                        false;

                }
            });

        <?php } ?>
    </script>

</body>

</html>