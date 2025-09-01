<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";

header("location: cursos.php");
die();


foreach ($_GET as $key => $value) {
    //if ($key != 'filtro' && $key != 'adfil') {
    $listvarall .=  $key . "=" . $value . "&";
    //}


    if ($key != 'pagi') {
        $listvar .=  $key . "=" . $value . "&";
    }

    if ($key != 'orden' && $key != 'tiporden' && $key != 'pagi') {
        $listvaro .=  $key . "=" . $value . "&";
    }
}

$curs = new Curso();

if (!empty($orden)) {
    $mod->orden = $orden;
}

if (!empty($tiporden)) {
    $mod->tiporden = $tiporden;
}


if (!empty($pagi)) {
    $mod->pag = $pagi;
}


$cursos = $curs->getAll();



?>
<?php include('header.php');?>

<body>

    <!-- Wrapper -->
    <div id="wrapper" class="bg-white">

        <!-- Header Container
        ================================================== -->
        

                        <!-- MENU -->
						<?php include('menu.php');?>
                        
                      

        <!-- overlay seach on mobile-->
      



        
        <div class="page-content">

        <div class="page-content-inner">

           

            <h4 class="mt-lg-7 mt-4">Cursos Disponibles</h4>
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>

            <?php foreach ($cursos as $Elem) {
                $inscrito = $curs->checkInscritoCurso($Elem['id'], $authj->rowff['id']);
                if ($inscrito == 1) {
                    $link_mod = "modulos.php?id=".$Elem['id'];
                    $clase_mod = "";

                } else {
                    $link_mod = "#";
                    $clase_mod = "disabled";
                }
                
                ?>

                <div>


                    <a href="<?php echo $link_mod ?>">
                        <div class="course-path-card <?php echo $clase_mod ?>">
                            <img src="../assets/images/course/<?php echo $Elem['id'] ?>.jpg?v=1" alt="">
                            <div class="course-path-card-contents">
                                <h3> <?php echo $Elem['titulo'] ?> </h3>
                                <p> <?php echo $Elem['descripcion'] ?>
                                </p>
                                <div class="course-progressbar mt-3">
                                    <div class="course-progressbar-filler" style="width:0%"></div>
                                </div>
                            </div>
                            <div class="course-path-card-footer">
                                <h5> <i class="icon-feather-film mr-1"></i> xx Videos </h5>
                                <div>
                                    <h5>
                                        <i class="icon-feather-clock mr-1"></i>
                                        16 Horas </h5>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>

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