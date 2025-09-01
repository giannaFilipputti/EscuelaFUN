<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";

$exam = New Examen();

$valores = $exam->getCertificadoValido($codigo);



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
                                <p><?php echo $valores[0]['titulo'] ?></p>

                            </div>
                        </div>

                        <?php if ($valores[0]['horas']>0 && !empty($valores[0]['horas']))  { ?>

                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">HORAS:</a></h3>
                                <p><?php echo $valores[0]['horas'] ?></p>

                            </div>
                        </div>
                        <?php } ?>

                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">NOMBRE PARTICIPANTE:</a></h3>
                                <p><?php echo $valores[0]['nombre'] . " " . $valores[0]['ape1'] . " " . $valores[0]['ape2'] ?></p>

                            </div>
                        </div>

                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">FECHA DE LA CERTIFICACION:</a></h3>
                                <p><?php $fecha = strtotime($valores[0]['fecfin']);
                                    echo date('d', $fecha) . " de " . mostrarMes(date('m', $fecha)) . " de " . date('Y', $fecha); ?></p>

                            </div>
                        </div>
                        <div class="media">

                            <div class="media-body">
                                <h3><a href="#">ESTADO:</a></h3>
                                <p><?php if ($valores[0]['aprobado'] == 1) {
                                        echo "<span class=\"verde\">APROBADO</span>";
                                    } else {
                                        echo "<span class=\"rojo\">NO APROBADO</span>";
                                    }
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