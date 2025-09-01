<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";

/*$exam = New Examen();

$valores = $exam->getCertificadoValido($codigo);*/



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

        <div class="page-content-inner">



            <div class="uk-width-1-3@m m-auto my-5">
                <div class="mb-4">
                    <h2 class="mb-0">Validador de Certificado <span class="uk-text-bold"></span></h2>
                   
                </div>
               
<div class="course-details-comments">
                       
                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">NOMBRE DE LA CERTIFICACION:</a></h3>
                                <p>Curso de ejemplo -Escuela de Especialización de deportes acuáticos</p>

                            </div>
                        </div>

                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">NOMBRE PARTICIPANTE:</a></h3>
                                <p>Usuarios de muestra</p>

                            </div>
                        </div>

                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">FECHA DE LA CERTIFICACION:</a></h3>
                                <p>14 de Enero de 2022</p>

                            </div>
                        </div>
                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">ESTADO:</a></h3>
                                <p><?php 
                                        echo "<span class=\"verde\">APROBADO</span>";
                                    
                                    ?></p>

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