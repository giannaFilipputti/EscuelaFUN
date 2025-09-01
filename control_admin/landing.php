<?php 

include('header.php'); 

$page = 'landing';


$prox = New Evento();



$eleve = $prox->getOne($id);


$prox1 = $prox->getAll('proximos','3');

$eventos = $eleve[0];
$id = $eventos['id'];


if (empty($eventos['imagen1'])) {

 // header("Location: webinars.php");

}
//echo date ( 'd/m/Y H:i:s');

$date1 = new DateTime($fechoy);
$date1->modify('+2 hours');
$fechaactual =  $date1->format('Y-m-d H:i:s');


$date12 = new DateTime($eventos['fecha']);
$date12->modify('-2 minutes');
$lafechoa12 =  $date12->format('Y-m-d H:i:s');

//echo $fechaactual."<br>".$lafechoa12 ;



$date13 = new DateTime($eventos['fecha']);
$date13->modify('+2 hours');
$lafechoa13 =  $date13->format('H:i');

$fecha = strtotime ($eventos['fecha']);

$asiste = Evento::verificarAsistencia($eventos['id'], $authj->rowff['id']);
// echo $fechaactual;
$scripts = "none";?>
    
    <div class="modulo">

         <div class="text-center">
            <br>
            <p><b style="font-size:16px;">MASTERCLASS DIGITAL </b></p>
          </div>        
         <div class="titulo-modulo color2 text-center">
            Módulo 1 | Clasificación, Semiología y Diagnóstico Diferencial         
         </div>

         <div class="row row-cols-1 row-cols-lg-2">
            <div class="col-12 col-lg-3 menubar">
              ...
            </div>
            <!-- Page Content -->





            <style>.list-group-item-action:hover{color:inherit} .tba-border{ border: 1px solid #ced4da;    border-radius: .25rem;} </style>

            <div class="col-12 col-lg-6 repro">


               <div class="tema">
                  <div class="container">
                     <div class="row dentro">
                        <div class="text-left">
                           
                           <h3>Sesión en directo - 9 de junio de 2021 De 18:30h a 20:30h</h3>
                           <p>Sesión presencial para actualizar conocimientos, trasladar dudas y compartir experiencias con los coordinadores del curso</p>
                           <p><b style="font-size:16px;">Dirigida a alumnos del módulo 1 de Epilepsia 360. </b></p>
                           <p><b style="font-size:16px;">PROGRAMA </b></p>
                           <ul>
                              <li>	Introducción y bienvenida</li>
                              <li>	Ponencia a cargo de Dr. JESÚS PORTA-ETESSAM.</li>
                              <li> 	Tiempo de debate: respuestas en directo de las preguntas recibidas</li>
                           </ul>
                        </div>   
                        <div class="text-left">
                           <p><b style="font-size:16px;">COORDINADORES </b></p>
                           
                           <div class="list-group">
                              <div class="list-group-item list-group-item-action  mt-0 pt-0" 
                              style="background-color: transparent  !important; border: none !important;">
                              <div class="d-flex justify-content-between">
                                 <h5 class="mb-1 color2" style="font-size:16px;">DR. JESÚS PORTA-ETESSAM</h5>
                              </div>
                              <p class="mb-1"><b>Coordinador, autor y profesor</b></p>
                              <small><b>Jefe de Sección de Neurología </b>en el Hospital Clínico <b>San Carlos de Madrid</b> en la unidad de cefaleas y de neurootooftalmología.</small>
                              </div>
                              <div class="list-group-item list-group-item-action  mt-0 pt-0" 
                              style="background-color: transparent  !important; border: none !important;">
                              <div class="d-flex justify-content-between">
                                 <h5 class="mb-1 color2" style="font-size:16px;">DR. ÁNGEL ALEDO SERRANO</h5>
                              </div>
                              <p class="mb-1"><b>Coordinador, autor y profesor</b></p>
                              <small><b>Neurólogo adjunto al Programa de Epilepsia en Hospital Ruber Internacional (Madrid) y Clinica Corachan (Barcelona).</b></small>
                              </div>
                           </div>
                        </div>   

<?php if ($asiste == 0) { ?>

                        <div class="bg_gris w-100" style="background-color: #EDEEF0;">
                           <div class="container">
                              <br>
                              <p  class="text-center">
                              <a href="inscribir.php?evento=<?php echo $eventos['id'];?>" class="btn-acceder ">INSCRIBIRME</a>
                              </p>
                              <br>
                           </div>
                        </div>

<?php } else { ?>

                        <div class="container">    
                           <div class="dentro">
                              <h2 class="color1 text-center"><b>PARTICIPA ACTIVAMENTE EN LA MASTERCLASS </b></h2>
                              <p class="gris big">Envía antes tus preguntas o comentarios a los coordinadores para que se presenten en el espacio de debate. </p>
                              <form id="pregunta0">
                                 <input type="hidden" name="evento" value="<?php  echo $eventos['id']; ?>">
                                 <textarea name="mensaje0" id="mensaje0" class="form-control" cols="30" rows="3" placeholder="ESCRIBA AQUÍ SUS PREGUNTAS"></textarea>
                                 <div class="text-right mt-3">
                                    <button type="button" id="enviar0" class="btn btn-acceder"> ENVIAR  </button>
                                 </div>
                              </form>
                              <div class="contenedor">
                                 <div id="respuesta0" class="alert alert-success oculto" role="alert">
                                    Tu mensaje ha sido enviado exitosamente
                                 </div>
                                 <div class="pregs" id="user_preguntas0">
                                    <?php /* include('user_preguntas0.php'); */ ?> 
                                 </div>
                              </div>
                           </div>
                        </div>
						<?php function getGCalendarUrl($event){ $titulo = urlencode($event['titulo']); $descripcion = urlencode($event['descripcion']); $localizacion = urlencode($event['localizacion']); $start=new DateTime($event['fecha_inicio'].' '.$event['hora_inicio'].' '.date_default_timezone_get()); $end=new DateTime($event['fecha_fin'].' '.$event['hora_fin'].' '.date_default_timezone_get()); $dates = urlencode($start->format("Ymd\THis")) . "/" . urlencode($end->format("Ymd\THis"));

            $name = urlencode($evento['titulo']);
            $url = urlencode($app_url);
            $time_zone = urlencode("Europe/Madrid");
            $gCalUrl = "http://www.google.com/calendar/event?action=TEMPLATE&text=$titulo&dates=$dates&details=$descripcion&location=$localizacion&trp=false&sprop=$url&sprop=name:$name&ctz=$time_zone";
            return ($gCalUrl);
            }
            // array asociativo con los parametros mecesarios.
            $evento = array(
              'titulo' => $eventos['titulo'],
              'descripcion' => $app_url,
              'localizacion' => '',
              'fecha_inicio' => date ( 'Y/m/d' , $fecha ), // Fecha de inicio de evento en formato AAAA-MM-DD
              'hora_inicio'=>date ( 'H:i' , $fecha ), // Hora Inicio del evento
              'fecha_fin'=>date ( 'Y/m/d' , $fecha ), // Fecha de fin de evento en formato AAAA-MM-DD
              'hora_fin'=>$lafechoa13, // Hora final del evento
              'nombre'=>'Psynapsis', // Nombre del sitio
              'url'=>$app_url // Url de la página
            );

            //print_r($evento );
            ?>

                        <div class="container">
                           <div class="dentro">
                              <h2 class="color1 text-center" style="text-transform:uppercase"> <b>Guardar Evento en su </b> <b class="rojo"> Calendario</b></h2>
                              <br>
                              <div class="dentro-cal">
                                 <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col text-center calendar" style="padding: 2% 10%;">
                                       <a href="<?php echo getGCalendarUrl($evento); ?>" target="_blank">
                                       <img src="img/gcal-es.png">
                                       </a>
                                    </div>
                                    <div class="col text-center calendar" style="padding: 2% 10%;">
                                       <a href="ics.php?id=<?php echo $eventos['id'];?>" target="_blank">
                                       <img src="img/ocal-es.png">
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="pl-2 tba-border">
                           <br>
                           <h3><b>¿Cómo acceder a la Masterclass?</b></h3>
                           <p>Días antes del evento recibirás por correo electrónico tu invitación personalizada con acceso directo a la Masterclass que se celebrará a través de la plataforma Zoom. </p>
                           <br>
                        </div>
<?php } ?>
                     </div>
                  </div>
                  <br>
               </div>
            </div>






            <div class="col-12 col-lg-3 text-center botons">

              ...

            </div>
            <!-- /#page-content-wrapper -->
         </div>
      </div>
<?php include('footer.php'); ?>
<script>

    $("#enviar0").click(function(e) {


                  //  console.log("se envia el form");

                  var url = "<?php echo $baseUrl?>guardar_preg.php";
                  //console.log($("#pregunta").serialize());
                  $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#pregunta0").serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                      //var result = $.parseJSON(data);
                      console.log(data);
                      //$("#lineOut_"+contador).html();
                      if (data == 'ok') {
                            $("#user_preguntas").load("user_preguntas.php?id=<?php echo $id;?>");
                            $("#mensaje").val("");
                            $("#respuesta0").removeClass('oculto');
                            setInterval(function(){ $("#respuesta").addClass('oculto'); }, 3000);

                      }

                    }
                  });

                  e.preventDefault(); // avoid to execute the actual submit of the form.
                });
                  </script>
    