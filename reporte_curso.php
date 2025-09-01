<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "editar_dni";
$scripts = "none";

if ($authj->rowff['labor'] < 6)  {
	header("Location: index.php");	
	die();
}

$reporte = new Curso();
$reporte = $reporte->reporteAlumnos_3($id);

$mod = new Modulo();
$modulos = $mod->getAll($id);

$exam = new Examen();


?>

<?php include('header.php');?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

<style>
    table{
    width:100%;
    }
    #example_filter{
        float:right;
    }
    #example_paginate{
        float:right;
    }
    label {
        display: inline-flex;
        margin-bottom: .5rem;
        margin-top: .5rem;
    
    }
</style>

<body>

<div id="wrapper" class="bg-white">

<?php include('menu.php');?>

    <div class="page-content">

        <div class="container">

        <h4 class="col-lg-12">Reporte de alumnos inscritos</h4>

            <div class="uk-child-width-1" uk-grid>

            <div class="table-responsive">

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th clase="no-sort">Region</th>
                    <th clase="no-sort">Tipo Usuario</th>
                    <th clase="no-sort">Cursos</th>
                    <th class="no-sort">Sesion iniciada</th>
                   
                    <?php foreach ($modulos as $Elem) {
                        if ($Elem['examen_unico'] == 1) { ?>
                        <th><?php echo $Elem['titulo'];?></th>
                    <?php }
                    }  ?>
                </thead>
                <tbody>
                    <?php 

                    $error = "";
                    
                    function valida_rut($rut){       

                        $espacios = substr_count($rut," ");
                        
                        if ( $espacios >= 1 ):

                            $error = "1";
                            return $error;

                        endif;
                        $rut = preg_replace('/[\.\-]/i', '', $rut);
                        $dv  = substr($rut, -1);
                        $numero = substr($rut, 0, strlen($rut)-1);
                        $i = 2;
                        $suma = 0;
                        foreach(array_reverse(str_split($numero)) as $v)
                        {
                            if($i==8)
                                $i = 2;

                            $suma += $v * $i;
                            ++$i;
                        }

                        $dvr = 11 - ($suma % 11);
                        
                        if($dvr == 11):
                            $dvr = 0;
                        endif;
                        if($dvr == 10):
                            $dvr = 'K';
                        endif;

                        if($dvr == strtoupper($dv)):
                            $error = "0";
                            return $error;
                        endif;
                        
                        if($dvr != strtoupper($dv)):
                            $error = "2";
                            return $error;
                        endif;
                    }
                    
                    $result_validacion = "";
                    $result_validacion2 = "";
                    $validacion = "";

                    foreach ($reporte as $row): 

                    $nombres = $row['nombre']." ".$row['ape1']." ".$row['ape2'];

                    $email = $row['email'];

                    if (strpbrk($rut, ' ') !== false){

                        $result_validacion2 = "EMAIL CON ESPACIOS";

                    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

                        $result_validacion2 = "EMAIL INCORRECTO";

                    }else{

                        $result_validacion2 = "EMAIL CORRECTO";

                    }

                    $dni = $row['dni'];
                    
                    $region = $row['region'];
                    
                    $cursos = $row['cursos'];

                    $validacion = valida_rut($dni);   

                    if($validacion == "0"){

                        $result_validacion = "RUT CORRECTO";

                    }else if ($validacion == "1" || $validacion == "2"){

                        $result_validacion = "RUT INCORRECTO";

                    }else{

                        $result_validacion = "ERROR. CONSULTAR AL ADMINISTRADOR.";
                    }

                    $conectado = $row['clave'];

                    if($conectado == ""){

                        $conectado = "NO";

                    }else{

                        $conectado = "SI";

                    }
                        
                    ?>

                    <tr>
                        <td class="text-center"><?=$nombres;?></td>
                        <td class="text-cetner"><?=$dni;?></td>
                        <td class="text-center"><?=$email;?></td>
                        <td class="text-center"><?=$Elem['telefono'];?></td>
                        <td class="text-center"><?=$region;?></td>
                        <td class="text-center"><?=$cursos;?></td>
                        <td class="text-center"><?=$conectado;?></td>
                        
                        <?php foreach ($modulos as $Elem) { 
                            $exam->modulo = $Elem['id'];  
                            $mostrar_exam = "";                         
                            $exam->alumno = $row['id'];
                            $estado_exam = $exam->getEstado();
                            if ($estado_exam == 5) {
                               $mostrar_exam = "Examen No iniciado";
                            } else if ($estado_exam == 1) {
                                $mostrar_exam = "Examen Iniciado";
                            } else if ($estado_exam == 2) {
                                $mostrar_exam = "Examen Reprobado Intento 1";
                    
                            } else if ($estado_exam == 3 or $estado_exam == 4) { 
                                if ($exam->aprobado == 1) {
                                    $mostrar_exam = "Examen Aprobado";
                                     } else {
                                    $mostrar_exam = "Examen Reprobado Intento 2";
                                     }
                                
                            } 
                            ?>
                        <td class="no-sort"><?php echo $mostrar_exam;?></td>
                    <?php }  ?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <div id="modaleditar" uk-modal="" class="uk-modal" style="">
                <div class="uk-modal-dialog">
                    <div class="uk-modal-header">
                        <h4> Edición de DNI</h4>
                    </div>

                    <div class="uk-modal-body">

                        <form id="actualizar_form">

                            <div class="modal-body">

                            <div class="uk-margin">
                                    
                                <label class="uk-form-label" for="form-stacked-text">Nuevo DNI:</label>
                                <div id="dni" class="uk-form-controls"></div>
                                
                                <label class="uk-form-label" for="form-stacked-text">Nuevo EMAIL:</label>
                                <div id="email" class="uk-form-controls"></div>
                                
                            </div>

                            </div>

                            <p class="uk-text-right">
                                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                                <button class="uk-button uk-button-primary" type="button" onclick="submitContactForm()">Editar</button>
                            </p>

                        </form>

                    </div>
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

    $(document).on("click", ".editar-alumno", function () {

        //$('#dni').html('');
    
        var id = $(this).data('id');

        $.ajax({
            
            dataType : 'json',
            type: "POST",
            url: "alumno_get.php",
            data: {id: id},

            success: function(result){

            var data = result['data'];
            
            var id = data[0][0].id;
            var dni = data[0][0].dni;
            dni = dni.replace(/\s/g, '');
            
            var email = data[0][0].email;
            
            var dni_html = "<input type='hidden' id='id_alumno' class='uk-input' value='"+id+"' /><input type='text' id='dni_alumno' class='uk-input' value='"+dni+"' />";

            $('#dni').html(dni_html);

            var email_html = "<input type='text' id='email_alumno' class='uk-input' value='"+email+"' />";

            $('#email').html(email_html);

            }

        }).fail(function(jqXHR, textStatus){
            console.log(jqXHR);
            console.log(textStatus);
        }); 

    });

</script>

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
    
    var tabla;
    
    $(document).ready(function() {
        
        tabla = $('#example').DataTable({
           
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                buttons: {
                    pageLength: {
                        _: "Mostrar %d registros",
                        '-1': "Todos"
                    }
                }
            },
            
            initComplete: function () {

                this.api().columns([3,4,5,6,8]).every( function () {

                    var title = this.header().innerHTML;

                    var column = this;

                    var select = $('<select><option value=""></option></select>')

                        .appendTo( $(column.header()) )

                        .on( 'change', function () {

                            var val = $.fn.dataTable.util.escapeRegex(

                                $(this).val()

                            );

                            column

                                .search( val ? '^'+val+'$' : '', true, false )

                                .draw();

                        } );



                    column.data().unique().sort().each( function ( d, j ) {

                        if(column.index() == 7 || column.index() == 8 || column.index() == 9 || column.index() == 10){ d = $(d).text(); }

                        select.append( '<option value="'+d+'">'+d+'</option>' )

                    } );

                } );

            },

            columnDefs: [
                { targets: 'no-sort', orderable: false }
            ],

            retrieve: true,

            dom: 'Bfrtip',

            destroy: true,

            buttons: [
                'pageLength',
                {
                    extend:    'excel',
                    text:      'Descargar en Excel',
                    exportOptions: { 
                    columns: [ 0, 1, 2, 3, 4, 5],

                        format: { 

                            header: function ( data, column, row ){

                                return data.split('<')[0]; 

                            }

                        }

                    },
                    titleAttr: 'excel'
                }
            ]    
            
        });
        
        tabla.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );

    } );
</script>

<script>
    function submitContactForm(){

    var id = $('#id_alumno').val();
    var dni = $('#dni_alumno').val();
    var email = $('#email_alumno').val();

    $.ajax({
        type:'POST',
        url:'alumno_update.php',
        data:{id:id, dni:dni, email:email},
        success:function(result){

            //console.log(result);

            $('#modaleditar').removeClass('uk-open').hide();

            UIkit.notification({message: 'DNI/EMAIL editado exitosamente', status: 'success'});

            window.setTimeout(function(){location.reload()},2000);
        
        }
    }).fail(function(jqXHR, textStatus){
        console.log(jqXHR);
        console.log(textStatus);
    }); 

    }
</script>

</body>

</html>