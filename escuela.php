<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";



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

            <div class="page-content-inner">



                <div class="">
                    <div class="mb-4">
                        <h2 class="mb-0">Escuela de Especialización Deportiva FENAUDE <span class="uk-text-bold"></span></h2>
                        <!--<p class="my-0">Ingresa al sistema para iniciar tu curso.</p>-->
                    </div>

                    <p>
                        La Escuela de Especialización Deportiva FENAUDE es un proyecto en alianza entre la Federación Nacional de Deporte Universitario y Capacitaciones PULPRO con el objetivo de profesionalizar el desarrollo deportivo desde todas las áreas que hacen vida dentro de las 5 disciplinas de los deportes del ámbito universitario, desde las bases hasta el nivel competitivo.
                    </p>

                    <p>
                        La escuela cuenta con 3 áreas:
                    </p>
                    <ul>
                        <li>Escuela para entrenadores.</li>
                        <li>Escuela para jueces y árbitros.</li>
                        <li>Escuela para dirigentes deportivos.</li>
                    </ul>
                    <p>
                        Cada área cuenta con <a href="cursos.php">cursos</a> específicos para profundizar el conocimiento y unificar criterios en torno a las necesidades identificadas a lo largo de los últimos años alineados con el gran proyecto nacional liderado por la FENAUDE, cada ciclo de capacitación incorporará nuevos contenidos para profundizar en cada una de las áreas de cada disciplinas.
                    </p>
                    <p>
                        Le deseamos éxito en su capacitación.
                    </p>
                    <p>
                        Durante todo el proceso de capacitación asumiremos el compromiso de acompañarle, para dudas y consultas sobre la plataforma agradecemos comunicarse por los teléfonos +56 9 4294 4264 o por el email info@pulpro.com
                    </p>

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