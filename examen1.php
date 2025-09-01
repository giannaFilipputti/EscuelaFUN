<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";

$curs = new Curso();
$cursos = $curs->getOne($curso);

$mod = new Modulo();
$modulos = $mod->getOne($modulo);

/*
$prox = new Certificacion();
$prox->getOne($id);

//$loscontenidos = $prox->getAllCertificadoC($id);
$modulo = $id;

$asiste = Certificacion::verificarAsistencia($modulo, $authj->rowff['id']);*/
$pagina = $pag;


//if (!empty($asiste)) {
$exam = new Examen();
$exam->curso = $modulos[0]['curso'];
$exam->modulo = $modulo;
$exam->capitulo = $capitulo;
$exam->pagina = $pagina;
$exam->pag = $pagina;
$exam->origen = "examen";
$exam->alumno = $authj->rowff['id'];

/* $cap = new Capitulo();
    $cap->getOne($exam->capitulo);*/

// revisamos si vencio el plazo
if ($exam->checkPlazo() == 1) {
    $plazo_vencido = 1;
    header("Location: certificacion1.php?id=" . $modulo);
    die();
} else {
    $plazo_vencido = 0;
    //verificamos en que estado está el examen
    $estado_exam = $exam->getEstado();
    //echo  "entro aqui " . $estado_exam . " - " . $exam->id;
    if ($estado_exam == 5) {
        $exam->iniciarExamen();
        /*header("Location: examen.php?id=".$modulo);
	        die();*/
    } else if ($estado_exam == 1) {
        $exam->getPreg();
        /*header("Location: examen.php?id=".$modulo);
	        die();*/
    } else if ($estado_exam == 2) {
        // mostrar pantalla de reiniciar examen
        // $exam->reiniciarExam();
        header("Location: inicio_examen.php?id=" . $modulo);
        die();
    } else if ($estado_exam == 3) {
        header("Location: inicio_examen.php?id=" . $modulo);
        die();
    } else if ($estado_exam == 4) {
        header("Location: inicio_examen.php?id=" . $modulo);
        die();
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
                                <h1> <?php echo $cursos[0]['titulo'] ?></h1>
                                <p> Examen del Módulo: <?php echo $modulos[0]['bienvenido'] ?> </p>

                                <div class="course-details-info">

                                    <ul>
                                        <li> Profesores <a href="#"> <?php echo $cursos[0]['profesores'] ?> </a> </li>
                                        <!--<li> Last updated 10/2019</li> -->
                                    </ul>

                                </div>
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
                                <?php if ($plazo_vencido == 1) { ?>
                                    <div class="video">
                                        <div class="clearfix"></div>
                                        <br>

                                        <p class="granate"><b>El plazo para terminar el examen desde el momento en que inició el módulo ha finalizado.</b></p>

                                    </div>
                                <?php } else { ?>
                                    <div class="video">
                                        <div class="clearfix"></div>
                                        <br>
                                        <?php if ($estado_exam != 3 && $estado_exam != 4) {

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




                                        ?>
                                            <p class="granate"><b style="font-size:20px;">Dispones de <span id="days"></span> días, <span id="hours"></span> horas, <span id="minutes"></span> minutos, <span id="seconds"></span> segundos días para finalizar el examen</b></p>
                                            <section>
                                                <p>

                                                </p>
                                            </section>

                                        <?php } ?>
                                    </div>
                                    <?php
                                    if ($estado_exam == 1) { ?>

                                        <form method="post" id="form_exam" action="examen_guardar.php">
                                            <input type="hidden" name="modulo" value="<?php echo $modulo; ?>">
                                            <input type="hidden" name="curso" value="<?php echo $modulos[0]['curso']; ?>">
                                            <input type="hidden" name="capitulo" value="<?php echo $capitulo; ?>">
                                            <input type="hidden" name="pag" value="<?php echo $pagina; ?>">
                                            <input type="hidden" name="id" value="<?php echo $exam->id; ?>">
                                            <input type="hidden" id="actionBoton" name="actionBoton" value="sig">
                                            <div class="preguntas">

                                                <!-- Pregunta -->
                                                <?php
                                                $lasresp = array();
                                                //print_r($exam->preg);
                                                $base = ($pag) * 10;
                                                $numero = $base + 1;
                                                foreach ($exam->preg as $Elem) {
                                                    $lasresp[] = "p" . $Elem['id']; ?>
                                                    <div class="uk-grid">
                                                        <div class="pregunta0" style="padding-top: 50px; width: 100%">

                                                            <p class="color1 pregunta" style="width: 100%"><span><?php echo $numero ?> </span><?php echo strip_tags($Elem['pregunta']) ?></p>
                                                            <div id="error_p<?php echo $Elem['id']; ?>" class="error_p<?php echo $Elem['id']; ?> rojo"></div>
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
                                                                        <input class="form-check-input" type="radio" id="p<?php echo $Elem['id'] . "_" . $key; ?>" name="p<?php echo $Elem['id']; ?>" value="<?php echo $key ?>" <?php if ($key == $Elem['alumn_resp']) { ?> checked<?php } ?> required><label class="form-check-label" for="p<?php echo $Elem['id'] . "_" . $key; ?>"><span><?php echo $letra; ?></span> <?php echo $value . $continua; ?></label>
                                                                    </div>


                                                                <?php $numresp++;
                                                                } ?>
                                                            </div>

                                                        </div> <!-- Fin Pregunta -->
                                                    </div>
                                                <?php $numero++;
                                                } ?>


                                            </div>

                                            <div class="botonera row">

                                            <div class="toleft col-sm-6">
                                                <?php if (($pag) > 0) { ?>

                                                    <span id="atras_exam" rel="atras" class="btn btn-default transition-3d-hover" style="cursor: pointer">Atras</span>


                                                <?php } ?>
                                            </div>


                                            <div class="toright col-sm-6">
                                            <div id="errores" class="errores rojo"></div>
                                                <?php
                                                // echo "total pages".$exam->total_pages;
                                                // echo "<br>pagina".$pag;
                                                if ($exam->total_pages > ($pag + 1)) { ?>

                                                    <span alt="enviar-examen" id="enviar_exam" rel="continuar" class="btn btn-default transition-3d-hover" style="cursor: pointer">Siguiente</span>
                                                <?php
                                                } else { ?>
                                                    <span alt="enviar-examen" id="enviar_examF" rel="finalizar" class="btn btn-default transition-3d-hover" style="cursor: pointer">FINALIZAR</span>

                                                <?php } ?>
                                            </div>
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

    <?php //include('cierre.php'); ?>

    <script src="assets/js/framework.js"></script>
    <script src="<?php echo BASE_PATH; ?>js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="assets/js/mmenu.min.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="assets/js/main.js"></script>
    <?php //echo date("F j, Y, g:i a");
$date1I = new DateTime($fechoy);
//$date1I->modify('-5 hours');
$fechaactualI =  $date1I->format("F j, Y, g:i a");
//echo $fechaactualI;

$dateT = new DateTime($exam->plazo_examen);
//$dateT->modify('-3 hours');
$fechaTope =  $dateT->format("F j, Y, g:i a");

?>
    <script>
  var fechaInicio = new Date().getTime();
  var fechaFin = new Date('<?php echo $fechaactualI; ?>').getTime();
 console.log(fechaInicio);
  console.log(fechaFin);
  var diff = fechaFin - fechaInicio;
  var diferencia = Math.round(diff / (1000 * 60 * 60));
  //console.log(diferencia);
  var countDownDate1 = new Date("<?php echo $fechaTope;?>").getTime();
  var countDownDate = countDownDate1 - (diferencia * 1000 * 60 * 60);
  //console.log(countDownDate);
  // Update the count down every 1 second
  var x = setInterval(function() {
    // Get today's date and time
    var now = new Date().getTime();
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Display the result in the element with id="demo"
    
    $("#days").text(days);
                    $("#hours").text(hours);
                    $("#minutes").text(minutes);
                    $("#seconds").text(seconds);

    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(x);
     
      $("#days").text("0");
                    $("#hours").text("0");
                    $("#minutes").text("0");
                    $("#seconds").text("0");
    }
  }, 1000);
</script>
    <script type="text/javascript">
            


        



            <?php //$fecini =  date("m", $fechaPlazo) . "/" . date("d", $fechaPlazo) . "/" . date("Y", $fechaPlazo) . " " . date("h", $fechaPlazo) . ":" . date("i", $fechaPlazo) . ":" . date("s", $fechaPlazo);  
            ?>
            <?php //$fecfin =  date("m") . "/" . date("d") . "/" . date("Y") . " " . date("h") . ":" . date("i") . ":" . date("s");  
            ?>

          



           


            $(document).ready(function(){
                   // $('.form-check-input').required = true;
            


                   $('#form_exam').submit(function(e){

                    var chequeado = 0;
                    $("#errores").text("");
                    <?php foreach ($lasresp as $respi) { ?>
                   
                                if ($('input[name=<?php echo $respi ?>]:checked').length <= 0) {      
                                    $('input[name=<?php echo $respi ?>]').css('outline', '1px solid red');
                                    $("#error_<?php echo $respi ?>").text("Debe contestar esta pregunta");
                                    chequeado = 1;
                                }
                                else {       
                                    $("#error_<?php echo $respi ?>").text(""); 
                                    $('input[name=<?php echo $respi ?>]').css('outline', 'none');

                                }
                        <?php } ?>

                        if (chequeado == 1) {
                            //alert("error");
                            $("#errores").text("Debe contestar todas las preguntas");
                            return false;
                            
                        }


                        
                    });
            
            /*
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
                   
                });

            });*/



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

        });
        </script>

</body>

</html>