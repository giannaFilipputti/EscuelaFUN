<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//header("Location: preinscripcion.php");


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";

$curs = new Curso();
$cursos = $curs->getAll();


$are = new Area();
$areas = $are->getAll();



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

            <div class="home-hero" data-src="assets/images/banner.jpg?v=3" uk-img>
                <div class="uk-width-1-1">
                    <div class="page-content-inner uk-position-z-index text-center">
                        <h1 style="color:#ffffff">Escuela de Especialización <br> Deportiva FENAUDE</h1>
                        <h4 class="my-lg-4" style="color:#ffffff"> Entrenadores, Jueces, Dirigencia y Comunidad.
                        </h4>
                        <?php if ($authj->logueado == 1) { ?>
                            <a href="cursos.php" class="btn btn-default">Ver Cursos </a>
                        <?php } else { ?>
                            <a href="login.php" class="btn btn-danger btn-lg">INSCRIPCIONES ABIERTAS </a>


                        <?php }  ?>
                    </div>
                </div>
            </div>

            <!-- Content
        ================================================== -->


            <div class="section text-center">



                <div class="container">

                    <!--

                <div class="video-responsive">
                        <iframe src="https://player.vimeo.com/video/726836646" frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive></iframe>
                    </div>

                        -->


                    <!--
                    <div class="delimitador0">
                        <div class="contenedor0">
                            <iframe src="https://player.vimeo.com/video/726836646"></iframe>
                        </div>
                    </div>

                            -->




                    <!--

                   <div class="video-responsive0">
                    <iframe src="https://player.vimeo.com/video/726829889" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>

                    -->


                </div>
            </div>



            <div class="section-small delimiter-top">

                <div class="page-content-inner">



                    <h3> AREAS </h3>
                    <h5> </h5>
                    <div class="uk-child-width-1-2@s uk-child-width-1-4@m" uk-grid>

                        <?php foreach ($areas as $Elem) {

                            if ($authj->logueado == 1) {
                                $link_mod = "cursos.php?escuela=" . $Elem['id'];
                                $clase_mod = "";
                            } else {
                                //$link_mod = "curso_off.php?id=".$Elem['id'];
                                $link_mod = "login.php";
                                $clase_mod = "disabled";
                            }

                        ?>

                            <div>


                                <a href="<?php echo $link_mod ?>">
                                    <div class="course-path-card <?php echo $clase_mod ?>">
                                        <img src="../assets/images/area_<?php echo $Elem['id'] ?>.png?v=3" alt="">
                                        <div class="course-path-card-contents">
                                            <h3> <?php echo $Elem['escuela'] ?> </h3>

                                        </div>

                                    </div>
                                </a>
                            </div>

                        <?php } ?>

                    </div>

                    <br><br>

                    <h3> CURSOS </h3>

                    <div class="course-grid-slider mt-lg-5" uk-slider="finite: true">
                        <div class="uk-slider-container pb-4">
                            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-4@m uk-grid">

                                <?php foreach ($cursos as $Elem) {
                                    $inscrito = $curs->checkInscritoCurso($Elem['id'], $authj->rowff['id']);
                                    if ($inscrito == 1) {
                                        $link_mod = "curso_det.php?id=" . $Elem['id'];
                                        $clase_mod = "";
                                    } else {
                                        //$link_mod = "curso_off.php?id=".$Elem['id'];
                                        $link_mod = "curso_det.php?id=" . $Elem['id'];
                                        $clase_mod = "disabled";
                                    }

                                ?>
                                    <li>
                                        <a href="<?php echo $link_mod ?>">
                                            <div class="course-card">
                                                <div class="course-card-thumbnail ">
                                                    <img src="../assets/images/course/p<?php echo $Elem['id'] ?>.jpg">
                                                    <span class="play-button-trigger"></span>
                                                </div>
                                                <div class="course-card-body">
                                                    <div class="course-card-info">
                                                        <div>
                                                            <span class="catagroy"><?php echo $Elem['titulo'] ?> </span>
                                                        </div>

                                                    </div>



                                                    <div class="course-card-footer">
                                                        <h5> <i class="icon-feather-film"></i> 4 Módulos </h5>
                                                    </div>
                                                </div>

                                            </div>
                                        </a>
                                    </li>

                                <?php } ?>


                            </ul>


                            <a class="uk-position-center-left uk-position-small uk-hidden-hover slidenav-prev" href="#"
                                uk-slider-item="previous"></a>
                            <a class="uk-position-center-right uk-position-small uk-hidden-hover slidenav-next" href="#"
                                uk-slider-item="next"></a>

                        </div>
                    </div>


                </div>
            </div>








        </div>

        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>

    </div>

    <!-- For Night mode -->
    <?php include('cierre.php'); ?>

</body>

</html>