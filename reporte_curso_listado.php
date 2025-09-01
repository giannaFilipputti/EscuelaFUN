<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "reporte_alumnos";
$scripts = "none";

if ($authj->rowff['labor'] < 4)  {
	header("Location: index.php");	
	die();
}

$reporte = new Curso();
$reporte = $reporte->getAll_Simple();

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

        <h4 class="col-lg-12">Listado de cursos</h4>

            <div class="uk-child-width-1" uk-grid>

            <div class="table-responsive">

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Inscritos</th>
                        <?php if ($authj->rowff['labor'] >= 6) { ?>
                        <th class="text-center">Pre-Inscritos 2022</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reporte as $row): 

                    $id_curso = $row['id'];

                    $titulo = $row['titulo'];         
                        
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $titulo." (". $row['ciclo'].")";?></td>
                        <td class="text-center"><?php echo '<a class="btn btn-primary" href="reporte_cursos.php?id='.$id_curso.'&estado=pagado">Ver reporte</a>';?></td>
                        <?php if ($authj->rowff['labor'] >= 6) { ?>
                        <td class="text-center"><?php echo '<a class="btn btn-primary" href="reporte_cursos.php?id='.$id_curso.'">Pre-inscritos</a>';?></td>
                        <?php } ?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            </div>

            </div>

        </div>

    </div>

<?php include('footer.php'); ?>

</div>

<?php include('cierre.php'); ?>

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
        var table = $('#example').DataTable({
           
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

            dom: 'Bfrtip',

            destroy: true,

            buttons: ['pageLength']   
            
        });
    } );
</script>

</body>

</html>