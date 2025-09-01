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





$cursos = $curs->getAllByUser($authj->rowff['id']);







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



                <h4 class="mt-lg-7 mt-4">Cursos Disponibles</h4>

                <div class="uk-child-width-1-2@s uk-child-width-1-4@m" uk-grid>
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

                        <div>


                            <a href="<?php echo $link_mod ?>">
                                <div class="course-path-card <?php echo $clase_mod ?>">
                                    <img src="../assets/images/course/<?php echo $Elem['id'] ?>.jpg?v=9" alt="">
                                    <div class="course-path-card-contents">
                                        <h3> <?php echo $Elem['titulo'] ?> </h3>
                                        <!--<p> <?php echo $Elem['descripcion'] ?>
                                </p>-->


                                        <p class="<?php if ($cursoE == 1) { ?>bg-gradient-success shadow-success uk-light uk-alert intermitente<?php } else if ($cursoE == 2) { ?>bg-gradient-warning shadow-warning uk-light uk-alert intermitente<?php } else { ?>bg-gradient-primary shadow-primary uk-light uk-alert<?php } ?>"><strong><span class="blanco">Inicio: <?php echo date("d/m/Y", strtotime($Elem['fecha'])) ?><?php if (!empty($mensajeInscr)) { ?> - <?php } ?> <?php echo $mensajeInscr; ?> </span></strong></p>
                                        <div class="course-progressbar mt-3">
                                            <div class="course-progressbar-filler" title="Visualizado <?php echo $porc_curso; ?>% del curso" style="width:<?php echo $porc_curso; ?>%"></div>
                                        </div>

                                    </div>
                                    <div class="course-path-card-footer">
                                        <h5> <i class="icon-feather-film mr-1"></i> <?php echo $mensajeInscr; ?> </h5>
                                        <div>
                                            <h5>
                                                <i class="icon-feather-clock mr-1"></i>
                                                <?php echo $Elem['horas']; ?> Horas
                                            </h5>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php } ?>


                </div>

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


        <?php if ($ins > 0) { ?>
            <div id="modal-example1" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <h2 class="uk-modal-title">Cursos Inscritos</h2>
                    <p>Ud. tiene <?php echo $ins; ?> curso(s) con inscripción formalizada.<br>

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
    <?php if ($preinscr > 0) { ?>
        <script>
            $(function() {
                var modal = UIkit.modal("#modal-example");
                modal.show();
            });
        </script>
    <?php } ?>

    <?php if ($ins > 0) { ?>
        <script>
            $(function() {
                var modal = UIkit.modal("#modal-example1");
                modal.show();
            });
        </script>
    <?php } ?>

</body>

</html>