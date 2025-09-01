<?php
$page = "personal";
$scripts = "none";
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

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
echo "origen " . $_SERVER['HTTP_REFERER'];

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


        <div class="page-content">

            <div class="page-content-inner">
                <h1 class="h3 mb-2 text-gray-800">Actualización de datos</h1>

                <p class="mb-4">Por favor complete y confirme todos los campos requeridos.</p>

                <div uk-grid>
                    <div class="uk-width-medium@m">

                        <div class="profile-cards" uk-sticky="offset: 90; bottom: true; media: @m;top:2">

                            <div id="user_foto" class="user-profile-photo">
                                <?php include('personal_foto.php'); ?>
                            </div>

                            <h4> <?php echo $authj->rowff['nombre'] . " " . $authj->rowff['ape1'] . " " . $authj->rowff['ape2']  ?> </h4>
                            <p class="uk-text-small"> </p>


                            <p>Actualiza tu foto de perfil</p>
                            <div class="formulario">
                                <div id="dropzone_foto" class="dropzone"></div>
                            </div>








                        </div>


                    </div>
                    <div class="uk-width-expand@m">

                        <form method="POST" action="personal1.php">
                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="shadow mb-4">

                                        <div class="card-header py-3">

                                            <h6 class="m-0 font-weight-bold text-primary">Datos personales</h6>

                                        </div>

                                        <div class="card-body">


                                            <input type="hidden" name="origen" value="">

                                            <input type="hidden" name="id" value="<?php echo $authj->rowff['id'] ?>">

                                            <div class="table-responsive">

                                                <span class="icon text-gray-600">Nombre</span>

                                                <div class="form-group">
                                                    <?php echo $authj->rowff['nombre'] ?>
                                                </div>

                                                <span class="icon text-gray-600">Apellido paterno</span>

                                                <div class="form-group">
                                                    <?php echo $authj->rowff['ape1'] ?>
                                                </div>

                                                <span class="icon text-gray-600">Apellido materno</span>

                                                <div class="form-group">
                                                    <?php echo $authj->rowff['ape2'] ?>
                                                </div>



                                                <div id="div_rut">

                                                    <span class="icon text-gray-600">RUT (Documento de identidad)</span>

                                                    <div class="form-group">
                                                        <?php echo $authj->rowff['dni']; ?>
                                                    </div>
                                                </div>



                                                <span class="icon text-gray-600">Email</span>

                                                <div class="form-group">
                                                    <?php echo $authj->rowff['email']; ?>
                                                </div>

                                                <div class="form-group">

                                                    <span class="icon text-gray-600">Pais</span>

                                                    <select class="form-control" name="pais_alumno" id="pais_alumno" required="required">

                                                        <option hidden disabled selected value>Seleccionar</option>

                                                        <?php

                                                        foreach ($paises as $row) :

                                                            $id = $row['id'];
                                                            $pais = $row['pais']; ?>

                                                            <option value="<?php echo $id; ?>" <?php if ($row['id'] == $authj->rowff['pais']) { ?> selected<?php } ?>><?php echo $pais; ?></option>
                                                        <?php

                                                        endforeach;

                                                        ?>

                                                    </select>

                                                </div>

                                                <span class="icon text-gray-600">Telefono</span>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="telf_alumno" id="telf_alumno" required="required" value="<?php echo $authj->rowff['telefono']; ?>">
                                                </div>


                                                <span class="icon text-gray-600">Género</span>

                                                <div class="form-group">
                                                    <select class="form-control" name="genero_alumno" id="genero_alumno" required="required">
                                                        <option value="">Seleccione</option>
                                                        <option value="F" <?php if ($authj->rowff['genero'] == 'F') {
                                                                                echo " selected";
                                                                            } ?>>Femenino</option>
                                                        <option value="M" <?php if ($authj->rowff['genero'] == 'M') {
                                                                                echo " selected";
                                                                            } ?>>Masculino</option>
                                                    </select>

                                                </div>

                                                <span class="icon text-gray-600">Fecha de Nacimiento</span>

                                                <div class="form-group">
                                                    <input type="date" name="fecnac_alumno" id="fecnac_alumno" required="required" value="<?php echo $authj->rowff['fecnac']; ?>" onclick="this.value = '2000-01-01';" />

                                                </div>

                                                <div id="div_tipo">
                                                    <span class="icon text-gray-600">Tipo de Usuario (Aplica descuentos)</span>

                                                    <div class="form-group">
                                                        <select class="form-control" name="tipo_alumno" id="tipo_alumno">
                                                            <option value="0">Usuario General</option>
                                                            <option value="2" <?php if ($authj->rowff['tipouser'] == 2) { ?> selected<?php } ?>>Afiliado a Club FECHIDA (Descuento 20%)</option>
                                                            <option value="3" <?php if ($authj->rowff['tipouser'] == 3) { ?> selected<?php } ?>>Estudiante (Descuento 15%)</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <span class="icon text-gray-600">Club o Asociación</span>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="club_alumno" id="club_alumno" value="<?php echo $authj->rowff['club']; ?>">
                                                </div>



                                                <div class="form-group" id="div_region">

                                                    <span class="icon text-gray-600">Region</span>

                                                    <select class="form-control" name="region_alumno" id="region_alumno">

                                                        <option hidden disabled selected value>Seleccionar</option>

                                                        <?php

                                                        foreach ($regiones as $row) :

                                                            $id = $row['id'];
                                                            $region = $row['region'];

                                                            echo '<option value=' . $id;
                                                            if ($row['id'] == $authj->rowff['region']) {
                                                                echo " selected";
                                                            }
                                                            echo '>' . $region . '</option>';

                                                        endforeach;

                                                        ?>

                                                    </select>

                                                </div>

                                                <?php if ($authj->rowff['cambiopass'] == 0) { ?>

                                                    <div class="uk-form-group">
                                                        <label class="uk-form-label">Nuevo Password (este password será usado para tus próximos ingresos al sistema)</label>

                                                        <div class="uk-position-relative w-100">
                                                            <span class="uk-form-icon">
                                                                <i class="icon-feather-lock"></i>
                                                            </span>
                                                            <input class="uk-input" name="usu_password" type="password" placeholder="********" required="required">
                                                        </div>

                                                    </div>

                                                    <div class="uk-form-group">
                                                        <label class="uk-form-label">Repite Nuevo Password</label>

                                                        <div class="uk-position-relative w-100">
                                                            <span class="uk-form-icon">
                                                                <i class="icon-feather-lock"></i>
                                                            </span>
                                                            <input class="uk-input" name="usu_password2" type="password" placeholder="********" required="required">
                                                        </div>

                                                    </div>

                                                <?php } ?>


                                            </div>


                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12">



                                    <br>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">Actualizar datos</button>


                                </div>

                            </div>
                        </form>


                    </div>


                </div>

            </div>

        </div>





        <?php include('footer.php'); ?>

    </div>

    <?php include('cierre.php'); ?>





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
    <script src="plugins/dropzone/min/dropzone.min.js?v=2"></script>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
   

   
        $("#dropzone_foto").dropzone({
            url: "<?php echo $baseUrl ?>uploads/perfil.php",
            addRemoveLinks: true,
            dictDefaultMessage : 'Suba su imagen aqui',
            dictResponseError: "Ha ocurrido un error en el server",
            acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.bmp,.JPEG,.JPG,.PNG,.GIF,.BMP',
            uploadMultiple: false,
            maxFiles: 1,
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            params: {
                usuario: '<?php echo $authj->rowff['id'] ?>'
            },
            complete: function(file, response) {
                if (file.status == "success") {

                    console.log(response);


                    $("#user_foto").load("personal_foto.php?size=300", function() {

                        //$('#statusMsg').html('<span style="color:green;">Gracias por agregar imagen.</p>');

                        console.log("Archivo subido correctamente");


                    });
                    this.removeFile(file);

                }
            },
            error: function(file) {
                alert("Error subiendo el archivo " + file.name);
            },
            removedfile: function(file, serverFileName) {
                var name = file.name;

                var element;
                (element = file.previewElement) != null ?
                    element.parentNode.removeChild(file.previewElement) :
                    false;

            }
        });
        </script>



</body>

</html>