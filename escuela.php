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
                        La Escuela de Especialización Deportiva FUN es un proyecto en alianza entre la Federación Uruguaya de Natación y Capacitaciones PULPRO con el objetivo de profesionalizar el desarrollo deportivo desde todas las áreas que hacen vida dentro de las 5 disciplinas.
                    </p>


                    <p>
                        Le deseamos éxito en su capacitación.
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