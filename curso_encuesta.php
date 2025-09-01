<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "registro";
$scripts = "none";

$mod = New Modulo();
$modulos = $mod->getOne($id);

//echo "Curso". $modulos[0]['curso'];
$curso = $modulos[0]['curso'];



$curs = new Curso();
$cursos = $curs->getOne($modulos[0]['curso']);
$profes = $curs->getDocentes($curso);

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
                        <h3 class="mb-0"><?php echo $cursos[0]['titulo'];?> <span class="uk-text-bold"></span></h3>
                        <!--<p class="my-0">Ingresa al sistema para iniciar tu curso.</p>-->
                    </div>

                    <?php if ($estado_exam == 3) { ?>
                        <form action="enviar_encuesta.php" method="post" class="preguntas">
                            <input type="hidden" name="modulo" value="<?php echo $id; ?>">
                            <p class="text-primary text-center"><b>Valora del 1 al 5, siendo 5 la calificación más alta (MUY DE ACUERDO) y 1 la más baja (MUY EN DESACUERDO).</b></p>
                            <br>
                            <p class="alert alert-success"><b>Los contenidos del Programa son adecuados para lograr los objetivos y/o aprendizajes esperados.</b></p>
                            <input type="radio" class="css-checkbox" name="ep1" value="1" id="ep11" required><label for="ep11" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep1" value="2" id="ep12"><label class="css-label css-label2" for="ep12">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep1" value="3" id="ep13"><label class="css-label css-label2" for="ep13">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep1" value="4" id="ep14"><label class="css-label css-label2" for="ep14">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep1" value="5" id="ep15"><label class="css-label css-label2" for="ep15">5</label>
                            <br>
                            <p class="alert alert-success"><b>Los contenidos del programa le sirven para su desempeño.</b></p>
                            <input type="radio" class="css-checkbox" name="ep2" value="1" id="ep21" required><label for="ep21" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep2" value="2" id="ep22"><label class="css-label css-label2" for="ep22">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep2" value="3" id="ep23"><label class="css-label css-label2" for="ep23">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep2" value="4" id="ep24"><label class="css-label css-label2" for="ep24">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep2" value="5" id="ep25"><label class="css-label css-label2" for="ep25">5</label>
                            <br>
                            <p class="alert alert-success"><b>El tiempo asignado es suficiente para lograr los objetivos del programa y/o aprendizajes esperados.</b></p>
                            <input type="radio" class="css-checkbox" name="ep3" value="1" id="ep31" required><label for="ep31" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep3" value="2" id="ep32"><label class="css-label css-label2" for="ep32">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep3" value="3" id="ep33"><label class="css-label css-label2" for="ep33">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep3" value="4" id="ep34"><label class="css-label css-label2" for="ep34">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep3" value="5" id="ep35"><label class="css-label css-label2" for="ep35">5</label>
                            <br>
                            <p class="alert alert-success"><b>Los medios audiovisuales y herramientas de la plataforma son adecuados para el desarrollo de las sesiones. </b></p>
                            <input type="radio" class="css-checkbox" name="ep4" value="1" id="ep41" required><label for="ep41" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep4" value="2" id="ep42"><label class="css-label css-label2" for="ep42">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep4" value="3" id="ep43"><label class="css-label css-label2" for="ep43">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep4" value="4" id="ep44"><label class="css-label css-label2" for="ep44">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep4" value="5" id="ep45"><label class="css-label css-label2" for="ep45">5</label>
                            <br>
                            <p class="alert alert-success"><b>La plataforma es intuitiva y facil de usar. </b></p>
                            <input type="radio" class="css-checkbox" name="ep5" value="1" id="ep51" required><label for="ep51" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep5" value="2" id="ep52"><label class="css-label css-label2" for="ep52">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep5" value="3" id="ep53"><label class="css-label css-label2" for="ep53">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep5" value="4" id="ep54"><label class="css-label css-label2" for="ep54">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep5" value="5" id="ep55"><label class="css-label css-label2" for="ep55">5</label>
                            <br>

                            <?php foreach ($profes AS $profe) { ?>
                                <p class="alert alert-success"><b>Dominio de los contenidos de parte del docente o instructor <?php echo $profe['nombre']." (".$profe['modulos'].")"?> </b></p>
                            <input type="radio" class="css-checkbox" name="epr<?php echo $profe['id']?>" value="1" id="epr-<?php echo $profe['id']?>1" required><label for="epr-<?php echo $profe['id']?>1" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="epr<?php echo $profe['id']?>" value="2" id="epr-<?php echo $profe['id']?>2"><label class="css-label css-label2" for="epr-<?php echo $profe['id']?>2">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="epr<?php echo $profe['id']?>" value="3" id="epr-<?php echo $profe['id']?>3"><label class="css-label css-label2" for="epr-<?php echo $profe['id']?>3">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="epr<?php echo $profe['id']?>" value="4" id="epr-<?php echo $profe['id']?>4"><label class="css-label css-label2" for="epr-<?php echo $profe['id']?>4">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="epr<?php echo $profe['id']?>" value="5" id="epr-<?php echo $profe['id']?>5"><label class="css-label css-label2" for="epr-<?php echo $profe['id']?>5">5</label>
                            <br>

                                <?php } ?>
                            <p class="alert alert-success"><b>¿Recomendarías este curso a otros profesionales?</b></p>
                            <input type="radio" class="css-checkbox" name="ep6" value="1" id="ep61" required><label for="ep61" class="css-label css-label2">1</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep6" value="2" id="ep62"><label class="css-label css-label2" for="ep62">2</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep6" value="3" id="ep63"><label class="css-label css-label2" for="ep63">3</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep6" value="4" id="ep64"><label class="css-label css-label2" for="ep64">4</label>&nbsp;&nbsp;&nbsp;|
                            <input class="css-checkbox" type="radio" name="ep6" value="5" id="ep65"><label class="css-label css-label2" for="ep65">5</label>
                            <br>
                            <p class="alert alert-success"><b>¿Qué consideras que podríamos mejorar en este curso? </b></p>
                            <textarea class="form-control" rows="4" name="ep7" value="" placeholder="Escribe aquí tus sugerencias"></textarea>
                            <br>
                            <div class="toright">
                                <button type="submit" class="btn-acceder2" name="button">ENVIAR ENCUESTA</button>

                            </div>

                        </form>
                    <?php } else { ?>

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