<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "reporte_alumnos";
$scripts = "none";

if ($authj->rowff['labor'] < 4) {
    header("Location: index.php");
    die();
}

$reporte = new Curso();
$reporte = $reporte->reporteAlumnos();

?>

<?php include('header.php'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

<style>
    table {
        width: 100%;
    }

    #example_filter {
        float: right;
    }

    #example_paginate {
        float: right;
    }

    label {
        display: inline-flex;
        margin-bottom: .5rem;
        margin-top: .5rem;

    }
</style>

<body>

    <div id="wrapper" class="bg-white">

        <?php include('menu.php'); ?>

        <div class="page-content">

            <div class="container">

                <h4 class="col-lg-12">Reporte de alumnos inscritos</h4>

                <div class="uk-child-width-1" uk-grid>

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre/s</th>
                                    <th>Apellido/s</th>
                                    <th>RUT</th>
                                    <?php if ($authj->rowff['labor'] >= 6) { ?>
                                        <th>Email</th>
                                    <?php } ?>
                                    <th>Región</th>
                                    <th>fec nac</th>
                                    <th>Cursos asignados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reporte as $row):

                                    $nombres = $row['nombre'];
                                    //$nombres = str_replace(' ', '<br />', $nombres);

                                    $apellidos = $row['ape1'] . " " . $row['ape2'];
                                    //$apellidos = str_replace(' ', '<br />', $apellidos);

                                    $email = $row['email'];
                                    $dni = $row['dni'];

                                    $region = $row['region'];

                                    $fecnac = $row['fecnac'];

                                    $cursos = $row['cursos'];
                                    $cursos = str_replace(',', '<br />', $cursos);

                                ?>

                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><a href="alumno_det.php?id=<?php echo $row['id']; ?>"><?php echo $nombres; ?></a></td>
                                        <td><?php echo $apellidos; ?></td>
                                        <td><?php echo $dni; ?></td>
                                        <?php if ($authj->rowff['labor'] >= 6) { ?>
                                            <td><?php echo $email; ?></td>
                                        <?php } ?>
                                        <td><?php echo $region; ?></td>
                                        <td><?php echo $fecnac; ?></td>
                                        <td><?php echo $cursos; ?></td>
                                    </tr>
                                <?php endforeach; ?>
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

                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
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
                    <?php if ($authj->rowff['labor'] >= 6) { ?> {
                            extend: 'excel',
                            text: 'Descargar en Excel',
                            titleAttr: 'excel'
                        },
                        {
                            extend: 'pdf',
                            text: 'Descargar en PDF',
                            titleAttr: 'pdf'
                        }
                    <?php } ?>
                ]



            });
            table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>

</body>

</html>