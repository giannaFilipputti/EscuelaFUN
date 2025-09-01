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
$reporte = $reporte->preinscritos_2022();

$mod = new Modulo();
$modulos = $mod->getAll($id);

$exam = new Examen();

$conta = 0;
$conta1 = 0;


$preRe = new Curso();


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

                    <th>Apellido1</th>
                    <th>Apellido2</th>
                    <th>DNI</th>
                    <th>Genero</th>
                    <th>Email</th>
                    <th clase="no-sort">Region</th>
                    <th clase="no-sort">Cursos</th>
                    <th class="no-sort">Sesion iniciada</th>
                   
                    
                        <th>Cursos</th>
                        
					
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

                    $prerequisitos = 0;

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
                    $cursosID = $row['cursosID'];

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

                    $getPrecio = Alumno::getPrecio($row['tipouser'], $row['pais']);

                    $existeUser = array();
                    $otroemail = "";

                    unset($existeUser);

                    $existeUser = Alumno::existeUsuario($email);
                    $colorEmail = "#000000";
                    $colorDNI = "#000000";
                    $revisarPRE = 0;
                    $idUser = ""; 

                    if (empty($existeUser['email'])) {

                        echo "<br> si entra - ";

                       $porcionesrut = explode("-", $row['dni']);
                       $pass = sha1(md5(trim($porcionesrut[0])));
                       $clave00 = uniqid();

                        $datos = array();
                        $datos['nombre'] = $row['nombre'];
                        $datos['ape1'] = $row['ape1'];
                        $datos['ape2'] = $row['ape2'];
                        $datos['dni'] = $row['dni'];
                        $datos['dni1'] = $row['dni1'];
                        $datos['email'] = $row['email'];
                        $datos['pais'] = $row['pais'];
                        $datos['region'] = $row['regionO'];
                        $datos['telefono'] = $row['telefono'];
                        $datos['clave'] = $clave00;
                        $datos['pass'] = $pass;
                        $datos['club'] = $row['club'];
                        $datos['genero'] = $row['genero'];
                        $datos['fecnac'] = $row['fecnac'];
                        $datos['tipouser'] = $row['tipouser'];

                        $idUser = $preRe->agregarAlumno ($datos);

                        echo $idUser."<br>";

                    } else { 

                    if (strtolower(trim($existeUser['email']))== strtolower(trim($email))) {
                        $colorEmail = "#0000FF";
                        $revisarPRE = 1;
                        $revisarUser = $existeUser['id'];
                        $idUser = $existeUser['id'];
                        if (strtolower(trim($existeUser['dni'])) == strtolower(trim($dni))) {
                            $colorDNI = "#0000FF";
                            $revisarPRE = 1;
                        } 
                    }

                    $existeUserD = Alumno::existeUsuarioDNI($dni);

                    if (trim($existeUserD['dni']) == trim($dni)) {
                        $colorDNI = "#00FF00";
                        $revisarPRE = 1;
                        $revisarUser = $existeUserD['id'];

                        if (strtolower(trim($existeUserD['email'])) != strtolower(trim($email)) ) {
                            $otroemail = $existeUserD['email'];
                            $conta++;
                           $datosDist .= $existeUserD['email']." - ".$email."<br>";

                        }

                    }

                }

                    




                    $texto = "Le recordamos HOY la Clase Online del Curso Mesa Técnica de Natación a las 11:00 am, para ingresar debe ingresar a https://capacitaciones.fechida.org/ al ingresar al curso podra acceder a la reunion usando el boton de Acceso. Le esperamos";
//echo $texto;
                    /*
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, "https://www.waboxapp.com/api/send/chat");
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                        curl_setopt($ch, CURLOPT_POST, 1);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, "token=ad7bfc1f743d27131928cb3663d102f55ed970c1e3575&uid=56933529666&to=".$row['telefono']."&custom_uid=&text=".$texto."%21");
                                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 25);
                    
                                        $response = curl_exec($ch);
                                        $info = curl_getinfo($ch);
                                        curl_close ($ch);*/
                                       
                        
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $row['nombre']." - ".$idUser;?></td>
                        <td class="text-center"><?php echo $row['ape1'];?></td>
                        <td class="text-center"><?php echo $row['ape2'];?></td>
                        <td class="text-cetner"><span style="color:<?php echo $colorDNI?>"><?php echo $dni;?></span></td>
                        <td class="text-center"><?php echo $row['genero'];?></td>
                        <td class="text-center"><span style="color:<?php echo $colorEmail?>"><?php echo $email;?></span>
                        <?php if (!empty($otroemail)) {
                            ?>
                        <br><span style="color:#00FF00"><?php echo $otroemail;?></span>
                        <?php } ?>
                    
                    </td>
                        <td class="text-center"><?php echo $region;?></td>
                        <td class="text-center"><?php echo $cursos;?></td>
                        <td class="text-center"><?php echo $conectado;?></td>
						
						
                        
                        
                        <?php
                        $porciones = explode("-", $cursosID);
                        $cursoAcum = "";
                        foreach ($porciones as $Elem) { 
                          // if ($Elem['examen_unico'] == 1) { 
                              $mostrar_exam = "";
                              $prerequisitos = 0;

                              $cursoPre = $preRe->getOne($Elem);
                            if ($revisarPRE == 1) {

                                $modulo = 0;

                                

                                if ($Elem==7) {
                                    $modulo = 30;
                                } else if ($Elem==8) {
                                    $modulo = 31;
                                }

                                if ($modulo >0) {

                                $exam->modulo = $modulo;  
                                $mostrar_exam = "";                         
                                $exam->alumno = $revisarUser;
                                $estado_exam = $exam->getEstado();
                                if ($estado_exam == 5) {
                                $mostrar_exam = " (NO Cumple pre-requisitos)";
                                $nota = "";
                                } else if ($estado_exam == 1) {
                                    $mostrar_exam = " (NO Cumple pre-requisitos)";
                                    $nota = "";
                                } else if ($estado_exam == 2) {
                                    $mostrar_exam = " (NO Cumple pre-requisitos)";
                                    $nota = $exam->nota;
                        
                                } else if ($estado_exam == 3 or $estado_exam == 4) { 
                                    if ($exam->aprobado == 1) {
                                        $mostrar_exam = " (Cumple pre-requisitos)";
                                        $nota = $exam->nota;
                                        $prerequisitos = 1;
                                        } else {
                                        $mostrar_exam = " (NO Cumple pre-requisitos)";
                                        $nota = $exam->nota;
                                        }
                                    
                                } 
                            } else {
                                $mostrar_exam = "No requiere pre-requisitos";
                                $nota = 0;

                            }

                            } else {
                                $mostrar_exam = "";
                                $nota = 0;

                            }

                            $cursoestado = 0;

                            $precio = $cursoPre[0][$getPrecio];
                            if ($precio == 0) {
                                $cursoestado = 1;
                            }

                            $cursoAcum .= $cursoPre[0]['titulo'].$mostrar_exam."<br>";

                            $preRe->preinscribir($Elem, $idUser, $cursoestado, $row['tipouser'], $prerequisitos)
                            
                            ?>
                        
						
						
						
                    <?php //}
                    }  ?>
                    <td class="no-sort"><?php echo $cursoAcum ;?></td>
                        
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <?php echo "Total emails distintos ".$conta."<br>Total distintos dni, mismo email: ".$conta1."<br>".$datosDist; ?>

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

                this.api().columns([5,6,7,8]).every( function () {

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
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8],

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