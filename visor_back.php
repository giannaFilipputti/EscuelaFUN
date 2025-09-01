<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";


$curs = new Curso();
$cursos = $curs->getOne($curso);

$mod = New Modulo();
$modulos = $mod->getAll($curso);

$cap = New Capitulo();
//$capitulos = $cap->getAll($modulos[0]['id']);

$cap_act = $cap->getOne($capitulo);
//print_r($cap_act);





?>
<?php include('header.php');?>

 

    <body class="course-watch-page">

        <!-- Wrapper -->
        <div id="wrapper">

            <div class="course-layouts">

                <div class="course-content bg-dark">

                    <div class="course-header">
                        
                        <a href="#" class="btn-back" uk-toggle="target: .course-layouts; cls: course-sidebar-collapse">
                            <i class="icon-feather-chevron-left"></i>
                        </a>

                        <h4 class="text-white"> <?php echo $cursos[0]['titulo'] ?>
                        <small><?php echo $cap_act[0]['titulo']; ?></small>
                    </h4>

                        <div>
                            <a href="#">
                                <i class="icon-feather-help-circle btns"></i> </a>
                            <div uk-drop="pos: bottom-right;mode : click">
                                <div class="uk-card-default p-4">
                                <h4> Contenidos </h4>
                                    <p class="mt-2 mb-0">Debes ir avanzando con la visualización de los contenidos, puedes verlos tantas veces como lo requieras y una vez estés preparado para hacer el examen </p>
                               
                                </div>
                            </div>

                            <a hred="#">
                                <i class="icon-feather-more-vertical btns"></i>
                            </a>
                            <div class="dropdown-option-nav " uk-dropdown="pos: bottom-right ;mode : click">
                                <ul>

                                    <li><a href="#">
                                            <i class="icon-feather-bookmark"></i>
                                            Favoritos</a></li>
                                    <li><a href="intro.php">
                                            <i class="icon-material-outline-arrow-back"></i>
                                            Volver a Cursos </a></li>

                                    <li>
                                        <a href="#" id="night-mode" class="btn-night-mode">
                                            <i class="icon-line-awesome-lightbulb-o"></i> Oscuro 
                                            <label class="btn-night-mode-switch">
                                                <div class="uk-switch-button"></div>
                                            </label>
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </div>

                    </div>

                    <div class="course-content-inner">
                    <div class="video-responsive">
                                    <iframe src="https://player.vimeo.com/video/<?php echo $cap_act[0]['video']; ?>" frameborder="0"
                                        uk-video="automute: false" allowfullscreen uk-responsive></iframe>
                                </div>

                        

                    </div>

                </div>

                <!-- course sidebar -->

                <div class="course-sidebar">
                    <div class="course-sidebar-title">
                        <h3> <?php echo  $cursos[0]['titulo']; ?> </h3>
                    </div>
                    <div class="course-sidebar-container" data-simplebar>

                        <ul class="course-video-list-section" uk-accordion>


                        <?php foreach ($modulos as $Elem) { 
                            $capitulos = $cap->getAll($Elem['id']);
                            $contador = 0;
                            
                            ?>
                            <li <?php if ($modulo == $Elem['id']) {  ?> class="uk-open"<?php  } ?>>
                                <a class="uk-accordion-title" href="#"> <?php echo  $Elem['titulo']; ?> </a>
                                <div class="uk-accordion-content">
                                    <!-- course-video-list -->
                                    <ul class="course-video-list<?php if ($modulo == $Elem['id']) {  ?> highlight-watched<?php  } ?>">
                                    <?php foreach ($capitulos as $Elem1) {  
                                        $visita = $cap->checkVisita($authj->rowff['id'], $Elem1['id']);
                                        ?>
                                        <li class="<?php if ($visita > 0) {  ?>watched<?php  } ?><?php if ($capitulo == $Elem1['id']) {  ?> uk-active<?php  } ?>"> <a href="visor.php?curso=<?php echo $Elem['curso']; ?>&modulo=<?php echo $Elem['id']; ?>&capitulo=<?php echo $Elem1['id']; ?>"> <?php echo $Elem1['titulo']; echo '&nbsp;'; echo '(<b>'.$Elem1['revista'].'</b>)'; ?> <span> </span> </a> </li>
                                    <?php $contador ++;
                                } ?>

                                <?php if ($Elem['examen_unico'] == 1 and $Elem['abierto'] == 1) {  ?>
                                    <li> <a href="inicio_examen.php?curso=<?php echo $Elem['curso']; ?>&id=<?php echo $Elem['id']; ?>"> Realizar Examen <span> </span> </a> </li>

                                <?php } else if ($contador > 0) {  ?>

                                    
                                    <?php } else {  ?>
                                        <li><a href="#"?>Contenido aun no disponible </a></li>
                                    <?php } ?>    
                                </ul>
                                </div>
                            </li>

                            <?php } ?>
                            <!--<li> <a href="examen.php?curso=<?php echo $Elem['curso']; ?>&modulo=<?php echo $Elem['id']; ?>"> Realizar Examen <span> </span> </a>
                            <ul class="course-video-list highlight-watched">
                                  
                                     
                                        <li><a href="#"?>Contenido disponible a<br>partir del viernes 6 de Noviembre </li>
                               
                                </ul>
                        </li> -->
  

                        </ul>

                    </div>

                </div>

            </div>



        </div>


        <script>
            (function (window, document, undefined) {
                'use strict';
                if (!('localStorage' in window)) return;
                var nightMode = localStorage.getItem('gmtNightMode');
                if (nightMode) {
                    document.documentElement.className += ' night-mode';
                }
            })(window, document);


            (function (window, document, undefined) {

                'use strict';

                // Feature test
                if (!('localStorage' in window)) return;

                // Get our newly insert toggle
                var nightMode = document.querySelector('#night-mode');
                if (!nightMode) return;

                // When clicked, toggle night mode on or off
                nightMode.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.documentElement.classList.toggle('night-mode');
                    if (document.documentElement.classList.contains('night-mode')) {
                        localStorage.setItem('gmtNightMode', true);
                        return;
                    }
                    localStorage.removeItem('gmtNightMode');
                }, false);

            })(window, document);
        </script>

        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      
        <?php 

//$cap->registrarVisita($authj->rowff['id'], $capitulo);

?>

        <!-- javaScripts
            ================================================== -->
        <script src="../assets/js/framework.js"></script>
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/mmenu.min.js"></script>
        <script src="../assets/js/simplebar.js"></script>
        <script src="../assets/js/main.js"></script>
        
        <script>

            let id_usuario = <?php echo $authj->rowff['id']; ?>;

            let capitulo = <?php echo $capitulo; ?>;

            setTimeout(function(){ 

                //console.log("40 segundos | ID_USUARIO: "+id_usuario+" | CAPITULO: "+capitulo);

                $.ajax({

                    type: "POST",
                    url: "visto.php",
                    data: {id_usuario: id_usuario, capitulo: capitulo},
                    success: function() {            
                        //console.log('Visto');
                    },

                }).fail(function(jqXHR, textStatus){
                    console.log(jqXHR);
                    console.log(textStatus);
                });
            
            }, 40000);
        
        </script>

    </body>

</html>