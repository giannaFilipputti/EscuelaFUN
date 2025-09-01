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
$modulos = $mod->getOne($modulo);



?>
<?php include('header.php');?>

<body>
    <!-- Wrapper -->
    <div id="wrapper" class="bg-white">
        <!-- Header Container
        ================================================== -->       

                        <!-- MENU -->
						<?php include('menu.php');?>                      
                      

        <!-- overlay seach on mobile-->  
        <div class="page-content">
        <div class="course-details-wrapper topic-1 uk-light">
            <div class="container p-sm-0">

                <div uk-grid>
                    <div class="uk-width-2-3@m">

                        <div class="course-details">
                            <h1> <?php echo $cursos[0]['titulo'] ?></h1>
                            <p> Examen del Módulo: <?php echo $modulos[0]['bienvenido'] ?> </p>

                            <div class="course-details-info">

                                <ul>
                                    <li> Profesores <a href="#"> <?php echo $cursos[0]['profesores'] ?> </a> </li>
                                    <!--<li> Last updated 10/2019</li> -->
                                </ul>

                            </div>
                        </div>
                        <nav class="responsive-tab style-5">
                            <ul
                                uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                <li><a href="#">Contenidos</a></li>
                                <li><a href="#">Descripcion</a></li>
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

                        <!-- course Curriculum-->
                        El examen estará disponible a partir del Lunes 02 de noviembre                     


                    </ul>
                </div>

                <div class="uk-width-1-3@m">
                    <div class="course-card-trailer" uk-sticky="top: 10 ;offset:105 ; media: @m ; bottom:true">

                        <div class="p-3">

                        <img src="../assets/images/course/<?php echo $curso ?>.jpg" alt="">

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

    <?php include('cierre.php'); ?>

</body>

</html>