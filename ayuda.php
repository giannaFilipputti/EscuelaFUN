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
                        <h2 class="mb-0">Bienvenido <span class="uk-text-bold"></span></h2>
                        <p class="my-0">Ingresa al sistema para iniciar tu curso.</p>
                    </div>


                    <h1>Tutorial Acceso a la plataforma</h1>

                    <!--

                    <div class="delimitador0">
                        <div class="contenedor0">
                            <iframe src="https://player.vimeo.com/video/726829889"></iframe>
                        </div>
                    </div>

                            -->


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