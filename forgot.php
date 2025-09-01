<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";



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

        



            <div class="uk-width-1-3@m m-auto my-5">
                <div class="mb-4">
                    <h2 class="mb-0">Recuperar Contraseña<span class="uk-text-bold"></span></h2>
                    <p class="my-0">Si has olvidado tu password, ingresa tu email y te enviaremos las instrucciones para recuperar tu password</p>
                </div>
                <?php if ($act=='OK') { ?>
            <div class="alert alert-success" role="alert">Se ha enviado un email a su correo electrónico, por favor siga las instrucciones para recuperar su clave.</div>
          <?php } else  if ($err=='1') { ?>
            <div class="alert alert-danger bg-Danger" role="alert">El email introducido no está registrado en nuestra base de datos.</div>
          <?php }?>
                <form method="POST" action="action_registro.php?action=forgot">

                    <div class="uk-form-group">
                        <label class="uk-form-label"> Email</label>

                        <div class="uk-position-relative w-100">
                            <span class="uk-form-icon">
                                <i class="icon-feather-mail"></i>
                            </span>
                            <input class="uk-input" name="usu_email" type="email" placeholder="email@tucorreo.com">
                        </div>

                    </div>

                                     

                    <div class="uk-flex-middle uk-grid-small" uk-grid>
                        <div class="uk-width-expand@s">
                            <p><a href="login.php">Login</a></p>
                        </div>
                        <div class="uk-width-auto@s">
                            <button type="submit" class="btn btn-default">Enviar</button>
                        </div>
                    </div>

                </form>
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