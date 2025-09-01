<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
//require_once 'lib/auth.php';
$page = "reporte_alumnos";
$scripts = "none";
/*
if ($authj->rowff['labor'] < 6)  {
	header("Location: index.php");	
	die();
}*/

$reporte = new Curso();
$reporte = $reporte->reporteAlumnos();

$regiones1 = new Curso();
$regiones = $regiones1->getRegiones();

$paises = $regiones1->getPaises();

if (!empty($curso)) {
    $Cur = new Curso();
    $CurOne = $Cur->getOne($curso);
}

?>

<?php include('header.php'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

<style>
    .cursoSeleccionado {
        background-color: #007bff;
    }
</style>

<body>

    <div id="wrapper" class="bg-white">

        <?php include('menu.php'); ?>

        <div class="container" style="max-width: 700px;">
            <form action="action_registro.php?action=registro" method="post">
                <br><br><br><br>

                <h1 class="h3 mb-2 text-gray-800">Registro en Escuela de Especialización Deportiva FENAUDE</h1>

                <p class="mb-4">Por favor ingrese sus datos para el proceso de inscripción.</p>
                <?php if (!empty($curso)) { ?>
                    <p class="mb-4"><strong>Ud se está inscribiendo en el Curso: <?php echo $CurOne[0]['titulo'] ?>.</strong></p>

                <?php } ?>

                <div class="row">

                    <?php if ($err == '7') { ?>
                        <div class="col-md-12 paddsup">
                            <div class="alert alert-danger bg-Danger" role="alert">
                                Compruebe que no es un robot.
                            </div>

                        </div>
                    <?php }  ?>

                    <input type="hidden" name="curso" value="<?php echo $curso; ?>">
                    <input type="hidden" name="clinica" value="<?php echo $clinica; ?>">

                    <div class="col-lg-12">

                        <div class="shadow mb-4">

                            <div class="card-header py-3">

                                <h6 class="m-0 font-weight-bold text-primary">Datos personales</h6>

                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <span class="icon text-gray-600">Nombre</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nombre_alumno" id="nombre_alumno" required="required">
                                    </div>

                                    <span class="icon text-gray-600">Apellido paterno</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="apepat_alumno" id="apepat_alumno" required="required">
                                    </div>

                                    <span class="icon text-gray-600">Apellido materno</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="apemat_alumno" id="apemat_alumno" required="required">
                                    </div>

                                    <div class="form-group">

                                        <span class="icon text-gray-600">Pais</span>

                                        <select class="form-control" name="pais_alumno" id="pais_alumno" required="required">

                                            <option hidden disabled selected value>Seleccionar</option>

                                            <?php

                                            foreach ($paises as $row):

                                                $id = $row['id'];
                                                $pais = $row['pais']; ?>

                                                <option value="<?php echo $id; ?>" <?php if ($row['predeterminado'] == 1) { ?> selected<?php } ?>><?php echo $pais; ?></option>
                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                    <div id="div_rut">

                                        <span class="icon text-gray-600">Rut</span>

                                        <div class="form-group">
                                            <input type="text" class="form-control" oninput="checkRut(this)" maxlength="10" name="rut_alumno" id="rut_alumno" required="required">
                                        </div>
                                    </div>

                                    <div id="div_dni" class="oculto">

                                        <span class="icon text-gray-600">DNI o Documento de identidad</span>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="dni_alumno" id="dni_alumno">
                                        </div>
                                    </div>

                                    <span class="icon text-gray-600">Email</span>

                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email_alumno" id="email_alumno" required="required">
                                    </div>

                                    <span class="icon text-gray-600">Password</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="password_alumno" id="password_alumno" required="required">
                                    </div>

                                    <span class="icon text-gray-600">Repita Password</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="password1_alumno" id="password1_alumno" required="required">
                                    </div>

                                    <span class="icon text-gray-600">Telefono</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="telf_alumno" id="telf_alumno" required="required">
                                    </div>


                                    <span class="icon text-gray-600">Género</span>

                                    <div class="form-group">
                                        <select class="form-control" name="genero_alumno" id="genero_alumno" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="F">Femenino</option>
                                            <option value="M">Masculino</option>
                                        </select>

                                    </div>

                                    <span class="icon text-gray-600">Fecha de Nacimiento</span>

                                    <div class="form-group">
                                        <input type="date" name="fecnac_alumno" id="fecnac_alumno" required="required" onclick="this.value = '2000-01-01';" />

                                    </div>

                                    <div id="div_tipo">
                                        <span class="icon text-gray-600">Tipo de Usuario</span>

                                        <div class="form-group">
                                            <select class="form-control" name="tipo_alumno" id="tipo_alumno">
                                                <option value="0">Usuario General</option>
                                                <option value="3">Deportista FENAUDE (Descuento 15%)</option>
                                            </select>

                                        </div>
                                    </div>

                                    <span class="icon text-gray-600">Universidad o Institución</span>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="club_alumno" id="club_alumno">
                                    </div>



                                    <div class="form-group" id="div_region">

                                        <span class="icon text-gray-600">Region</span>

                                        <select class="form-control" name="region_alumno" id="region_alumno">

                                            <option hidden disabled selected value>Seleccionar</option>

                                            <?php

                                            foreach ($regiones as $row):

                                                $id = $row['id'];
                                                $region = $row['region'];

                                                echo '<option value=' . $id . '>' . $region . '</option>';

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>





                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-12">



                        <br>

                        <button type="submit" class="btn btn-primary btn-user btn-block">Ingresar usuario</button>


                    </div>


                </div>

            </form>

        </div>

        <?php include('footer.php'); ?>

    </div>

    <?php include('cierre.php'); ?>

    <script type="text/javascript">
        $('#pais_alumno').change(function() {
            console.log("llega aqui");
            var pais = $(this).val();
            if (pais != '19') {
                $('#div_rut').addClass('oculto');
                $('#div_dni').removeClass('oculto');
                $('#div_region').addClass('oculto');
                $('#div_tipo').addClass('oculto');
                $('#rut_alumno').removeAttr('required');
                $('#region_alumno').removeAttr('required');
                $('#tipo_alumno').val('0');
            } else {
                $('#div_rut').removeClass('oculto');
                $('#div_dni').addClass('oculto');
                $('#div_region').removeClass('oculto');
                $('#div_tipo').removeClass('oculto');
                $('#rut_alumno').addAttr('required');
                $('#region_alumno').addAttr('required');
            }
        });



        function getCursos(id_usuario) {

            $.ajax({
                type: "POST",
                url: "getCursos_2022.php",
                dataType: 'json',
                cache: false,
                success: function(result) {

                    console.log("getCursos:", result);

                    result.forEach(function(valor, indice, array) {
                        var html =
                            "<li class='list-group-item' id='event-" + valor.id + "' onclick='addCurso(\"event-" + valor.id + "\"," + valor.id + ")'" +
                            "data-toggle='tooltip' data-placement='top' title='" + valor.titulo + "'>" +
                            "<input class='cursoSeleccionado' type='hidden' value='" + valor.id + "'>" +
                            "<h5>" + valor.titulo + "</h5>" +
                            "</li>" +
                            "<br>";
                        $('#cursos_disponibles').append(html);
                    });

                }
            }).fail(function(jqXHR, textStatus) {
                console.log(jqXHR);
                console.log(textStatus);
            });

        }
    </script>

    <script type="text/javascript">
        let cursos_usuarios = [];

        function addCurso(id, value) {

            if (!$('#' + id).hasClass("cursoSeleccionado")) {

                $('#' + id).addClass("cursoSeleccionado");

                cursos_usuarios.push(value);

                console.log(cursos_usuarios);

            } else {

                $('#' + id).removeClass("cursoSeleccionado");

                const index = cursos_usuarios.indexOf(value);

                if (index > -1) {

                    cursos_usuarios.splice(index, 1);

                }

                console.log(cursos_usuarios);

            }

        }

        function add_usuario_curso() {

            var jsonString = JSON.stringify(cursos_usuarios);

            if (jsonString == "[]") {

                alert("Favor seleccione al menos un curso para el usuario");

            } else {

                $.ajax({
                    type: "POST",
                    url: "pre_add_usuario_curso.php",
                    dataType: 'json',
                    data: {
                        data: jsonString,
                        nombre_alumno: $('#nombre_alumno').val(),
                        rut_alumno: $('#rut_alumno').val(),
                        dni_alumno: $('#dni_alumno').val(),
                        email_alumno: $('#email_alumno').val(),
                        apepat_alumno: $('#apepat_alumno').val(),
                        apemat_alumno: $('#apemat_alumno').val(),
                        telf_alumno: $('#telf_alumno').val(),
                        genero_alumno: $('#genero_alumno').val(),
                        fecnac_alumno: $('#fecnac_alumno').val(),
                        region_alumno: $('#region_alumno').val(),
                        tipo_alumno: $('#tipo_alumno').val(),
                        club_alumno: $('#club_alumno').val(),
                        pais_alumno: $('#pais_alumno').val()
                    },
                    cache: false,
                    success: function(result) {

                        console.log("add_usuario_curso:", result);

                        if (result.success) {

                            alert("Su pre-inscripción fue enviada. Muchas gracias");
                            location.reload();

                        } else {

                            alert(result.error);

                        }
                    }

                }).fail(function(jqXHR, textStatus) {
                    console.log(jqXHR);
                    console.log(textStatus);
                });

            }

        }
    </script>

    <script type="text/javascript">
        function checkRut(rut) {
            // Despejar Puntos
            var valor = rut.value.replace('.', '');
            // Despejar Guión
            valor = valor.replace('-', '');

            // Aislar Cuerpo y Dígito Verificador
            cuerpo = valor.slice(0, -1);
            dv = valor.slice(-1).toUpperCase();

            // Formatear RUN
            rut.value = cuerpo + '-' + dv

            // Si no cumple con el mínimo ej. (n.nnn.nnn)
            if (cuerpo.length < 7) {
                rut.setCustomValidity("RUT Incompleto");
                return false;
            }

            // Calcular Dígito Verificador
            suma = 0;
            multiplo = 2;

            // Para cada dígito del Cuerpo
            for (i = 1; i <= cuerpo.length; i++) {

                // Obtener su Producto con el Múltiplo Correspondiente
                index = multiplo * valor.charAt(cuerpo.length - i);

                // Sumar al Contador General
                suma = suma + index;

                // Consolidar Múltiplo dentro del rango [2,7]
                if (multiplo < 7) {
                    multiplo = multiplo + 1;
                } else {
                    multiplo = 2;
                }

            }

            // Calcular Dígito Verificador en base al Módulo 11
            dvEsperado = 11 - (suma % 11);

            // Casos Especiales (0 y K)
            dv = (dv == 'K') ? 10 : dv;
            dv = (dv == 0) ? 11 : dv;

            // Validar que el Cuerpo coincide con su Dígito Verificador
            if (dvEsperado != dv) {
                rut.setCustomValidity("RUT Inválido");
                return false;
            }

            // Si todo sale bien, eliminar errores (decretar que es válido)
            rut.setCustomValidity('');

        }
    </script>

</body>

</html>