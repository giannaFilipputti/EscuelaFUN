<style>
    /* makes main-menu open on hover */
    .menu-item:hover>.dropdown-menu {
        display: block;
    }

    /* makes sub-menu S open on hover */
    .submenu-item:hover>.dropdown-menu {
        display: block;
    }

    .dropdown-toggle::after {
        display: none;
    }
</style>

<header class="header header-horizontal header bg-white uk-light">

    <div class="container">
        <nav uk-navbar>

            <!-- left Side Content -->
            <div class="uk-navbar-left">

                <!-- menu icon -->
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>

                <!-- logo -->
                <a href="index.php" class="logo">
                    <img src="assets/images/logos.png?v=3" alt="">
                </a>
                <nav id="navigation">
                    <ul id="responsive">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="escuela.php">La Escuela</a></li>
                        <li><a href="cursos.php">Cursos</a></li>
                        <!--<li><a href="clinicas.php">Presenciales</a></li>
                        <li><a href="preinscripcion.php">Pre-Inscripciones</a></li>-->
                        <!--<li><a href="intro.php">Cursos</a></li>-->



                        <li><a href="contacto.php">Contacto</a></li>

                        <li><a href="ayuda.php">Ayuda</a> </li>
                        <?php
                        if ($authj->rowff['labor'] >= 4 && $authj->logueado == 1) {
                        ?>
                            <li class="menu-item nav-item dropdown">
                                <a class="nav-link" href="#" role="button">
                                    Administrador
                                </a>
                                <div class="dropdown-menu">
                                    <?php if ($authj->rowff['labor'] >= 6 && $authj->logueado == 1) { ?>
                                        <a class="dropdown-item" href="agregar_usuario.php" style="color: black;">Agregar usuarios</a>
                                        <a class="dropdown-item" href="agregar_curso.php" style="color: black;">Ver/Editar cursos</a>
                                        <a class="dropdown-item" href="editar_dni.php" style="color: black;">Editar Dni/Email</a>
                                        <a class="dropdown-item" href="asociar_profesor.php" style="color: black;">Asociar profesor</a>
                                        <a class="dropdown-item" href="reporte_pagos.php" style="color: black;">Pagos</a>
                                    <?php } ?>
                                    <?php if ($authj->rowff['labor'] >= 4 && $authj->logueado == 1) { ?>
                                        <a class="dropdown-item" href="reporte_alumnos.php" style="color: black;">Reporte alumnos</a>
                                        <a class="dropdown-item" href="reporte_curso_listado.php" style="color: black;">Reporte cursos</a>
                                        <a class="dropdown-item" href="reporte_clinicas_listado.php" style="color: black;">Reporte clinicas</a>
                                    <?php } ?>
                                    <?php if ($authj->rowff['labor'] >= 5 && $authj->logueado == 1) { ?>

                                        <a class="dropdown-item" href="reporte_codigos.php" style="color: black;">Codigos Institucionales</a>
                                    <?php } ?>

                                </div>
                            </li>
                        <?php } ?>



                    </ul>
                </nav>

                <!-- MENU -->

            </div>


            <!--  Right Side Content   -->

            <div class="uk-navbar-right">

                <?php if ($authj->logueado == 1) { ?>




                    <a href="#" class="header-widget-icon profile-icon">
                        <?php if (!empty($authj->rowff['foto_perfil'])) { ?>
                            <img src="uploads/g_perfil_<?php echo $authj->rowff['id']; ?>_<?php echo $authj->rowff['foto_perfil']; ?>.jpg" alt="" class="header-profile-icon">
                        <?php } else { ?>
                            <img src="../assets/images/avatars/home-profile1.jpg" alt="" class="header-profile-icon">
                        <?php } ?>
                    </a>

                    <div uk-dropdown="pos: top-right ;mode:click" class="dropdown-notifications small">

                        <!-- User Name / Avatar -->
                        <a href="profile-1.html">

                            <div class="dropdown-user-details">
                                <div class="dropdown-user-avatar">
                                    <?php if (!empty($authj->rowff['foto_perfil'])) { ?>
                                        <img src="uploads/g_perfil_<?php echo $authj->rowff['id']; ?>_<?php echo $authj->rowff['foto_perfil']; ?>.jpg" alt="">
                                    <?php } else { ?>
                                        <img src="../assets/images/avatars/home-profile1.jpg" alt="">
                                    <?php } ?>

                                </div>
                                <div class="dropdown-user-name">
                                    <?php echo $authj->rowff['nombre'] . " " . $authj->rowff['ape1'] . " " . $authj->rowff['ape2'] ?> <span><?php echo Region::getRegion($authj->rowff['region']) ?></span>
                                </div>
                            </div>

                        </a>

                        <!-- User menu -->

                        <ul class="dropdown-user-menu">
                            <!--
                                    <li>
                                        <a href="#">
                                            <i class="icon-material-outline-dashboard"></i> Dashboard</a>
                                    </li>-->

                            <li><a href="miscursos.php">
                                    <i class="icon-feather-bookmark"></i> Mis cursos </a>
                            </li>
                            <li><a href="misdiplomas.php">
                                    <i class="icon-material-baseline-star-border"></i> Mis diplomas </a>
                            </li>
                            <li><a href="personal.php">
                                    <i class="icon-material-outline-account-circle"></i> Actualizar perfil</a>
                            </li>
                            <li><a href="misdatos_pass.php">
                                    <i class="icon-feather-edit"></i> Modificar Contraseña</a>
                            </li>


                            <li class="menu-divider">
                            <li><a href="ayuda.php">
                                    <i class="icon-feather-help-circle"></i> Ayuda</a>
                            </li>
                            <li><a href="salir.php">
                                    <i class="icon-feather-log-out"></i> Salir</a>
                            </li>
                        </ul>


                    </div>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-xs btn-default pull-right">Ingresar</a>


                <?php }  ?>


                <nav id="navigation">

                    <!--
                    <ul id="responsive">
                    <?php if ($authj->logueado == 1) { ?> 
                        <li style="color:#134a6b; font-size:0.8em">Bienvenido(a): <?php echo $authj->rowff['nombre'] . " " . $authj->rowff['ape1'] . " " . $authj->rowff['ape2'] ?><br><?php echo Region::getRegion($authj->rowff['region']) ?></li>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="salir.php" class="btn btn-xs btn-default pull-right">Cerrar sesión</a>
                        <?php } else { ?>
                            <li class="ingresa"><a href="login.php">Ingresar</a> </li>
                            

                        <?php }  ?>

                    </ul>-->
                </nav>


                <!-- icon search-->


                <!-- User icons -->


            </div>
            <!-- End Right Side Content / End -->


        </nav>

    </div>
    <!-- container  / End -->

</header>