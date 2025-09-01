<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
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
                    <h2 class="mb-0">Bienvenido <span class="uk-text-bold"></span></h2>
                    <p class="my-0">Modifica tu password.</p>
                </div>
                <?php if ($err=='1') { ?>
                        <div class="alert alert-danger" role="alert">Tu password actual es incorrecto. El password no se actualizó.</div>
		  <?php } else  if ($err=='6') { ?>
          <div class="col-md-12 roja paddsup">El email que está intentado registrar ya está registrado en la base de datos. <br>
		  Puedes <a href="login.php" style="color:#0000FF"><u>acceder con tu email y password</u></a><br>
		  Si Olvidaste tu password puedes <a href="forgot.php" style="color:#0000FF"><u>recuperarlo aqui</u></a>
		  </div>
          <?php } ?>
          <?php if ($act=='OK') { ?>
                <div class="col-md-12 paddsup">
					<div class="alert alert-success" role="alert">
					  Sus datos han sido actualizados.
					</div>
					
				</div>
          <?php } ?>
          <form id="registro_p" action="action_registro.php?action=cpass" method="post">

                    <div class="uk-form-group">
                        <label class="uk-form-label"> Password Actual</label>

                        <div class="uk-position-relative w-100">
                            <span class="uk-form-icon">
                                <i class="icon-feather-lock"></i>
                            </span>
                            <input class="uk-input" name="usu_pass" type="password" placeholder="********" required="required">
                        </div>

                    </div>

                    <div class="uk-form-group">
                        <label class="uk-form-label">Nuevo Password</label>

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

                    <div class="uk-form-group">
                        <label class="uk-form-label">Teléfono</label>

                        <div class="uk-position-relative w-100">
                            <span class="uk-form-icon">
                                <i class="icon-feather-phone-call"></i>
                            </span>
                            
                            <?php if($authj->rowff['cambiopass'] == 0){ ?>
                            
                            <input class="uk-input" name="telefono" type="telefono" placeholder="Ejemplo: +56912345678" required="required">

                            <?php } else{ ?>

                            <input class="uk-input" name="telefono" type="telefono" value="<?php echo $authj->rowff['telefono']; ?>" readonly>

                            <?php } ?>
                        
                        </div>

                    </div>

                    <div class="uk-flex-middle uk-grid-small" uk-grid>
                     
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