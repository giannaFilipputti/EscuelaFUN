<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "reporte_alumnos";
$scripts = "none";

if ($authj->rowff['labor'] < 6)  {
	header("Location: index.php");	
	die();
}

$reporte = new Curso();
$reporte = $reporte->reporteAlumnos();

$regiones = new Curso();
$regiones = $regiones->getRegiones();

?>

<?php include('header.php');?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

<style>
    .cursoSeleccionado{
        background-color: #007bff;
    }
</style>

<body>

<div id="wrapper" class="bg-white">

<?php include('menu.php');?>

<div class="container">

<h1 class="h3 mb-2 text-gray-800">Alumnos</h1>

<p class="mb-4">En esta sección podrás ingresar un alumno y asociar a uno o muchos cursos.</p>

	<div class="row">

		<div class="col-lg-4">

			<div class="shadow mb-4">

				<div class="card-header py-3">

				<h6 class="m-0 font-weight-bold text-primary">Datos del alumno</h6>

				</div>

                <div class="card-body">

                    <div class="table-responsive">

                        <span class="icon text-gray-600">Nombre</span>

                        <div class="form-group">
                            <input type="text" class="form-control" name="nombre_alumno" id="nombre_alumno" required="required">
                        </div>

                        <span class="icon text-gray-600">Rut</span>

                        <div class="form-group">
                            <input type="text" class="form-control" oninput="checkRut(this)" maxlength="10" name="rut_alumno" id="rut_alumno" required="required">
                        </div>  
                        
                        <span class="icon text-gray-600">Email</span>

                        <div class="form-group">
                            <input type="email" class="form-control"name="email_alumno" id="email_alumno" required="required">
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
                            
                            <span class="icon text-gray-600">Region</span>
                            
                            <select class="form-control" name="region_alumno" id="region_alumno" required="required">

                                <option hidden disabled selected value>Seleccionar</option>

                                <?php

                                foreach ($regiones as $row): 

                                    $id = $row['id'];
                                    $region = $row['region'];

                                    echo '<option value='.$id.'>'.$region.'</option>';

                                endforeach;
                                
                                ?>
                            
                            </select>

                        </div>                  

                        <br>

                        <button onclick="add_usuario_curso()" class="btn btn-primary btn-user btn-block">Ingresar usuario</button>

                    </div>

                </div>

			</div>

		</div>

		<div class="col-lg-8">

			<div class="card shadow mb-4">

				<div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">Cursos disponibles</h6>

                    <div class="card-body">
                    
                        <ul class="list-group" id="cursos_disponibles"></ul>

                    </div>

				</div>

			</div>

        </div>

    </div>

</div>

<?php include('footer.php'); ?>

</div>

<?php include('cierre.php'); ?>

<script type="text/javascript">

    function getCursos(id_usuario) {
        
        $.ajax({
            type: "POST",
            url: "getCursos.php",
            dataType : 'json',
            cache: false,
            success: function(result){
                
                console.log("getCursos:",result);

                result.forEach( function(valor, indice, array) {
                    var html = 
                        "<li class='list-group-item' id='event-"+valor.id+"' onclick='addCurso(\"event-"+valor.id+"\","+valor.id+")'"+ 
                            "data-toggle='tooltip' data-placement='top' title='"+valor.titulo+"'>"+
                            "<input class='cursoSeleccionado' type='hidden' value='"+valor.id+"'>"+
                            "<h5>"+valor.titulo+"</h5>"+
                        "</li>"+
                        "<br>";  
                    $('#cursos_disponibles').append(html);
                });

            }
        }).fail(function(jqXHR, textStatus){
            console.log(jqXHR);
            console.log(textStatus);
        });

    }

    $( document ).ready(function() {
        document.getElementById("cursos_disponibles").innerHTML = "";
        getCursos();
    });

</script>

<script type="text/javascript">

    let cursos_usuarios = [];
    
    function addCurso(id,value){
    
        if (!$('#'+id).hasClass("cursoSeleccionado")) {

            $('#'+id).addClass("cursoSeleccionado");
            
            cursos_usuarios.push(value);
            
            console.log(cursos_usuarios);

        }
        
        else{

            $('#'+id).removeClass("cursoSeleccionado");

            const index = cursos_usuarios.indexOf(value);
            
            if (index > -1) {
                
                cursos_usuarios.splice(index, 1);
            
            }
            
            console.log(cursos_usuarios);

        }

    }

    function add_usuario_curso(){

        var jsonString = JSON.stringify(cursos_usuarios);

        if(jsonString == "[]"){

            alert("Favor seleccione al menos un curso para el usuario");

        }else{

            $.ajax({
                type: "POST",
                url: "add_usuario_curso.php",
                dataType : 'json',
                data: {
                    data : jsonString,
                    nombre_alumno: $('#nombre_alumno').val(),
                    rut_alumno: $('#rut_alumno').val(),
                    email_alumno: $('#email_alumno').val(),
                    apepat_alumno: $('#apepat_alumno').val(),
                    apemat_alumno: $('#apemat_alumno').val(),
                    region_alumno: $('#region_alumno').val()
                }, 
                cache: false,
                success: function(result){
                    
                    console.log("add_usuario_curso:",result);
                    
                    if(result.success){

                        alert("Alumno creado exitosamente");
                        location.reload();
                    
                    }else{

                        alert(result.error);

                    }
                }

            }).fail(function(jqXHR, textStatus){
                console.log(jqXHR);
                console.log(textStatus);
            });

        }

    }
        
</script>

<script type="text/javascript">
  
    function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');

    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();

    // Formatear RUN
    rut.value = cuerpo + '-'+ dv

    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}

    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;

    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {

        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }

    }

    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);

    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;

    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }

    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');

}

</script>

</body>

</html>