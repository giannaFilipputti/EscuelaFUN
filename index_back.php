<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";

$curs = new Curso();
$cursos = $curs->getAll();



?>
<?php include('header.php');?>

<body>

    <!-- Wrapper -->
    <div id="wrapper" class="bg-white">

        <!-- Header Container
        ================================================== -->
        

                        <!-- MENU -->
						<header class="header header-horizontal header bg-white uk-light">

    <div class="container">
        <nav uk-navbar>

            <!-- left Side Content -->
            <div class="uk-navbar-left">

                <!-- menu icon -->
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>

                <!-- logo -->
                <a href="index.php" class="logo">
                    <img src="assets/images/logos.png" alt="">
                </a>
                <nav id="navigation">
                    <ul id="responsive">
                       
                    </ul>
                </nav>

                <!-- MENU -->

            </div>


            <!--  Right Side Content   -->

            <div class="uk-navbar-right">

                <nav id="navigation">
                
                
                    <ul id="responsive">
                    

                    </ul>
                </nav>


                <!-- icon search-->


                <!-- User icons -->


            </div>
            <!-- End Right Side Content / End -->


        </nav>

    </div>
    <!-- container  / End -->

</header>
                        
                      

        <!-- overlay seach on mobile-->
      



        <div class="page-content">

            <div class="home-hero" data-src="assets/images/banner.jpg?v=2" uk-img>
                <div class="uk-width-1-1">
                    <div class="page-content-inner uk-position-z-index">
                        <h1 style="color:#ffffff">Inauguración Ciclo de <br> </h1>
                        <h4 class="my-lg-4" style="color:#ffffff"> Capacitación Nacional de Técnicos y Jueces de Natación.
                        </h4>
                        <a href="https://pulpro.zoom.us/j/99592976646?pwd=T2JESkp6OEl4UVJuT0xZYnV4QlhJZz09" class="btn btn-default">Acceder</a>
                    </div>
                </div>
            </div>

            <!-- Content
        ================================================== -->

 


        </div>

        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>

    </div>

    <!-- For Night mode -->
    <?php include('cierre.php'); ?>

</body>

</html>