<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "intro";
$scripts = "none";

/*
if($authj->rowff['cambiopass'] == 0){

    header("location: misdatos_pass.php");
        
}*/

$curs = new Curso();
$cursos = $curs->getOne($id);

$profes = $curs->getDocentes($id);

$mod = New Modulo();
$modulos = $mod->getAll($id);

$cap = New Capitulo();
if ($authj->logueado == 1) {
    $getPrecio = Alumno::getPrecio($authj->rowff['tipouser'], $authj->rowff['pais']);  
    $inscrito = Curso::getInscritoCurso($id, $authj->rowff['id']);  
}

print_r($inscrito);



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
                            <p> <?php echo $cursos[0]['bienvenido'] ?> </p>

                            <div class="course-details-info">

                                <ul>
                                    <li> Profesores <a href="#"> <?php echo $cursos[0]['profesores'] ?> </a> </li>
                                    <!--<li> Last updated 10/2019</li> -->
                                </ul>

                            </div>
                        </div>
                        <nav class="responsive-tab style-5">
                            <ul
                                uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                
                                <li><a href="#">Descripcion</a></li>
                                <li><a href="#">Contenidos</a></li>
                                <li><a href="#">Pre-requisitos</a></li>
                                <li><a href="#">Cuerpo docente</a></li>
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
                    <li>

<p><?php echo $cursos[0]['landing'] ?></p>

</li>

                        <!-- course Curriculum-->
                        <li>
                        <!--
                        <br><br>
                            <p style="text-align:center">
                            <p>Sesión 2 - Jueves 23 de Diciembre 2021 - 19:00 hrs</p>
                        <a href="<?php echo $authj->rowff['joinurl']; ?>" class="btn btn-default" target="_blank">ENTRAR A SESIÓN EN VIVO DE SEMINARIO</a>
                        <p class="rojo">Si tienes problemas para acceder a la reunión por favor comunicarse via email a info@pulpro.com o via whatsapp al +56 9 9151 6589 para asistencia técnica.</p>
													
                        </p>-->

                            <ul class="course-curriculum" uk-accordion="multiple: true">
                           
                            <?php foreach ($modulos as $Elem) { 

                                $capitulos = $cap->getAll($Elem['id']);
                                
                                ?>
                                <li>
                                    <a class="uk-accordion-title" href="#"> <?php echo $Elem['titulo'] ?> </a>
                                    <div class="uk-accordion-content">

                                        <!-- course-video-list -->
                                        <ul class="course-curriculum-list">
                                        
                                        <?php foreach ($capitulos as $Elem1) {  ?> 

                                        <li><?php echo  $Elem1['titulo'] ?> <span> <?php //echo  $Elem1['autor'] ?></span>
                                        
                                        <?php }  ?>
										
                                         <?php 


                                         $exam = new Examen();
                                         $exam->modulo = $Elem['id'];
                                         $exam->capitulo = $capitulo;
                                         $exam->pagina = $pagina;
                                         $exam->alumno = $authj->rowff['id'];
                                         $estado_exam = $exam->getEstado();

                                         if ($Elem['examen_unico'] == 1 and $Elem['abierto'] == 1) {  ?>
                                                            <li class="question">Examen de certificación </li>
                                                        <?php } else {  ?>
                                                            <!-- <li class="question"> Examen No Disponible </li> -->
                                                        <?php }  ?>


                                        <?php if ($estado_exam == 3 or $estado_exam == 4) { ?>                                         
                                          
                                            <?php  if ($exam->aprobado == 1) { ?>
                                                <li class="question"> <a href="curso_diploma.php?modulo=<?php echo $Elem['id'] ?>"> Descargar Diploma <span> </span> </a> </li>
                                                    <?php }  ?>                                     
                                    <?php  } ?>



                                   
                                           
                                        </ul>

                                    </div>
                                </li>
                                

                                <?php } ?>

                               

                            </ul>

                        </li>

                        <li>

                            <p><?php echo $cursos[0]['requisitos'] ?></p>

                            </li>
                        
                        

                        <li>

                        <?php foreach ($profes as $Elem) {  ?> 

                                <div class="user-details-card">
                                    <div class="user-details-card-avatar">
                                        <img src="../assets/images/avatars/1.png" alt="">
                                    </div>
                                    <div class="user-details-card-name">
                                        <?php echo $Elem['nombre']?> <span> <?php echo $Elem['cargo']?> <br><?php echo $Elem['empresa']?></span>
                                    </div>
                                </div>

                                <?php } ?>

                               
                        </li> 
                        
                       


                    </ul>

                    <?php if ($id == 5) {  ?>
                           <!-- <br><br>
                            <p style="text-align:center">
                        <a href="evento_zoom.php?evento=<?php echo $id; ?>" class="btn btn-default" target="_blank">ENTRAR A CONVERSATORIO</a>
                        <p class="rojo">Si tienes problemas para acceder a la reunión por favor comunicarse via email a info@pulpro.com o via whatsapp al +56 9 3352 9666 para asistencia técnica.</p>
													
                        </p>-->
                        <?php }  ?> 


                </div>

                <div class="uk-width-1-3@m">
                    <div class="course-card-trailer" uk-sticky="top: 10 ;offset:105 ; media: @m ; bottom:true">

                        <div class="course-thumbnail">
                             <!--<img src="../assets/images/course/f<?php echo $cursos[0]['id'] ?>.png?v=2" alt="">
                            <a class="play-button-trigger show" href="#trailer-modal" uk-toggle> </a>-->
                            <br<br>
                        </div> 

                        <!-- video demo model -->
                        <div id="trailer-modal" uk-modal>
                            <div class="uk-modal-dialog">
                                <button class="uk-modal-close-default mt-2  mr-1" type="button" uk-close></button>
                                <div class="uk-modal-header">
                                    <h4> Bienvenida </h4>
                                </div>
                                <div class="video-responsive">

                                <iframe src="https://player.vimeo.com/video/<?php echo $cursos[0]['bienvenida'] ?>" class="uk-padding-remove"
                                        uk-video="automute: false"  width="640" height="360" frameborder="0" allowfullscreen
                                        uk-responsive></iframe>


                                </div>

                                <div class="uk-modal-body">
                                    <h3>&nbsp; </h3>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>

                                </div>
                            </div>
                        </div>

                        <div class="p-3">

                        <img src="assets/images/course/<?php echo $id ?>.jpg?v=5" alt="">

                        <?php if ($authj->logueado == 1) { 

                    if (is_array($inscrito)) {

                            if($inscrito[0]['estado']==1) { 
                              
                                   
                                   echo "entro";?>
                            <p>Estás inscrito en el curso</p>


                            <?php } else if ($inscrito[0]['estadopago'] == 0) {  ?>
                                <div>
                                        <a href="curso_basket.php"
                                            class="uk-width-1-1 btn btn-default transition-3d-hover"> <i
                                                class="uil-play"></i> Formalizar inscripción </a>
                                    </div>

                            <?php } else if ($inscrito[0]['estadopago'] == 2 && $inscrito[0]['validprerequisitos']== 0) {  ?>

                                <div>
                                        <a href="curso_prerequisitos.php"
                                            class="uk-width-1-1 btn btn-default transition-3d-hover"> <i
                                                class="uil-play"></i> Acreditar pre-requisitos </a>
                                    </div>

                                    

                            <?php } ?>
                            <?php } ?>
                            <p class="my-3 text-center">
                                <small> PRECIO  </small><br>
                                    <?php if ($getPrecio == 'precio1') { ?>
                                        <span class="uk-h1"> <?php if ($cursos[0][$getPrecio] == 0) { echo "GRATUITO"; } else { echo number_format($cursos[0][$getPrecio], 0, ',', '.')." USD$"; }  ?>  </span>
                                    <br>
                                    <hr>
                                        <?php } else { ?>
                                            <span class="uk-h1"> <?php if ($cursos[0][$getPrecio] == 0) { echo "GRATUITO"; } else { echo number_format($cursos[0][$getPrecio], 0, ',', '.')." clp"; }  ?>  </span>
                                    <br>
                                    <hr>
                                    <?php if ($getPrecio != 'precio') { ?>
                                    <small>PÚBLICO GENERAL </small><br>
                                    <span class="uk-h4 text-muted" style="text-decoration: line-through;"> <?php if ($cursos[0]['precio'] == 0) { echo "GRATUITO"; } else { echo number_format($cursos[0]['precio'], 0, ',', '.')." clp"; }  ?> </span>
                                    <br>
                                    <hr>
                                    <?php }  ?>
                                            <?php }  ?>
                                    
                                   
                                </p>

                            <?php } else  { ?>
                                
                                <p class="my-3 text-center">
                                <small> PRECIO AFILIADO FECHIDA </small><br>

                                    <span class="uk-h1"> <?php if ($cursos[0]['precio2'] == 0) { echo "GRATUITO"; } else { echo number_format($cursos[0]['precio2'], 0, ',', '.')." clp"; }  ?>  </span>
                                    <br>
                                    <hr>
                                    <small>PRECIO ESTUDIANTES NACIONALES </small><br>
                                    <span class="uk-h4"> <?php if ($cursos[0]['precio3'] == 0) { echo "GRATUITO"; } else { echo number_format($cursos[0]['precio3'], 0, ',', '.')." clp"; }  ?> </span>
                                    <br>
                                    <hr>
                                    <small>PÚBLICO GENERAL </small><br>
                                    <span class="uk-h4"> <?php if ($cursos[0]['precio'] == 0) { echo "GRATUITO"; } else { echo number_format($cursos[0]['precio'], 0, ',', '.')." clp"; }  ?> </span>
                                    <br>
                                    <hr>
                                </p>
                                <p class="my-3">
                                    <small> PÚBLICO INTERNACIONAL </small><br>
                                    <span class="uk-h4">  USD$ <?php  echo $cursos[0]['precio1'] ?>  </span>
                                    <!--<s class="uk-h6 ml-1 text-muted"> $32.99 </s>-->
                                </p>   

                                <?php } ?>  
                                                

                                <div class="uk-child-width-1-1 uk-grid-small mb-4" uk-grid>
                                <?php 
                                //echo $authj->logueado."<br>";
                                if ($authj->logueado == 0) {  ?> 
                                    <div>
                                        <a href="login.php?curso=<?php  echo $cursos[0]['id'] ?>"
                                            class="uk-width-1-1 btn btn-default transition-3d-hover"> <i
                                                class="uil-play"></i> Inscribirse </a>
                                    </div>
                                    <?php } else if (!is_array($inscrito)) {?>

                                    <div>
                                        <a href="curso_inscribir.php?id=<?php  echo $cursos[0]['id'] ?>"
                                            class="uk-width-1-1 btn btn-default transition-3d-hover"> <i
                                                class="uil-play"></i> Inscribirse </a>
                                    </div>
                                    <?php } ?>
                                    <!--
                                    <div>
                                        <a href="course-resume.html"
                                            class="btn btn-danger uk-width-1-1 transition-3d-hover"> <i
                                                class="uil-heart"></i> Recordar </a>
                                    </div>-->
                                </div>


                                <div class="uk-child-width-1-2 uk-grid-small" uk-grid>
                                    <div>
                                        <span><i class="uil-youtube-alt"></i> <?php  echo $cursos[0]['horas'] ?> horas</span>
                                    </div>
                                    <div>
                                        <span> <i class="uil-award"></i> Certificado </span>
                                    </div>
                                    <!--
                                    <div>
                                        <span> <i class="uil-file-alt"></i> 12 Article </span>
                                    </div>-->
                                    <div>
                                        <span> <i class="uil-video"></i> Asíncrono </span>
                                    </div>
                                   
                                </div>
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