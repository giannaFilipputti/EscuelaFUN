<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";


$curs = new Curso();
$cursos = $curs->getOne($curso);

$modulo = $_GET['modulo'];

$comentarios = $curs->getComentarios($curso, $modulo);
$respuestas = $curs->getRespuestas($curso, $modulo);
$total_com_resp = $curs->getComResp($curso, $modulo);

$mod = new Modulo();
$modulos = $mod->getAll($curso);

$cap = new Capitulo();
//$capitulos = $cap->getAll($modulos[0]['id']);

$cap_act = $cap->getOne($capitulo);
//print_r($cap_act);

?>
<?php include('header.php'); ?>



<body class="course-watch-page">

    <!-- Wrapper -->
    <div id="wrapper">

        <div class="course-layouts">

            <div class="course-content bg-dark">

                <div class="course-header">

                    <a href="#" class="btn-back" uk-toggle="target: .course-layouts; cls: course-sidebar-collapse">
                        <i class="icon-feather-chevron-left"></i>
                    </a>

                    <h4 class="text-white"> <?php echo $cursos[0]['titulo'] ?>
                        <small><?php echo $cap_act[0]['titulo']; ?></small>
                    </h4>

                    <div>
                        <a href="#">
                            <i class="icon-feather-help-circle btns"></i> </a>
                        <div uk-drop="pos: bottom-right;mode : click">
                            <div class="uk-card-default p-4">
                                <h4> Contenidos </h4>
                                <p class="mt-2 mb-0">Debes ir avanzando con la visualización de los contenidos, puedes verlos tantas veces como lo requieras y una vez estés preparado para hacer el examen </p>

                            </div>
                        </div>

                        <a hred="#">
                            <i class="icon-feather-more-vertical btns"></i>
                        </a>
                        <div class="dropdown-option-nav " uk-dropdown="pos: bottom-right ;mode : click">
                            <ul>

                                <li><a href="#">
                                        <i class="icon-feather-bookmark"></i>
                                        Favoritos</a></li>
                                <li><a href="intro.php">
                                        <i class="icon-material-outline-arrow-back"></i>
                                        Volver a Cursos </a></li>

                                <li>
                                    <a href="#" id="night-mode" class="btn-night-mode">
                                        <i class="icon-line-awesome-lightbulb-o"></i> Oscuro
                                        <label class="btn-night-mode-switch">
                                            <div class="uk-switch-button"></div>
                                        </label>
                                    </a>
                                </li>
                            </ul>
                        </div>


                    </div>

                </div>

                <div class="course-content-inner">
                    <div class="video-responsive">
                        <iframe src="https://player.vimeo.com/video/<?php echo $cap_act[0]['video']; ?>" frameborder="0" uk-video="automute: false" allowfullscreen uk-responsive></iframe>
                    </div>



                </div>

            </div>


            <div id="modal_comentario_principal" uk-modal="" class="uk-modal" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4>Creación de comentario</h4>
                    </div>

                    <div class="uk-modal-body">

                        <div class="modal-body">

                            <div class="uk-margin">

                                <input type="hidden" id="id_curso">
                                <input type="hidden" id="id_modulo">
                                <input type="hidden" id="id_capitulo">

                                <div class="form-group">

                                    <label class="uk-form-label" for="form-stacked-text">Comentario:</label>
                                    <textarea id="txt_comentario_principal" class="uk-textarea"></textarea>

                                </div>

                            </div>

                        </div>

                        <p class="uk-text-center">
                            <button class="uk-button uk-button-danger uk-modal-close" type="button">Cancelar</button>
                            <button class="uk-button uk-button-primary" type="button" onclick="crear_comentario_principal()">Ingresar comentario</button>
                        </p>

                    </div>
                </div>
            </div>

            <div id="modal_resp_comentario" uk-modal="" class="uk-modal" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4>Respuesta a comentario</h4>
                    </div>

                    <div class="uk-modal-body">

                        <div class="modal-body">

                            <div class="uk-margin">

                                <input type="hidden" id="id_curso">
                                <input type="hidden" id="id_modulo">
                                <input type="hidden" id="id_capitulo">

                                <div class="form-group">

                                    <label class="uk-form-label" for="form-stacked-text">Respuesta:</label>
                                    <textarea id="txt_resp_comentario" class="uk-textarea"></textarea>

                                </div>

                            </div>

                        </div>

                        <p class="uk-text-center">
                            <button class="uk-button uk-button-danger uk-modal-close" type="button">Cancelar</button>
                            <button class="uk-button uk-button-primary" type="button" onclick="crear_comentario_respuesta()">Ingresar respuesta</button>
                        </p>

                    </div>
                </div>
            </div>

            <div id="modal_tarea_alumno" uk-modal="" class="uk-modal" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4>Detalle de la tarea</h4>
                    </div>

                    <div class="uk-modal-body">

                        <form id="actualizar_form">

                            <div class="modal-body">

                                <div class="uk-margin">

                                    <input type="hidden" id="id_curso">
                                    <input type="hidden" id="id_modulo">
                                    <input type="hidden" id="id_capitulo">

                                    <div class="form-group">

                                        <label class="uk-form-label" for="form-stacked-text">Nombre</label>
                                        <input type='text' id='nombre_tarea_alumno' class='uk-input' readonly />

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="form-stacked-text">Descripción:</label>
                                        <textarea id="descripcion_tarea_alumno" class="uk-textarea" readonly></textarea>

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="form-stacked-text">Fecha de entrega:</label>
                                        <input type='date' id='fecha_entrega_tarea_alumno' class='uk-input' readonly />

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="form-stacked-text">Comentario del profesor:</label>
                                        <textarea id="comentario_tarea_alumno" class="uk-textarea" readonly></textarea>

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="form-stacked-text">Comentario para el profesor:</label>
                                        <textarea id="comentario_tarea_alumnoo" class="uk-textarea"></textarea>

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="form-stacked-text">Carga de archivo/s:</label>

                                        <div class="js-upload uk-placeholder uk-text-center">
                                            <span uk-icon="icon: cloud-upload"></span>
                                            <span class="uk-text-middle">Arrastra el/los archivos para subirlos</span>
                                            <div uk-form-custom>
                                                <input type="file" multiple>
                                                <span class="uk-link">o haz click aquí para seleccionarlo/s<br></span>
                                            </div>
                                        </div>

                                        <span class="uk-text-left"><b>NOTA: </b>Ten en cuenta que una vez cargados los archivos, éstos se subiran automáticamente.</span>

                                    </div>

                                    <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

                                </div>

                            </div>

                            <p class="uk-text-center">
                                <button class="uk-button uk-button-danger uk-modal-close" type="button">Cancelar</button>
                            </p>

                        </form>

                    </div>
                </div>
            </div>

            <div id="modal_tarea_listado" uk-modal="" class="uk-modal-container" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4> Listado de tareas subidas</h4>
                    </div>

                    <div class="uk-modal-body">

                        <form id="actualizar_form">

                            <div class="modal-body">

                                <div class="table-responsive">

                                    <table id="tabla_tareas" class="table table-striped table-bordered" style="width:100%">

                                        <thead>
                                            <tr>
                                                <th class="text-center">Alumno</th>
                                                <th class="text-center">Tarea subida</th>
                                                <th class="text-center no-sort">Fecha de carga</th>
                                                <th class="text-center">Archivo/s subido/s</th>
                                            </tr>
                                        </thead>

                                        <tbody></tbody>

                                    </table>

                                </div>

                            </div>

                            <p class="uk-text-right">
                                <button class="uk-button uk-button-danger uk-modal-close" type="button">Cancelar</button>
                            </p>

                        </form>

                    </div>
                </div>
            </div>

            <div id="modal_tarea" uk-modal="" class="uk-modal" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4> Carga de tarea</h4>
                    </div>

                    <div class="uk-modal-body">

                        <form id="actualizar_form">

                            <div class="modal-body">

                                <div class="uk-margin">

                                    <div class="form-group">

                                        <label class="uk-form-label" for="nombre_tarea">Nombre</label>
                                        <input type='text' id='nombre_tarea' class='uk-input' />

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="descripcion_tarea">Descripción:</label>
                                        <textarea id="descripcion_tarea" class="uk-textarea"></textarea>

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="fecha_entrega_tarea">Fecha de entrega:</label>
                                        <input type='date' id='fecha_entrega_tarea' class='uk-input' />

                                    </div>

                                    <div class="form-group">

                                        <label class="uk-form-label" for="comentario_tarea">Comentario: (Opcional)</label>
                                        <textarea id="comentario_tarea" class="uk-textarea"></textarea>

                                    </div>

                                </div>

                            </div>

                            <p class="uk-text-right">
                                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                                <button class="uk-button uk-button-primary" type="button" onclick="crear_tarea()">Crear tarea</button>
                            </p>

                        </form>

                    </div>
                </div>
            </div>

            <div id="modal_tarea_alumno_listado" uk-modal="" class="uk-modal" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4> Archivos subidos</h4>
                    </div>

                    <div class="uk-modal-body">

                        <form id="actualizar_form">

                            <div class="modal-body">

                                <div class="table-responsive">

                                    <table id="tabla_tareas_archivos" class="table table-striped table-bordered" style="width:100%">

                                        <thead>
                                            <tr>
                                                <th class="text-center">Fecha de carga</th>
                                                <th class="text-center">Archivo/s subidos</th>
                                            </tr>
                                        </thead>

                                        <tbody></tbody>

                                    </table>

                                </div>

                            </div>

                            <p class="uk-text-center">
                                <button class="uk-button uk-button-danger uk-modal-close" type="button">Cerrar</button>
                            </p>

                        </form>

                    </div>
                </div>
            </div>

            <!-- course sidebar -->

            <div class="course-sidebar">

                <div class="course-sidebar-title">
                    <h3> <?php echo  $cursos[0]['titulo']; ?> </h3>
                </div>

                <nav class="responsive-tab style-5">
                    <ul uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                        <li><a href="#">Contenidos</a></li>
                        <li><a href="#">Foro (<?php echo $total_com_resp[0]['total_mensajes']; ?> mensajes)</a></li>
                    </ul>
                </nav>


                <ul id="course-intro-tab" class="uk-switcher mt-4">

                    <!-- course Curriculum-->
                    <li>



                        <div class="course-sidebar-container" data-simplebar>

                            <ul class="course-video-list-section" uk-accordion>


                                <?php foreach ($modulos as $Elem) {
                                    $capitulos = $cap->getAll($Elem['id']);
                                    $contador = 0;

                                ?>
                                    <li <?php if ($modulo == $Elem['id']) {  ?> class="uk-open" <?php  } ?>>
                                        <a class="uk-accordion-title" href="#"> <?php echo  $Elem['titulo']; ?> </a>
                                        <div class="uk-accordion-content">
                                            <!-- course-video-list -->
                                            <ul class="course-video-list<?php if ($modulo == $Elem['id']) {  ?> highlight-watched<?php  } ?>">
                                                <?php foreach ($capitulos as $Elem1) {
                                                    $visita = $cap->checkVisita($authj->rowff['id'], $Elem1['id']);
                                                ?>
                                                    <li class="<?php if ($visita > 0) {  ?>watched<?php  } ?><?php if ($capitulo == $Elem1['id']) {  ?> uk-active<?php  } ?>">
                                                        <a href="visor.php?curso=<?php echo $Elem['curso']; ?>&modulo=<?php echo $Elem['id']; ?>&capitulo=<?php echo $Elem1['id']; ?>">
                                                            <?php echo $Elem1['titulo'];
                                                            echo '&nbsp;';
                                                            echo '(<b>' . $Elem1['revista'] . '</b>)'; ?> <span> </span> </a>

                                                        <?php

                                                        $tarea = $cap->checkTarea($Elem['curso'], $Elem['id'], $Elem1['id']);

                                                        if ($authj->rowff['id'] == $Elem1['profesor'] && $tarea == 0) :

                                                        ?>

                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;

                                                            <b>→</b>&nbsp;

                                                            <button type="button" class="agregar_tarea btn btn-primary btn-sm" href="#modal_tarea" uk-toggle="" data-curso="<?php echo $Elem['curso']; ?>" data-modulo="<?php echo $Elem['id']; ?>" data-capitulo="<?php echo $Elem1['id']; ?>">
                                                                Crear tarea

                                                            </button>

                                                        <?php endif; ?>

                                                        <?php

                                                        $tarea = $cap->checkTarea($Elem['curso'], $Elem['id'], $Elem1['id']);

                                                        if ($authj->rowff['id'] == $Elem1['profesor'] && $tarea >= 1) :

                                                        ?>

                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;

                                                            <b>→</b>&nbsp;

                                                            <button type="button" class="ver_tarea_listado btn btn-success btn-sm" href="#modal_tarea_listado" uk-toggle="" data-curso="<?php echo $Elem['curso']; ?>" data-modulo="<?php echo $Elem['id']; ?>" data-capitulo="<?php echo $Elem1['id']; ?>">
                                                                Ver tareas subidas

                                                            </button>

                                                        <?php endif; ?>

                                                        <?php

                                                        $tarea = $cap->checkTarea($Elem['curso'], $Elem['id'], $Elem1['id']);

                                                        if ($authj->rowff['id'] != $Elem1['profesor'] && $tarea > 0) :

                                                        ?>

                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;

                                                            <b>→</b>&nbsp;

                                                            <button type="button" class="ver_tarea btn btn-primary btn-sm" href="#modal_tarea_alumno" uk-toggle="" data-curso="<?php echo $Elem['curso']; ?>" data-modulo="<?php echo $Elem['id']; ?>" data-capitulo="<?php echo $Elem1['id']; ?>">
                                                                Ver tarea

                                                            </button>

                                                        <?php endif; ?>

                                                        <?php

                                                        $tarea = $cap->checkTarea($Elem['curso'], $Elem['id'], $Elem1['id']);
                                                        $archivos = $cap->checkTarea_archivos($Elem['curso'], $Elem['id'], $Elem1['id']);

                                                        if ($authj->rowff['id'] != $Elem1['profesor'] && $tarea > 0 && $archivos > 0) :

                                                        ?>

                                                            &nbsp;

                                                            <button type="button" class="ver_tarea_alumno btn btn-info btn-sm" href="#modal_tarea_alumno_listado" uk-toggle="" data-curso="<?php echo $Elem['curso']; ?>" data-modulo="<?php echo $Elem['id']; ?>" data-capitulo="<?php echo $Elem1['id']; ?>">
                                                                Ver archivos subidos

                                                            </button>

                                                        <?php endif; ?>
                                                    </li>
                                                <?php $contador++;
                                                } ?>

                                                <?php if ($Elem['examen_unico'] == 1 and $Elem['abierto'] == 1) {  ?>
                                    <li> <a href="inicio_examen.php?curso=<?php echo $Elem['curso']; ?>&id=<?php echo $Elem['id']; ?>"> Realizar Examen <span> </span> </a> </li>

                                <?php } else if ($contador > 0) {  ?>

                                    
                                    <?php } else {  ?>
                                        <li><a href="#"?>Contenido aun no disponible </a></li>
                                    <?php } ?>
                                            </ul>
                                        </div>
                                    </li>

                                <?php } ?>
                                <!--<li> <a href="examen.php?curso=<?php echo $Elem['curso']; ?>&modulo=<?php echo $Elem['id']; ?>"> Realizar Examen <span> </span> </a>
                            <ul class="course-video-list highlight-watched">
                                  
                                     
                                        <li><a href="#"?>Contenido disponible a<br>partir del viernes 6 de Noviembre </li>
                               
                                </ul>
                        </li> -->


                            </ul>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							

                        </div>

                    </li>
                    <li>
                        <div class="course-sidebar-title d-flex justify-content-center">
                            <button type="button" class="comentario_principal btn btn-danger" href="#modal_comentario_principal" uk-toggle="" data-curso="<?php echo $_GET['curso']; ?>" data-modulo="<?php echo $_GET['modulo']; ?>">
                                Ingresar comentario
                            </button>
                        </div>
                        <div class="course-sidebar-container" data-simplebar>

                            <ul class="course-video-list-section" uk-accordion>

                                <ul class="uk-comment-list">

                                    <li id="div_comentarios"></li>

                                </ul>

                            </ul>

                        </div>
                    </li>
                </ul>




            </div>

        </div>



    </div>


    <script>
        (function(window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);


        (function(window, document, undefined) {

            'use strict';

            // Feature test
            if (!('localStorage' in window)) return;

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function(event) {
                event.preventDefault();
                document.documentElement.classList.toggle('night-mode');
                if (document.documentElement.classList.contains('night-mode')) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);

        })(window, document);
    </script>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <?php

    //$cap->registrarVisita($authj->rowff['id'], $capitulo);

    ?>

    <!-- javaScripts
            ================================================== -->
    <script src="../assets/js/framework.js"></script>
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/mmenu.min.js"></script>
    <script src="../assets/js/simplebar.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            load_comentarios();

        });

        function load_comentarios() {

            var curso = <?php echo $_GET['curso']; ?>;
            var modulo = <?php echo $_GET['modulo']; ?>;

            $.ajax({

                type: "GET",
                url: "get_comentarios.php",
                dataType: "html",
                data: {
                    curso: curso,
                    modulo: modulo
                },

                success: function(result) {

                    $('#div_comentarios').html(result);

                },

            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        }

        let id_curso;
        let id_modulo;
        let id_capitulo;

        let id_curso_com_princ;
        let id_modulo_com_princ;

        let id_curso_com_resp;
        let id_modulo_com_resp;

        $(document).on("click", ".agregar_tarea", function() {

            id_curso = $(this).data('curso');
            id_modulo = $(this).data('modulo');
            id_capitulo = $(this).data('capitulo');

        });

        $(document).on("click", ".ver_tarea", function() {

            id_cursoo = $(this).data('curso');
            id_moduloo = $(this).data('modulo');
            id_capituloo = $(this).data('capitulo');

            id_usuario = <?php echo $authj->rowff['id'] ?>;
            id_curso = <?php echo $_GET['curso']; ?>;
            id_modulo = <?php echo $_GET['modulo']; ?>;

            var bar = document.getElementById('js-progressbar');

            UIkit.upload('.js-upload', {

                url: 'subirtarea.php',
                multiple: true,
                params: {
                    "id_usuario": id_usuario,
                    "id_curso": id_curso,
                    "id_modulo": id_modulo,
                    "id_capitulo": id_capituloo
                },

                beforeSend: function() {
                    console.log('beforeSend', arguments);
                },
                beforeAll: function() {
                    console.log('beforeAll', arguments);
                },
                load: function() {
                    console.log('load', arguments);
                },
                error: function() {
                    console.log('error', arguments);
                },
                complete: function() {
                    console.log('complete', arguments);
                },

                loadStart: function(e) {
                    console.log('loadStart', arguments);

                    bar.removeAttribute('hidden');
                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                progress: function(e) {
                    console.log('progress', arguments);

                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                loadEnd: function(e) {
                    console.log('loadEnd', arguments);

                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                completeAll: function(arguments) { //added arguments, without it - arguments could be undefined in the line below
                    console.log('completeAll', arguments);

                    setTimeout(function() {
                        bar.setAttribute('hidden', 'hidden');
                    }, 1000);

                    alert('Tarea subida exitosamente');
                    location.reload();
                }

            });

        });

        $(document).on("click", ".ver_tarea_listado", function() {

            id_usuario = <?php echo $authj->rowff['id'] ?>;

            id_curso = $(this).data('curso');
            id_modulo = $(this).data('modulo');
            id_capitulo = $(this).data('capitulo');

            var tabla = $('#tabla_tareas').DataTable({

                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],

                "ajax": {

                    method: 'POST',

                    data: {
                        id_usuario: id_usuario,
                        id_curso: id_curso,
                        id_modulo: id_modulo,
                        id_capitulo: id_capitulo
                    },

                    url: "get_alumnos_tareas.php",

                    error: function(data) {

                        console.log(data);

                    }

                },

                "columns": [{
                        "data": "alumno"
                    },
                    {
                        "data": "subida",
                        "render": function(data, type, row, meta) {

                            if (data == null) {

                                return '<button type="button" class="btn btn-danger">No</button>';

                            } else {

                                return '<button type="button" class="btn btn-success">Si</button>';

                            }

                        }
                    },
                    {
                        "data": "fecha_subida",
                        "render": function(data, type, row, meta) {

                            if (data == null) {
                                return '-';
                            } else {
                                return data;
                            }

                        }
                    },
                    {
                        "data": "ruta",
                        "render": function(row, type, val, meta) {

                            if (val.ruta == null) {

                                return '-';

                            } else {

                                var rutas = val.ruta;

                                var strArr = rutas.split(',');

                                var botones = '';

                                for (var i = 0; i < strArr.length; i++) {

                                    if (i === strArr.length - 1) {

                                        botones += '<a class="uk-link-heading" href="' + strArr[i] + '" download="Tarea de ' + val.alumno + '">Descargar archivo ' + (i + 1) + '</a>';

                                    } else {

                                        botones += '<a class="uk-link-heading" href="' + strArr[i] + '" download="Tarea de ' + val.alumno + '">Descargar archivo ' + (i + 1) + '</a><br>';

                                    }

                                }

                                return botones;

                            }

                        }
                    }
                ],

                columnDefs: [{
                        className: 'text-center',
                        width: '40%',
                        targets: 0
                    },
                    {
                        className: 'text-center',
                        width: '20%',
                        targets: 1
                    },
                    {
                        className: 'text-center',
                        width: '20%',
                        targets: 2
                    },
                    {
                        className: 'text-center',
                        width: '20%',
                        targets: 3
                    }
                ],

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                    buttons: {
                        pageLength: {
                            _: "Mostrar %d registros",
                            '-1': "Todos"
                        }
                    }
                },

                // initComplete: function () {

                //     this.api().columns(1).every( function () {

                //         var title = this.header().innerHTML;

                //         var column = this;

                //         var select = $('<select><option value=""></option></select>')

                //             .appendTo( $(column.header()) )

                //             .on( 'change', function () {

                //                 var val = $.fn.dataTable.util.escapeRegex(

                //                     $(this).val()

                //                 );

                //                 column

                //                     .search( val ? '^'+val+'$' : '', true, false )

                //                     .draw();

                //             } );

                //             column.data().unique().sort().each( function ( d, j ) {

                //                 select.append( '<option value="'+d+'">'+d+'</option>' )

                //             } );

                //     } );

                // },

                dom: 'Bfrtip',

                destroy: true,

                buttons: [
                    'pageLength',
                    {
                        extend: 'excel',
                        text: 'Descargar en Excel',
                        titleAttr: 'excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Descargar en PDF',
                        titleAttr: 'pdf'
                    }

                ]

            });

            tabla.buttons().container().appendTo('#tabla_tareas .col-md-6:eq(0)');

        });

        $(document).on("click", ".ver_tarea_alumno", function() {

            id_usuario = <?php echo $authj->rowff['id'] ?>;

            id_curso = $(this).data('curso');
            id_modulo = $(this).data('modulo');
            id_capitulo = $(this).data('capitulo');

            var tabla = $('#tabla_tareas_archivos').DataTable({

                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],

                "ajax": {

                    method: 'POST',

                    data: {
                        id_usuario: id_usuario,
                        id_curso: id_curso,
                        id_modulo: id_modulo,
                        id_capitulo: id_capitulo
                    },

                    url: "get_alumnos_tareas_archivos.php",

                    error: function(data) {

                        console.log(data);

                    }

                },

                "columns": [{
                        "data": "fecha_subida",
                        "render": function(data, type, row, meta) {

                            if (data == null) {
                                return '-';
                            } else {
                                return data;
                            }

                        }
                    },
                    {
                        "data": "ruta",
                        "render": function(row, type, val, meta) {

                            if (val.ruta == null) {

                                return '-';

                            } else {

                                var rutas = val.ruta;

                                var strArr = rutas.split(',');

                                var botones = '';

                                for (var i = 0; i < strArr.length; i++) {

                                    if (i === strArr.length - 1) {

                                        botones += '<a class="uk-link-heading" href="' + strArr[i] + '" download="Tarea de ' + val.alumno + '">Descargar archivo ' + (i + 1) + '</a>';

                                    } else {

                                        botones += '<a class="uk-link-heading" href="' + strArr[i] + '" download="Tarea de ' + val.alumno + '">Descargar archivo ' + (i + 1) + '</a><br>';

                                    }

                                }

                                return botones;

                            }

                        }
                    }
                ],

                columnDefs: [{
                        className: 'text-center',
                        targets: 0
                    },
                    {
                        className: 'text-center',
                        targets: 1
                    }
                ],

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                    buttons: {
                        pageLength: {
                            _: "Mostrar %d registros",
                            '-1': "Todos"
                        }
                    }
                },

                dom: 'Bfrtip',

                destroy: true,

                buttons: [
                    'pageLength',
                    {
                        extend: 'excel',
                        text: 'Descargar en Excel',
                        titleAttr: 'excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Descargar en PDF',
                        titleAttr: 'pdf'
                    }
                ]

            });

            tabla.buttons().container().appendTo('#tabla_tareas .col-md-6:eq(0)');

        });

        $(document).on("click", ".ver_tarea", function() {

            id_curso = $(this).data('curso');
            id_modulo = $(this).data('modulo');
            id_capitulo = $(this).data('capitulo');

            $.ajax({

                type: "POST",
                url: "ver_tarea.php",
                data: {
                    id_curso: id_curso,
                    id_modulo: id_modulo,
                    id_capitulo: id_capitulo
                },

                success: function(result) {

                    var data = JSON.parse(result);

                    var nombre_tarea = data[0]['nombre'];
                    var descripcion_tarea = data[0].descripcion;
                    var fecha_entrega_tarea = data[0].fecha_entrega;
                    var comentario_tarea = data[0].comentario;

                    $('#nombre_tarea_alumno').val(nombre_tarea);
                    $('#descripcion_tarea_alumno').val(descripcion_tarea);
                    $('#fecha_entrega_tarea_alumno').val(fecha_entrega_tarea);
                    $('#comentario_tarea_alumno').val(comentario_tarea);

                },

            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        });

        function crear_tarea() {

            var nombre_tarea = document.getElementById('nombre_tarea').value;

            if (nombre_tarea == "") {

                alert("El nombre de la tarea es un campo obligatorio.");
                return false;

            }

            var descripcion_tarea = document.getElementById('descripcion_tarea').value;

            if (descripcion_tarea == "") {

                alert("La descripción de la tarea es un campo obligatorio.");
                return false;

            }

            var fecha_entrega_tarea = document.getElementById('fecha_entrega_tarea').value;

            if (fecha_entrega_tarea == "") {

                alert("La fecha de entrega de la tarea es un campo obligatorio.");
                return false;

            }

            var comentario_tarea = document.getElementById('comentario_tarea').value;

            $.ajax({

                type: "POST",
                url: "crear_tarea.php",
                data: {
                    id_curso: id_curso,
                    id_modulo: id_modulo,
                    id_capitulo: id_capitulo,
                    nombre_tarea: nombre_tarea,
                    descripcion_tarea: descripcion_tarea,
                    fecha_entrega_tarea: fecha_entrega_tarea,
                    comentario_tarea: comentario_tarea
                },

                success: function() {

                    alert("Tarea creada exitosamente.");
                    location.reload();

                },

            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        }

        $(document).on("click", ".comentario_principal", function() {

            id_curso_com_princ = $(this).data('curso');
            id_modulo_com_princ = $(this).data('modulo');

        });

        $(document).on("click", ".responder_comentario", function() {

            id_curso_com_resp = $(this).data('curso');
            id_modulo_com_resp = $(this).data('modulo');
            id_comentario = $(this).data('id');

        });

        function crear_comentario_respuesta() {

            var comentario = document.getElementById('txt_resp_comentario').value;

            if (comentario == "") {

                alert("La respuesta no puede estar vacia.");
                return false;

            }

            $.ajax({

                type: "POST",
                url: "crear_comentario_respuesta.php",
                data: {
                    id_curso: id_curso_com_resp,
                    id_modulo: id_modulo_com_resp,
                    comentario: comentario,
                    id_comentario: id_comentario
                },

                success: function() {

                    $('#modal_resp_comentario').removeClass('uk-open').hide();
                    alert("Respuesta creada exitosamente");

                    document.getElementById("div_comentarios").innerHTML = "";
                    load_comentarios();
                    return false;

                },

            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        }

        function crear_comentario_principal() {

            var comentario = document.getElementById('txt_comentario_principal').value;

            if (comentario == "") {

                alert("El comentario no puede estar vacio.");
                return false;

            }

            $.ajax({

                type: "POST",
                url: "crear_comentario_principal.php",
                data: {
                    id_curso: id_curso_com_princ,
                    id_modulo: id_modulo_com_princ,
                    comentario: comentario
                },

                success: function(result) {

                    $('#modal_comentario_principal').removeClass('uk-open').hide();
                    alert("Comentario creado exitosamente");

                    document.getElementById("div_comentarios").innerHTML = "";
                    load_comentarios();
                    return false;

                },

            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        }
    </script>

    <script>
        let id_usuario = <?php echo $authj->rowff['id']; ?>;

        let capitulo = <?php echo $capitulo; ?>;

        setTimeout(function() {

            //console.log("40 segundos | ID_USUARIO: "+id_usuario+" | CAPITULO: "+capitulo);

            $.ajax({

                type: "POST",
                url: "visto.php",
                data: {
                    id_usuario: id_usuario,
                    capitulo: capitulo
                },
                success: function() {
                    //console.log('Visto');
                },

            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        }, 40000);
    </script>

</body>

</html>