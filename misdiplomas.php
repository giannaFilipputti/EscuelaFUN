<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";


foreach ($_GET as $key => $value) {
    //if ($key != 'filtro' && $key != 'adfil') {
    $listvarall .=  $key . "=" . $value . "&";
    //}


    if ($key != 'pagi') {
        $listvar .=  $key . "=" . $value . "&";
    }

    if ($key != 'orden' && $key != 'tiporden' && $key != 'pagi') {
        $listvaro .=  $key . "=" . $value . "&";
    }
}

$curs = new Curso();

if (!empty($orden)) {
    $mod->orden = $orden;
}

if (!empty($tiporden)) {
    $mod->tiporden = $tiporden;
}


if (!empty($pagi)) {
    $mod->pag = $pagi;
}





$cursos = $curs->getAllByUser($authj->rowff['id'],0);

$mod = new Modulo();
$exam = new Examen();

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



                <h4 class="mt-lg-7 mt-4">Cursos Finalizados</h4>

                <ul class="uk-list uk-list-striped">
                    <?php
                    $preinscr = 0;
                    foreach ($cursos as $Elem) {
                        $mensajeInscr = "";
                        $cursoE = 0;

                        $inscrito = Curso::getInscritoCurso($Elem['id'], $authj->rowff['id']);
                        if ($inscrito == 0) {
                            $link_mod = "curso_det.php?id=" . $Elem['id'];
                            $clase_mod = "";
                        } else {
                            /*
                    $link_mod = "#";
                    $clase_mod = "disabled";
                    */
                            $link_mod = "curso_det.php?id=" . $Elem['id'];
                            $clase_mod = "";

                            if ($inscrito[0]['estado'] == 1) {
                                $mensajeInscr = "<span class='verde'>Inscrito</span>";
                                $cursoE = 1;
                            } else if ($inscrito[0]['estado'] == 0) {
                                $mensajeInscr = "<span class='naranja'>Pre-Inscrito</span>";
                                $cursoE = 2;
                                $preinscr++;
                            }
                            $porc_curso = $inscrito[0]['porcentaje'];
                        }

                        if ($porc_curso > 100) {
                            $porc_curso = 100;
                        }

                    ?>

                       
                          
                            <?php 
                            $modulos = $mod->getAll($Elem['id']);
                            foreach ($modulos as $Elem1) {
                                            if ($Elem1['examen_unico'] == 1) {
                                                $exam->modulo = $Elem1['id'];
                                                $mostrar_exam = "";
                                                $exam->alumno = $authj->rowff['id'];
                                                $estado_exam = $exam->getEstado();
                                                if ($estado_exam == 5) {
                                                    $mostrar_exam = "Examen No iniciado";
                                                    $nota = "";
                                                } else if ($estado_exam == 1) {
                                                    $mostrar_exam = "Examen Iniciado";
                                                    $nota = "";
                                                } else if ($estado_exam == 2) {
                                                    $mostrar_exam = "Examen Reprobado Intento 1";
                                                    $nota = $exam->nota;
                                                } else if ($estado_exam == 3 or $estado_exam == 4) {
                                                    if ($exam->aprobado == 1) {
                                                        $mostrar_exam = "Examen Aprobado";
                                                        $nota = $exam->nota;
                                                    } else {
                                                        $mostrar_exam = "Examen Reprobado Intento 2";
                                                        $nota = $exam->nota;
                                                    }
                                                }
                                                        if ($exam->aprobado == 1) {
                                                            // Examen::aprobarExamen($Elem['id'], $row['id']);

                                                            $ano = date("Y",strtotime($exam->fecfin)); 
                                                        ?>
                                                         <li>
                                                            <?php echo $Elem['titulo'] ." (".$ano.")"?>
                                                            <?php if ($Elem['hab_diploma'] == 1) { ?>
                                                            <a href="curso_diploma_user.php?modulo=<?php echo $Elem1['id'] ?>&user=<?php echo $authj->rowff['id']; ?>" class="btn btn-default">Descarga Diploma</a>
                                                                <?php } else {  ?>
                                                                     (Pendiente Diploma)
                                                                    <?php }   ?>
                                                        </li>
                                                            <?php } ?>


                                        <?php } ?>
                                        <?php } ?>
                        

                       

                    <?php } ?>


                    </ul>

            </div>


        </div>

        <?php if ($preinscr > 0) { ?>
            <div id="modal-example" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <h2 class="uk-modal-title">Cursos Pre-inscritos</h2>
                    <p>Ud. tiene <?php echo $preinscr; ?> curso(s) preinscrito(s).<br> Para finalizar su inscripción debe acceder a:<br>
                        <a href="curso_basket.php" class="btn btn-success"> <i class="uil-play"></i> Formalizar inscripción </a>
                    </p>
                    <p class="uk-text-right">
                        <button class="uk-button uk-button-default uk-modal-close" type="button">Cerrar</button>

                    </p>
                </div>
            </div>
        <?php } ?>


      


        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>



    </div>

    <?php include('cierre.php'); ?>
   


</body>

</html>