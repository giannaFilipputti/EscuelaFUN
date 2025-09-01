<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";



$mod = New Modulo();
$modulos = $mod->getOne($id);

//echo "Curso". $modulos[0]['curso'];
$curso = $modulos[0]['curso'];

$curs = new Curso();
$cursos = $curs->getOne($modulos[0]['curso']);

$inscrito = Curso::getInscritoCurso($curso, $authj->rowff['id']);

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



                    $exam = new Examen();
                    $exam->curso = $modulos[0]['curso'];
					$exam->modulo = $id;
					$exam->capitulo = $capitulo;
					$exam->pagina = $pagina;
					$exam->alumno = $authj->rowff['id'];
				
					/* $cap = new Capitulo();
					$cap->getOne($exam->capitulo);*/
				
					// revisamos si vencio el plazo
					if ($exam->checkPlazo() == 1) {
						$plazo_vencido = 1;
						$estado_exam = $exam->getEstado();
					} else {
						$plazo_vencido = 0;
						//verificamos en que estado está el examen
						$estado_exam = $exam->getEstado();
						//echo  $estado_exam." - ".$exam->id;
						if ($estado_exam == 5) {
							// mostrar boton de iniciar examen
						} else if ($estado_exam == 1) {
							$exam->getPreg();
						} else if ($estado_exam == 2) {
							// mostrar pantalla de reiniciar examen
						} else if ($estado_exam == 3) {
							// mostrar encuesta
						} else if ($estado_exam == 4) {
							// mostrar resultados
						}
					}

//echo $estado_exam;

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
        <div class="course-details-wrapper topic-1 uk-light">
            <div class="container p-sm-0">

                <div uk-grid>
                    <div class="uk-width-2-3@m">

                        <div class="course-details">
                            <h1> <?php echo $cursos[0]['titulo'] ?></h1>
                            <p> Examen del Módulo: <?php echo $modulos[0]['bienvenido'] ?> </p>

                            
                        </div>
                        <nav class="responsive-tab style-5">
                            <ul
                                uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                <li><a href="#">Contenidos</a></li>
                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>

        <div class="container">

            <div class="uk-grid-large mt-4" uk-grid>
                <div class="uk-width-3-3@m">
                   

                        <!-- course Curriculum-->
                  
                        
                        
                        <h3>Examen de <?php echo $cursos[0]['titulo']?></h3>
                        <?php
                                            //verificamos en que estado está el examen

                                            //echo  $estado_exam." - ".$exam->id;
                                            if ($estado_exam == 5) { 
                                            if ($plazo_vencido == 1) { 
                                                echo "Plazo Vencido";
                                            } else {

                                               // if ($inscrito[0]['porcentaje'] >= $cursos[0]['visual_min']) { ?>
                                            <?php if ($cursos[0]['id'] != 12) { ?>
                                          
                                                <a href="iniciar_examen.php?curso=<?php echo $curso; ?>&id=<?php echo $id;?>" class="btn btn-default transition-3d-hover" onclick="return confirm('Recuerda que una vez iniciado el examen cuentas con 24 horas para finalizarlo. Deseas iniciarlo?')">Iniciar Examen</a>
                                                    <?php //}  else { ?>
                                                     <!--   <p class="rojo">Debes visualizar al menos <?php echo $cursos[0]['visual_min'];?>% del contenido total del curso, actualmente has visualizado <?php echo $inscrito[0]['porcentaje'];?>% </p>
                                                        <a href="modulos.php?id=<?php echo $curso; ?>" class="btn btn-success transition-3d-hover" >Continuar el curso</a>-->
                                                        <?php //} ?>
                                                <p>Tienes hasta el <?php echo date("d-m-Y",  strtotime($inscrito[0]['fecfin'])); ?> para iniciar y finalizar el examen<br>
                                                    Una vez iniciado el examen, cuentas con 24 horas para finalizarlo.<br>
                                                    Tienes dos opciones para presentar el examen, si no apruebas en una primera oportunidad tendrás otra opcion para volver a iniciar el examen.<br>
                                                    El examen consta de <?php echo $modulos[0]['cantpreg']?> preguntas.<br>
                                                    El examen se aprueba con <?php echo $modulos[0]['preg_aprob']?> respuestas correctas.<br>

                                                </p>
                                                <?php } else { ?>
                                                    <p>La evaluación de este curso se realizará mediante la tarea evaluada.<br>

                                                <?php }  ?>

                                            <?php
                                            }
                                                // mostrar boton de iniciar examen
                                            } else if ($estado_exam == 1) {
                                                if ($plazo_vencido == 1) { 
                                                echo "Plazo Vencido";
                                            } else {

                                                $fechaPlazo = strtotime($exam->plazo_examen . "+ 1 days");
                                                $date2 = date("Y-m-d H:i:s", $fechaPlazo);
                                                $date1 = new DateTime(date('Y-m-d H:i:s'));
                                                $date2 = new DateTime($date2);
                                                $diff = $date2->diff($date1);
                                                //echo $diff;
                                                if ($exam->pagactual >0) {
                                                    $pagOp = $exam->pagactual-1;
                                                } else {
                                                    $pagOp = 0;
                                                }
                                                
                                                


                                                //get_format($diff);
                                            ?>
                                            <?php if ($cursos[0]['id'] != 12) { ?>
                                                <p class="rojo">No has finalizado el examen, puedes continuarlo, Dispones de <span id="hours"><?php echo $diff->h?></span> horas, <span id="minutes"><?php echo $diff->i?></span> minutos, <span id="seconds"><?php echo $diff->s?></span> segundos días para finalizar el examen.</p>
                                                <a href="examen1.php?curso=<?php echo $curso; ?>&modulo=<?php echo $exam->modulo; ?>&pag=<?php echo $pagOp; ?>" class="btn btn-default transition-3d-hover">Continuar Examen</a>

                                                <p style="margin-top:50px;">
                                                     Tienes hasta el <?php echo date("d-m-Y",  strtotime($inscrito[0]['fecfin'])); ?> para iniciar y finalizar el examen<br>
                                                    Tienes dos opciones para presentar el examen, si no apruebas en una primera oportunidad tendrás otra opcion para volver a iniciar el examen.<br>
                                                    El examen consta de <?php echo $modulos[0]['cantpreg']?> preguntas.<br>
                                                    El examen se aprueba con un minimo de <?php echo $modulos[0]['preg_aprob']?> de respuestas correctas.<br>

                                                </p>
                                                <?php } ?>

                                            <?php }
                                                // $exam->getPreg();
                                            } else if ($estado_exam == 2) { 
                                            if ($plazo_vencido == 1) { 
                                                echo "Plazo Vencido";
                                            } else {
                                            ?>

                                            <?php if ($cursos[0]['id'] != 12) { ?>
                                                <p class="rojo">No has aprobado el primer intento de examen, puedes iniciar un nuevo intento.</p>
                                                <a href="iniciar_examen.php?id=<?php echo $id;?>&curso=<?php echo $curso; ?>" class="btn btn-default transition-3d-hover" onclick="return confirm('Recuerda que una vez re-iniciado el examen cuentas con 24 horas para finalizarlo. Deseas iniciarlo?')">Reiniciar examen</a>
                                                <a href="modulos.php?id=<?php echo $curso; ?>" class="btn btn-success transition-3d-hover" >Seguir estudiando</a>
                                                <p>
                                                    Tienes hasta el <?php echo date("d-m-Y",  strtotime($inscrito[0]['fecfin'])); ?> para iniciar y finalizar el examen<br>
                                                    Una vez iniciado el segundo intento contarás con 24 horas para finalizarlo<br>
                                                    El examen consta de <?php echo $modulos[0]['cantpreg']?> preguntas.<br>
                                                    El examen se aprueba con <?php echo $modulos[0]['preg_aprob']?> respuestas correctas.<br>

                                                </p>
                                                <?php } ?>
                                                <?php
                                                }
                                                // mostrar pantalla de reiniciar examen
                                            } else if ($estado_exam == 3) { ?>
                                            <p>
                                                            Para ver los resultados debe contesta la encuesta del curso
                                                        </p>
                                                        <p>

                                                        <a href="curso_encuesta.php?id=<?php echo $id;?>" class="btn btn-default transition-3d-hover">Contestar encuesta</a>
                                                        </p>

                                                <?
                                            } else if ($estado_exam == 4) { ?>
                                            
                                          
                                                <?php  if ($exam->aprobado == 1) { ?>

                                                        <p class="verde">
                                                            Felicidades, has aprobado el examen del modulo.
                                                        </p>
                                                        <?php if ($cursos[0]['hab_diploma'] == 1) { ?>
                                                        <p>
                                                        <a href="curso_diploma_user.php?modulo=<?php echo $id;?>&user=<?php echo $authj->rowff['id'];?>" class="btn btn-default transition-3d-hover">Descargar Diploma</a>
                                                        </p>
                                                        <?php } else { ?>
                                                            <p>Pendiente descarga diploma. Será informado cuando esté habilitada la descarga del certificado</p>
                                                        <?php }  ?>
                                                            

                                                        <?php } else { ?>
                                                        <p class="rojo">
                                                            Lo sentimos, has agotado tus intentos y no has aprobado el examen de certificación.
                                                        </p>
                                                        <?php } ?>
                                                        <?php if ($cursos[0]['id'] != 12) { ?>
                                                        <p>
                                                        <a href="resultados.php?id=<?php echo $id;?>" class="btn btn-default transition-3d-hover">Ver Resultados</a>
                                                        <p>
                                                            <?php } ?>
                                          
                                        <?php
                                                // mostrar encuesta
                                            }
                                      
                                        ?>


                   
                </div>

               

            </div>


           


        </div>

    </div>

        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>

    </div>

    <?php include('cierre.php'); ?>

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

</body>

</html>