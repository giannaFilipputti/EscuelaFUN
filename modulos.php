<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";

/*
if($authj->rowff['cambiopass'] == 0){

    header("location: misdatos_pass.php");
        
}*/

$curs = new Curso();
$cursos = $curs->getOne($id);

$mod = new Modulo();
$modulos = $mod->getAll($id);

$inscrito = Curso::getInscritoCurso($id, $authj->rowff['id']);

if ($inscrito[0]['estado'] != 1 and $authj->rowff['labor'] < 6) {
    header("location: cursos.php");
    die();
}

if (empty($inscrito[0]['fecini']) || empty($inscrito[0]['fecfin'])) {
    $data4 = array();
    if ($inscrito[0]['fecha'] >= $cursos[0]['fecha']) {
        $data4['fecini'] = $inscrito[0]['fecha'];
    } else {
        $data4['fecini'] = $cursos[0]['fecha'];
    }

    //echo $acred_hasta;
    $acred_hasta1 = strtotime($data4['fecini'] . "+ " . $cursos[0]['plazo'] . " days");
    $acred_hasta = date("Y-m-d H:i:s", $acred_hasta1);
    $data4['fecfin'] = $acred_hasta;
    Curso::updateFechasInicio($inscrito[0]['id'], $authj->rowff['id'], $data4);
} else {

    $acred_hasta = $inscrito[0]['fecfin'];
}

$datetime1 = new DateTime($acred_hasta);
$datetime2 = new DateTime(date('Y-m-d H:i:s'));
$interval = $datetime1->diff($datetime2);

if ($interval->format('%R') == '-') {
    $duracion = $interval->format('%a');
} else {
    $duracion = '-';
}


$cap = new Capitulo();

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
            <div class="course-details-wrapper topic-1 uk-light">
                <div class="container p-sm-0">

                    <div uk-grid>
                        <div class="uk-width-2-3@m">

                            <div class="course-details">
                                <h1> <?php echo $cursos[0]['titulo'] ?></h1>
                                <p> <?php echo $cursos[0]['bienvenido'] ?> </p>

                                <div class="course-details-info">

                                    <ul>
                                        <li> Profesores <a href="#"> <?php echo $cursos[0]['profesores'] ?> </a> </li>
                                        <!--<li> Last updated 10/2019</li> -->
                                    </ul>

                                </div>
                            </div>
                            <nav class="responsive-tab style-5">
                                <ul uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                    <li><a href="#">Contenidos</a></li>
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
                            <li>


                                <ul class="course-curriculum" uk-accordion="multiple: true">
                                    <?php
                                    $cant_mod = count($modulos);
                                    foreach ($modulos as $Elem) {

                                        $capitulos = $cap->getAll($Elem['id']);
                                        $valores_mod = Modulo::getAvance($Elem['id'], $authj->rowff['id']);
                                        $porc_mod = $valores_mod['porcentaje'];

                                    ?>
                                        <li <?php if ($cant_mod == 1) { ?>class="uk-open" <?php } ?>>
                                            <a class="uk-accordion-title" href="#"> <?php echo $Elem['titulo'] ?> <?php if ($porc_mod > 0) { ?> <span class="circulo_verde"><?php echo $porc_mod; ?>%</span><?php } ?> </a>
                                            <div class="uk-accordion-content">

                                                <!-- course-video-list -->
                                                <ul class="course-curriculum-list">

                                                    <?php foreach ($capitulos as $Elem1) {
                                                        $visita0 = $cap->checkVisita($authj->rowff['id'], $Elem1['id']);
                                                        $visita = $visita0['porcentaje'];
                                                        if (empty($visita)) {
                                                            $visita = 0;
                                                        }
                                                        if ($visita < 10) {
                                                            $claseC = "circulo_azulp";
                                                        } else if ($visita >= 95) {
                                                            $claseC = "circulo_verde";
                                                        } else {
                                                            $claseC = "circulo_azul";
                                                        }
                                                    ?>

                                                        <li><?php if ($visita >= 0) { ?> <span class="<?php echo $claseC ?>"><?php echo $visita; ?>%</span><?php } ?><a href="visor.php?curso=<?php echo $id ?>&modulo=<?php echo  $Elem['id'] ?>&capitulo=<?php echo  $Elem1['id'] ?>"><?php echo  $Elem1['titulo'] ?></a> <span class="autor"> <?php echo  $Elem1['autor'] ?></span><a class="boton" style="color: white;"><?php echo Funcion::convertiraMin($Elem1['duracion']); ?></a>

                                                        <?php }  ?>

                                                        <?php
                                                        $exam = new Examen();
                                                        $exam->modulo = $Elem['id'];
                                                        $exam->capitulo = $capitulo;
                                                        $exam->pagina = $pagina;
                                                        $exam->alumno = $authj->rowff['id'];
                                                        $estado_exam = $exam->getEstado();


                                                        if (($Elem['examen_unico'] == 1 and $Elem['abierto'] == 1) &&  $cursos[0]['id'] != 12) {  ?>

                                                        <li class="question"> <a href="inicio_examen.php?curso=<?php echo $Elem['curso']; ?>&id=<?php echo $Elem['id']; ?>"> Realizar Examen <span> </span> </a> </li>
                                                    <?php } else {  ?>
                                                        <!-- <li class="question"> Examen No Disponible </li> -->
                                                    <?php }  ?>


                                                    <?php if ($estado_exam == 4) {
                                                        $exa_realz = 1; ?>
                                                        <li class="question"> <a href="inicio_examen.php?curso=<?php echo $Elem['curso']; ?>&id=<?php echo $Elem['id']; ?>"> Examen <span> </span> </a> </li>

                                                        <?php if ($exam->aprobado == 1 && $cursos[0]['hab_diploma'] == 1) { ?>
                                                            <li class="question"> <a href="curso_diploma_user.php?modulo=<?php echo $Elem['id'] ?>&user=<?php echo $authj->rowff['id']; ?>"> Descargar Diploma <span> </span> </a> </li>
                                                        <?php }  ?>
                                                    <?php  } else if ($estado_exam == 3) { ?>

                                                        <?php //if ($exam->aprobado == 1) { 
                                                        ?>
                                                        <li class="question"> <a href="curso_encuesta.php?id=<?php echo $Elem['id'] ?>"> Contestar Encuesta <span> </span> </a> </li>
                                                        <?php //}  
                                                        ?>
                                                    <?php  } ?>

                                                </ul>

                                            </div>
                                        </li>

                                    <?php } ?>


                                </ul>

                                <?php if ($exa_realz != 1) { ?>

                                    <?php if ($duracion == "-") { ?>

                                        <div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a>
                                            <p>El plazo para finalizar el curso ha terminado. </p>
                                        </div>
                                    <?php } else if ($duracion <= 15) { ?>
                                        <div class="uk-alert-warning" uk-alert> <a class="uk-alert-close" uk-close></a>
                                            <p>Dispone de <?php echo $duracion; ?> días para finalizar el curso. </p>
                                        </div>
                                    <?php } else { ?>
                                        <div class="uk-alert-success" uk-alert> <a class="uk-alert-close" uk-close></a>
                                            <p>Dispone de <?php echo $duracion; ?> días para finalizar el curso. </p>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                            </li>




                        </ul>

                        <?php if (!empty($cursos[0]['comentario'])) { ?>
                            <br><br>
                            <div class="bg-success" style="margin-top: ;50px; padding: 10px;"><?php echo $cursos[0]['comentario']; ?></div>
                        <?php } ?>

                        <?php if ($id == 5) {  ?>
                            <br><br>
                            <p style="text-align:center">
                                <a href="evento_zoom.php?evento=<?php echo $id; ?>" class="btn btn-default" target="_blank">ENTRAR A CONVERSATORIO</a>
                            <p class="rojo">Si tienes problemas para acceder a la reunión por favor comunicarse via email a info@pulpro.com o via whatsapp al +56 9 3352 9666 para asistencia técnica.</p>

                            </p>
                        <?php }  ?>


                    </div>

                    <div class="uk-width-1-3@m">
                        <div class="course-card-trailer" uk-sticky="top: 10 ;offset:105 ; media: @m ; bottom:true">




                            <div class="p-3">

                                <img src="../assets/images/course/<?php echo $id ?>.jpg" alt="">








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