<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";

$modulo = $id;



$mod = new Modulo();
$modulos = $mod->getOne($id);

//print_r($modulos);


$curs = new Curso();
$cursos = $curs->getOne($modulos[0]['curso']);

//print_r($cursos);

/*
$prox = new Certificacion();
$prox->getOne($id);

//$loscontenidos = $prox->getAllCertificadoC($id);
$modulo = $id;

$asiste = Certificacion::verificarAsistencia($modulo, $authj->rowff['id']);*/
$pagina = $pag;


//if (!empty($asiste)) {
    $exam = new Examen();
    $exam->modulo = $modulo;
    $exam->capitulo = $capitulo;
    $exam->pagina = $pagina;
    $exam->alumno = $authj->rowff['id'];

    $cantPreg = Modulo::getCantPreg($modulo);

    /* $cap = new Capitulo();
    $cap->getOne($exam->capitulo);*/

    // revisamos si vencio el plazo
    if ($exam->checkPlazo() == 1) {
        $plazo_vencido = 1;
		$estado_exam = $exam->getEstado();
		 //echo  $estado_exam." - ".$exam->id;
		 if ($estado_exam == 5) {
            //$exam->iniciarExamen();

            header("Location: curso.php?id=" . $modulo);
            die();
        } else if ($estado_exam == 1) {
            header("Location: curso.php?id=" . $modulo);
            die();
        } else if ($estado_exam == 2) {
            // mostrar pantalla de reiniciar examen
            // $exam->reiniciarExam();
            //header("Location: curso.php?id=" . $modulo);
            //die();
        } else if ($estado_exam == 3) {
            $exam->getPreg();
        } else if ($estado_exam == 4) {
            $exam->getPreg();
        }
        //header("Location: curso.php?id=" . $modulo);
        //die();
    } else {
        $plazo_vencido = 0;
        //verificamos en que estado está el examen
        $estado_exam = $exam->getEstado();
        //echo  $estado_exam." - ".$exam->id;
        if ($estado_exam == 5) {
            //$exam->iniciarExamen();

            header("Location: curso.php?id=" . $modulo);
            die();
        } else if ($estado_exam == 1) {
            header("Location: curso.php?id=" . $modulo);
            die();
        } else if ($estado_exam == 2) {
            // mostrar pantalla de reiniciar examen
            // $exam->reiniciarExam();
            header("Location: curso.php?id=" . $modulo);
            die();
        } else if ($estado_exam == 3) {
            $exam->getPreg();
        } else if ($estado_exam == 4) {
            $exam->getPreg();
        }
    }
/*
} else {
}*/




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
                                <h1> Examen: <?php echo $cursos[0]['titulo'] ?></h1>
                                

                                
                            </div>
                            <nav class="responsive-tab style-5">
                                <ul uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                    <li><a href="#">Examen</a></li>
                                </ul>
                            </nav>

                        </div>
                    </div>

                </div>
            </div>

            <div class="container">

                <div class="uk-grid-large mt-4" uk-grid>
                    <div class="uk-width-3-3@m">
                        <ul id="course-intro-tab" class="uk-switcher mt-4">

                            <!-- course Curriculum-->
                            <div id="contenido_examen">
                               
                                    <div class="video">
                                        <div class="clearfix"></div>
                                        <br>
                                        <?php if ($estado_exam == 3 or $estado_exam == 4) {

                                            //echo $exam->plazo_examen . "<br>";
                                            // echo date('Y-m-d H:i:s') . "<br>";

                                            $fechaPlazo = strtotime($exam->plazo_examen);
                                            $date2 = date("Y-m-d H:i:s", $fechaPlazo);

                                            $date1 = new DateTime(date('Y-m-d H:i:s'));
                                            $date2 = new DateTime($date2);
                                            $diff = $date1->diff($date2);

                                            function get_format($df)
                                            {

                                                $str = '';
                                                $str .= ($df->invert == 1) ? ' - ' : '';
                                                if ($df->y > 0) {
                                                    // years
                                                    $str .= ($df->y > 1) ? $df->y . ' Years ' : $df->y . ' Year ';
                                                }
                                                if ($df->m > 0) {
                                                    // month
                                                    $str .= ($df->m > 1) ? $df->m . ' Months ' : $df->m . ' Month ';
                                                }
                                                if ($df->d > 0) {
                                                    // days
                                                    $str .= ($df->d > 1) ? $df->d . ' Days ' : $df->d . ' Day ';
                                                }
                                                if ($df->h > 0) {
                                                    // hours
                                                    $str .= ($df->h > 1) ? $df->h . ' Hours ' : $df->h . ' Hour ';
                                                }
                                                if ($df->i > 0) {
                                                    // minutes
                                                    $str .= ($df->i > 1) ? $df->i . ' Minutes ' : $df->i . ' Minute ';
                                                }
                                                if ($df->s > 0) {
                                                    // seconds
                                                    $str .= ($df->s > 1) ? $df->s . ' Seconds ' : $df->s . ' Second ';
                                                }

                                                // echo $str;
                                            }

                                            get_format($diff);

                                            if ($exam->aprobado == 1) { ?>
                                                <p class="verde" style="font-size:18px;"><strong>Felicidades, has aprobado el examen, podrás descargar la certificación. Tu puntaje fue de <?php echo $exam->nota; ?>/<?php echo $cantPreg; ?></strong></p>
                                            <?php } else { ?>
                                                <p class="rojo" style="font-size:18px;"><strong>Lo sentimos, has agotado tus intentos y no has aprobado el examen de certificación.  Tu puntaje fue de <?php echo $exam->nota; ?>/<?php echo $cantPreg; ?></strong></p>
                                            <?php } ?>



                                             <section>
                                                <p>

                                                </p>
                                            </section>

                                        <?php } ?>
                                    </div>
                                    <?php
                                    if ($estado_exam == 3 or $estado_exam == 4) { ?>

                                        <form method="post" action="#">
                                            
                                            <div class="preguntas">

                                                <!-- Pregunta -->
                                                <?php
                                                $lasresp = array();
                                                //print_r($exam->preg);
                                                $base = ($pag) * 10;
                                                $numero = $base + 1;
                                                foreach ($exam->preg as $Elem) {
                                                    $lasresp[] = "resp_" . $Elem['id']; ?>
                                                    <div class="uk-grid">
                                                        <div class="pregunta0" style="padding-top: 50px; width: 100%">

                                                            <p class="color1 pregunta" style="width: 100%"><span><?php echo $numero ?> </span><?php echo strip_tags($Elem['pregunta']) ?>
                                                            <?php if ($Elem['alum_correc'] == 1) { 
                                                                           echo "<i class=\"fa fa-check-circle\" style=\"font-size:30px; color: #32a909\" aria-hidden=\"true\"></i>";
                                                                       } else { 
                                                                        echo "<i class=\"fa fa-times-circle\" style=\"font-size:30px; color: #ff0000\" aria-hidden=\"true\"></i>";
                                                                    } ?>
                                                                    </p>

                                                            <div class="respuestas">
                                                                <?php

                                                                $numresp = 1;
                                                                foreach ($Elem['respuestas'] as $key => $value) {
                                                                    $respuestas = explode(")", $value);
                                                                    if ($numresp == 1) {
                                                                        $letra = "A";
                                                                    } else if ($numresp == 2) {
                                                                        $letra = "B";
                                                                    } else if ($numresp == 3) {
                                                                        $letra = "C";
                                                                    } else if ($numresp == 4) {
                                                                        $letra = "D";
                                                                    } else if ($numresp == 5) {
                                                                        $letra = "E";
                                                                    } else if ($numresp == 6) {
                                                                        $letra = "F";
                                                                    } else if ($numresp == 7) {
                                                                        $letra = "G";
                                                                    } else if ($numresp == 8) {
                                                                        $letra = "H";
                                                                    } else if ($numresp == 9) {
                                                                        $letra = "I";
                                                                    }

                                                                    if (!empty($respuestas[2])) {
                                                                        $continua = ")" . $respuestas[2];
                                                                    } else {
                                                                        $continua = "";
                                                                    }

                                                                ?>

                                                                    <div class="respuesta">
                                                                        <input class="form-check-input" type="radio" id="p<?php echo $Elem['id'] . "_" . $key; ?>" name="p<?php echo $Elem['id']; ?>" value="<?php echo $key ?>" <?php if ($Elem['resp_corr'][$key] == 1) { ?> checked<?php } ?> disabled><label class="form-check-label<?php if ($key == $Elem['alumn_resp'] and $Elem['alum_correc'] == 0) {  ?> rojo <?php } ?>" for="p<?php echo $Elem['id'] . "_" . $key; ?>"><span><?php echo $letra; ?></span> <?php echo $value . $continua; ?><?php if ($key == $Elem['alumn_resp']) {  ?> <strong>(Tu respuesta)</strong> <?php } ?><?php if ($Elem['resp_corr'][$key] == 1) { ?> <strong>(Respuesta Correcta)</strong><?php } ?></label>
                                                                    </div>


                                                                <?php $numresp++;
                                                                } ?>
                                                            </div>

                                                        </div> <!-- Fin Pregunta -->
                                                    </div>
                                                <?php $numero++;
                                                } ?>


                                            </div>

                                            
                                        </form>


                                        

                                        <?php if ($result == 1) { ?>
                                            <div class="modal fade" id="myModal_l" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-body">

                                                            <p class="verde">Respuestas guardadas</p>
                                                            <a href="modulo.php?id=<?php echo $modulo; ?>" class="btn btn-success">Seguir con el curso</a>

                                                        </div>
                                                        <div class="modal-footer">

                                                            <a class="btn btn-primary" data-dismiss="modal" href="#">Continuar en esta sección</a>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>


                                    <?php } else if ($estado_exam == 2) {  ?>
                                        <div class="video">
                                            <div class="clearfix"></div>
                                            <br>
                                            <p class="granate"><b>Has <span class="roja">SUSPENDIDO</span> el primer intento de realizar el examen.<br>Puedes reiniciar el examen e iniciar un segundo intento. <br><span id="reiniciar" class="btn btn-success" style="cursor: pointer;">REINICIAR</span></b></p>

                                            <script type="text/javascript">
                                                function reiniciarExa(modulo, capitulo, pagina, id) {
                                                    var num = 0;
                                                    var numDiv = document.getElementsByTagName("a");

                                                    $('#ajaxcontent').load('examen_reiniciar.php?modulo=' + modulo + '&capitulo=' + capitulo + '&pagina=' + pagina + '&id=' + id);

                                                }
                                                $("#reiniciar").click(function() {
                                                    reiniciarExa(<?php echo $modulo; ?>, <?php echo $capitulo; ?>, <?php echo $pagina; ?>, <?php echo $exam->id; ?>);
                                                });
                                            </script>
                                        </div>
                                    <?php } else if ($estado_exam == 3) {  ?>
                                        <div class="video">
                                            <div class="clearfix"></div>
                                            <br>
                                            <p class="granate"><b>Ya has realizado el examen del módulo.<br><br><a href="diplomas.php" class="btn btn-success" style="cursor: pointer;">VER RESULTADOS</a></b></p>

                                        </div>
                                    <?php } else if ($estado_exam == 4) {  ?>
                                        <div class="video">
                                            <div class="clearfix"></div>
                                            <br>
                                            <p class="granate"><b>Ya has realizado el examen del módulo.<br><br><a href="diplomas.php" class="btn btn-success" style="cursor: pointer;">VER RESULTADOS</a></b></p>


                                        </div>
                                    <?php } ?>

                            </div>

                        </ul>
                    </div>



                </div>





            </div>

        </div>

        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>

    </div>

    <?php include('cierre.php'); ?>
    <script type="text/javascript">
            


        



            <?php //$fecini =  date("m", $fechaPlazo) . "/" . date("d", $fechaPlazo) . "/" . date("Y", $fechaPlazo) . " " . date("h", $fechaPlazo) . ":" . date("i", $fechaPlazo) . ":" . date("s", $fechaPlazo);  
            ?>
            <?php //$fecfin =  date("m") . "/" . date("d") . "/" . date("Y") . " " . date("h") . ":" . date("i") . ":" . date("s");  
            ?>

            <?php
            $fechaPlazo = strtotime($exam->plazo_examen . "- 3 hours");
            // $date2 = date("Y-m-d H:i:s", $fechaPlazo);

            $fecini =  date("Y-m-d H:i:s", $fechaPlazo);  ?>
            <?php $fecfin =  date("Y-m-d H:i:s"); ?>


            var timer;

            //var compareDate = ;
            compareDate = new Date('<?php echo $fecini; ?>');

            compareDate1 = new Date('<?php echo $fecfin; ?>');

            console.log(compareDate + 1);
            compareDate.setDate(compareDate.getDate() + 1); //just for this demo today + 7 days

            timer = setInterval(function() {
                timeBetweenDates(compareDate);
            }, 1000);

            function timeBetweenDates(toDate) {
                var dateEntered = toDate;
                var now = new Date();
                var difference = dateEntered.getTime() - now.getTime();

                if (difference <= 0) {

                    // Timer done
                    clearInterval(timer);

                } else {

                    var seconds = Math.floor(difference / 1000);
                    var minutes = Math.floor(seconds / 60);
                    var hours = Math.floor(minutes / 60);
                    var days = Math.floor(hours / 24);

                    hours %= 24;
                    minutes %= 60;
                    seconds %= 60;

                    $("#days").text(days);
                    $("#hours").text(hours);
                    $("#minutes").text(minutes);
                    $("#seconds").text(seconds);
                }
            }



            $(function() {
                $('#form_exam').validate({
                    rules: {
                        <?php foreach ($lasresp as $respi) { ?>
                            <?php echo $respi ?>: {
                                required: true
                            },
                        <?php } ?>

                    },
                    messages: {
                        <?php foreach ($lasresp as $respi) { ?>
                            <?php echo $respi ?>: {
                                required: "Debe contestar todas las preguntas"
                            },
                        <?php } ?>

                    },
                    errorClass: 'error roja',
                    errorPlacement: function(error, element) {
                        if (element.is(":radio")) {
                            error.prependTo(element.parents('.div_respuestas'));
                        } else { // This is the default behavior
                            error.insertAfter(element);
                        }
                    },
                    invalidHandler: function(event, validator) {
                        // 'this' refers to the form
                        console.log("llega aqui");
                        $("#enviar_exam").removeClass("bloqueado");
                        $("#enviar_exam").addClass("activo");
                    },
                    /*submitHandler: function(form) {
                        $.ajax({
                            url: "examen_guardar.php",
                            type: "POST",
                            data: $(form).serialize(),
                            cache: false,
                            processData: false,
                            success: function(data) {
                                //alert("enviado");
                                $('#recuperar').click();
                                $('#loading').hide();
                                $("#contenido_examen").html(data);
                                $("#enviar_exam").removeClass("bloqueado");
                                $("#enviar_exam").addClass("activo");

                            }
                        });
                        return false;
                    },*/
                });

            });



            $("#atras_exam").click(function() {
                var className = $(this).attr('class');
                var rela = $(this).attr('rel');
             
                $("#actionBoton").val("atras");                

               
                    if (className == 'bloqueado') {

                    } else {
                        $(this).removeClass("activo");
                        $(this).addClass("bloqueado");    
                        
                        $('#form_exam').submit();
                    }


               


                

            });


            $("#enviar_examF").click(function() {
                var className = $(this).attr('class');
                var rela = $(this).attr('rel');
             
                $("#actionBoton").val("fin");                

                if (confirm('Una vez enviado el examen no podras modificar las respuestas?') == true) {
                    if (className == 'bloqueado') {

                    } else {
                        $(this).removeClass("activo");
                        $(this).addClass("bloqueado");    
                        
                        $('#form_exam').submit();
                    }


                }


                

            });

            $("#enviar_exam").click(function() {
                var className = $(this).attr('class');
                var rela = $(this).attr('rel');
                $("#actionBoton").val("sig");
                

                
                    if (className == 'bloqueado') {

                    } else {
                        $(this).removeClass("activo");
                        $(this).addClass("bloqueado");
                        
                            
                        
                        $('#form_exam').submit();
                    }


                


                

            });
        </script>

</body>

</html>