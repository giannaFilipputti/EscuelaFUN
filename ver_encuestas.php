<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "registro";
$scripts = "none";

$exam = New Examen();

$encuestas = $exam->getAllEncuesta();


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
                        <h2 class="mb-0">Escuela de Especialización de Deportes Acuáticos <span class="uk-text-bold"></span></h2>

                        
                       
                        <!--<p class="my-0">Ingresa al sistema para iniciar tu curso.</p>-->
                    </div>
                   
                    <?php 
                    $contador = 0;
                    foreach ($encuestas as $encuesta) { 
                        
                        $contador++;?>


                        <h3>Usuario:<?php echo $encuesta['alumno']?><br>Por favor contesta la siguiente encuesta para descargar tu certificado de participación</h3>
                        
                            <input type="hidden" name="modulo" value="<?php echo $id; ?>">
                            <p class="text-primary text-center"><b>Valora del 1 al 5, siendo 5 la calificación más alta (MUY DE ACUERDO) y 1 la más baja (MUY EN DESACUERDO).</b></p>
                            <br>
                            <p class="alert alert-success"><b>Los contenidos del Programa son adecuados para lograr los objetivos y/o aprendizajes esperados.</b></p>
                            <input type="radio" class="css-radio" name="ep1_<?php echo $contador?>" value="1" id="ep11_<?php echo $contador?>"<?php if ($encuesta['p1']==1) { ?> checked<?php } ?>><span for="ep11_<?php echo $contador?>" class="css-span css-span2">1</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep1_<?php echo $contador?>" value="2" id="ep12_<?php echo $contador?>"<?php if ($encuesta['p1']==2) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep12_<?php echo $contador?>">2</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep1_<?php echo $contador?>" value="3" id="ep13_<?php echo $contador?>"<?php if ($encuesta['p1']==3) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep13_<?php echo $contador?>">3</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep1_<?php echo $contador?>" value="4" id="ep14_<?php echo $contador?>"<?php if ($encuesta['p1']==4) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep14_<?php echo $contador?>">4</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep1_<?php echo $contador?>" value="5" id="ep15_<?php echo $contador?>"<?php if ($encuesta['p1']==5) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep15_<?php echo $contador?>">5</span>
                            <br>
                            <p class="alert alert-success"><b>Los contenidos del programa le sirven para su desempeño.</b></p>
                            <input type="radio" class="css-radio" name="ep2_<?php echo $contador?>" value="1" id="ep21_<?php echo $contador?>"<?php if ($encuesta['p2']==1) { ?> checked<?php } ?>><span for="ep21_<?php echo $contador?>" class="css-span css-span2">1</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep2_<?php echo $contador?>" value="2" id="ep22_<?php echo $contador?>"<?php if ($encuesta['p2']==2) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep22_<?php echo $contador?>">2</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep2_<?php echo $contador?>" value="3" id="ep23_<?php echo $contador?>"<?php if ($encuesta['p2']==3) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep23_<?php echo $contador?>">3</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep2_<?php echo $contador?>" value="4" id="ep24_<?php echo $contador?>"<?php if ($encuesta['p2']==4) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep24_<?php echo $contador?>">4</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep2_<?php echo $contador?>" value="5" id="ep25_<?php echo $contador?>"<?php if ($encuesta['p2']==5) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep25_<?php echo $contador?>">5</span>
                            <br>
                            <p class="alert alert-success"><b>El tiempo asignado es suficiente para lograr los objetivos del programa y/o aprendizajes esperados.</b></p>
                            <input type="radio" class="css-radio" name="ep3_<?php echo $contador?>" value="1" id="ep31_<?php echo $contador?>"<?php if ($encuesta['p3']==1) { ?> checked<?php } ?>><span for="ep31_<?php echo $contador?>" class="css-span css-span2">1</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep3_<?php echo $contador?>" value="2" id="ep32_<?php echo $contador?>"<?php if ($encuesta['p3']==2) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep32_<?php echo $contador?>">2</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep3_<?php echo $contador?>" value="3" id="ep33_<?php echo $contador?>"<?php if ($encuesta['p3']==3) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep33_<?php echo $contador?>">3</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep3_<?php echo $contador?>" value="4" id="ep34_<?php echo $contador?>"<?php if ($encuesta['p3']==4) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep34_<?php echo $contador?>">4</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep3_<?php echo $contador?>" value="5" id="ep35_<?php echo $contador?>"<?php if ($encuesta['p3']==5) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep35_<?php echo $contador?>">5</span>
                            <br>
                            <p class="alert alert-success"><b>Los medios audiovisuales y herramientas de la plataforma son adecuados para el desarrollo de las sesiones. </b></p>
                            <input type="radio" class="css-radio" name="ep4_<?php echo $contador?>" value="1" id="ep41_<?php echo $contador?>"<?php if ($encuesta['p4']==1) { ?> checked<?php } ?>><span for="ep41_<?php echo $contador?>" class="css-span css-span2">1</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep4_<?php echo $contador?>" value="2" id="ep42_<?php echo $contador?>"<?php if ($encuesta['p4']==2) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep42_<?php echo $contador?>">2</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep4_<?php echo $contador?>" value="3" id="ep43_<?php echo $contador?>"<?php if ($encuesta['p4']==3) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep43_<?php echo $contador?>">3</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep4_<?php echo $contador?>" value="4" id="ep44_<?php echo $contador?>"<?php if ($encuesta['p4']==4) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep44_<?php echo $contador?>">4</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep4_<?php echo $contador?>" value="5" id="ep45_<?php echo $contador?>"<?php if ($encuesta['p4']==5) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep45_<?php echo $contador?>">5</span>
                            <br>
                            <p class="alert alert-success"><b>La plataforma es intuitiva y facil de usar. </b></p>
                            <input type="radio" class="css-radio" name="ep5_<?php echo $contador?>" value="1" id="ep51_<?php echo $contador?>"<?php if ($encuesta['p5']==1) { ?> checked<?php } ?>><span for="ep51_<?php echo $contador?>" class="css-span css-span2">1</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep5_<?php echo $contador?>" value="2" id="ep52_<?php echo $contador?>"<?php if ($encuesta['p5']==2) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep52_<?php echo $contador?>">2</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep5_<?php echo $contador?>" value="3" id="ep53_<?php echo $contador?>"<?php if ($encuesta['p5']==3) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep53_<?php echo $contador?>">3</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep5_<?php echo $contador?>" value="4" id="ep54_<?php echo $contador?>"<?php if ($encuesta['p5']==4) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep54_<?php echo $contador?>">4</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep5_<?php echo $contador?>" value="5" id="ep55_<?php echo $contador?>"<?php if ($encuesta['p5']==5) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep55_<?php echo $contador?>">5</span>
                            <br>

                           
                            <p class="alert alert-success"><b>¿Recomendarías este curso a otros profesionales?</b></p>
                            <input type="radio" class="css-radio" name="ep6_<?php echo $contador?>" value="1" id="ep61_<?php echo $contador?>"<?php if ($encuesta['p6']==1) { ?> checked<?php } ?>><span for="ep61_<?php echo $contador?>" class="css-span css-span2">1</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep6_<?php echo $contador?>" value="2" id="ep62_<?php echo $contador?>"<?php if ($encuesta['p6']==2) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep62_<?php echo $contador?>">2</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep6_<?php echo $contador?>" value="3" id="ep63_<?php echo $contador?>"<?php if ($encuesta['p6']==3) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep63_<?php echo $contador?>">3</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep6_<?php echo $contador?>" value="4" id="ep64_<?php echo $contador?>"<?php if ($encuesta['p6']==4) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep64_<?php echo $contador?>">4</span>&nbsp;&nbsp;&nbsp;|
                            <input class="css-radio" type="radio" name="ep6_<?php echo $contador?>" value="5" id="ep65_<?php echo $contador?>"<?php if ($encuesta['p6']==5) { ?> checked<?php } ?>><span class="css-span css-span2" for="ep65_<?php echo $contador?>">5</span>
                            <br>
                            <p class="alert alert-success"><b>¿Qué consideras que podríamos mejorar en este curso? </b></p>
                            <textarea class="form-control" rows="4" name="ep7" value=""><?php echo $encuesta['p7']?></textarea>
                            <br>
                           

                 
                        <p>Ya has contestado la encuesta de este modulo</p>
                    <?php } ?>
                 
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