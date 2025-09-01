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

<div class="container-fluid">

<h1 class="h3 mb-2 text-gray-800">Alumnos</h1>

<p class="mb-4">En esta sección podrás ingresar un alumno y asignarlo a uno o muchos cursos.</p>

	<div class="row">

		<div class="col-lg-4">

			<div class="shadow mb-4">

				<div class="card-header py-3">

				<h6 class="m-0 font-weight-bold text-primary">Seleccionar alumno</h6>

				</div>

                <div class="card-body">

                    <span class="icon text-gray-600">Alumno</span>

                    <div class="uk-form-select" data-uk-form-select>

                        <select class="form-control" id="cargar_alumnos">

                            <option disabled selected value>Seleccionar email</option>
                            
                        </select>
                        
                    </div>

                </div>

			</div>

        </div>

		<div class="col-lg-4">

			<div class="card shadow mb-4">

				<div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">Cursos asociados</h6>

                    <div class="card-body">
                    
                        <ul class="list-group" id="cursos_asociados"></ul>

                    </div>

				</div>

			</div>

        </div>

        <div class="col-lg-4">

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
    
    $( document ).ready(function() {
        
        getAlumnos();

        $('#cargar_alumnos').change(function(){

            document.getElementById("cursos_asociados").innerHTML = "";
            document.getElementById("cursos_disponibles").innerHTML = "";

            var id_usuario = $(this).val();

            getCursos_alumno(id_usuario);
        
        });   

    });

</script>

<script type="text/javascript">

    function getAlumnos(id_usuario) {
        
        $.ajax({
            type: "POST",
            url: "getAlumnos.php",
            dataType : 'json',
            cache: false,
            success: function(result){
                
                console.log("getAlumnos:",result);

                result.forEach( function(valor, indice, array) {
                    var html = "<option value="+valor.id+">"+valor.email+"</option>";
                    $('#cargar_alumnos').append(html);
                });

            }
        }).fail(function(jqXHR, textStatus){
            console.log(jqXHR);
            console.log(textStatus);
        });

    }

    function getCursos_alumno(id_usuario) {

        var result1,result2; 
        
        $.ajax({
            type: "POST",
            url: "getCursos_alumno.php",
            data: {id:id_usuario},
            dataType : 'json',
            cache: false,
            success: function(result){
                
                console.log("getCursos_alumno:",result);

                var result1 = result['data1'];

                var result2 = result['data2'];

                if(result1 == ""){

                var html = "<center><h5><b>No hay cursos asociados</b></h5></center>";  
                $('#cursos_asociados').append(html);

                }else{

                    result1.forEach( function(valor, indice, array) {
                        var html = 
                            "<li class='list-group-item' id='event-"+valor.id+"' onclick='delCurso(\"event-"+valor.id+"\","+valor.id+")'"+ 
                                "data-toggle='tooltip' data-placement='top' title='"+valor.titulo+"'>"+
                                "<input class='cursoSeleccionado' type='hidden' value='"+valor.id+"'>"+
                                "<h6>"+valor.titulo+"</h6>"+
                            "</li><br>";  
                        $('#cursos_asociados').append(html);
                    });

                    $('#cursos_asociados').append("<button onclick='del_usuario_curso()' class='uk-button uk-button-danger uk-button-large' id='btn_desasociar'>Desasignar curso/s</button>");

                }

                if(result2 == ""){

                    var html = "<center><h5><b>No hay cursos disponibles</b></h5></center>";  
                    $('#cursos_disponibles').append(html);

                }else{    
                    
                    result2.forEach( function(valor, indice, array) {
                        var html = 
                            "<li class='list-group-item' id='event-"+valor.id+"' onclick='addCurso(\"event-"+valor.id+"\","+valor.id+")'"+ 
                                "data-toggle='tooltip' data-placement='top' title='"+valor.titulo+"'>"+
                                "<input class='cursoSeleccionado' type='hidden' value='"+valor.id+"'>"+
                                "<h6>"+valor.titulo+"</h6>"+
                            "</li><br>";  
                        $('#cursos_disponibles').append(html);
                    });

                    $('#cursos_disponibles').append("<button onclick='add_usuario_curso()' class='uk-button uk-button-primary uk-button-large' id='btn_asociar'>Asignar curso/s</button>");

                }

            }
        }).fail(function(jqXHR, textStatus){
            console.log(jqXHR);
            console.log(textStatus);
        });

    }

</script>

<script type="text/javascript">

    let cursos_usuarios = [];
    let cursos_usuarios2 = [];

    function add_usuario_curso(){

        var jsonString = JSON.stringify(cursos_usuarios);

        if(jsonString == "[]"){

            alert("ERROR. No ha seleccionado ningún curso para asignar.");

        }else{

            $.ajax({
                type: "POST",
                url: "add_usuario_curso_2.php",
                dataType : 'json',
                data: {
                    data : jsonString,
                    id_usuario: $('#cargar_alumnos').val()
                }, 
                cache: false,
                success: function(result){
                    
                    console.log("add_usuario_curso:",result);
                    
                    if(result.success){

                        alert("Alumno asignado a curso/s exitosamente.");
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

    function del_usuario_curso(){

        var jsonString = JSON.stringify(cursos_usuarios2);

        if(jsonString == "[]"){

            alert("ERROR. No ha seleccionado ningún curso para desasignar.");

        }else{

            $.ajax({
                type: "POST",
                url: "del_usuario_curso_2.php",
                dataType : 'json',
                data: {
                    data : jsonString,
                    id_usuario: $('#cargar_alumnos').val()
                }, 
                cache: false,
                success: function(result){
                    
                    console.log("del_usuario_curso:",result);
                    
                    if(result.success){

                        alert("Alumno desasignado de curso/s exitosamente.");
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

    function delCurso(id,value){
    
        if (!$('#'+id).hasClass("cursoSeleccionado")) {

            $('#'+id).addClass("cursoSeleccionado");
            
            cursos_usuarios2.push(value);
            
            console.log(cursos_usuarios2);

        }
        
        else{

            $('#'+id).removeClass("cursoSeleccionado");

            const index = cursos_usuarios2.indexOf(value);
            
            if (index > -1) {
                
                cursos_usuarios2.splice(index, 1);
            
            }
            
            console.log(cursos_usuarios2);

        }

    }
        
</script>

</body>

</html>