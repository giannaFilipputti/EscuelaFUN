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
                    <h2 class="mb-0">Bienvenido <span class="uk-text-bold"></span></h2>
                    <p class="my-0">Ingresa al sistema para iniciar tu curso.</p>
                </div>
                <?php if ($act=='OK') { ?>
          <div class="col-md-12 azul paddsup">Se ha enviado un email a su correo electrónico, por favor siga las instrucciones para recuperar su clave.</div>
          <?php } else  if ($err=='1') { ?>
          <div class="col-md-12 roja paddsup">El email introducido no está registrado en nuestra base de datos.</div>
          <?php }?>

          <?php
                $db = Db::getInstance();
                $sql = "SELECT * FROM com_passrecover WHERE clave = :clave AND usuario = :usuario LIMIT 1";
                $bind = array(
                   ':clave' => $unique,
                   ':usuario' => $id
                );

                $cont = $db->run($sql, $bind);


	if ($cont > 0) {
            $db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
                        if ($rowff1[0]['estado'] == 0) {
                        ?>
                 <form id="login" action="<?php echo BASE_PATH;?>recover_pass1.php" method="post">
								 <input type="hidden" value="<?php echo $id?>" name="id">
								 <input type="hidden" value="<?php echo $unique?>" name="unique">
                    

                    <div class="uk-form-group">
                        <label class="uk-form-label">Nuevo  Password</label>

                        <div class="uk-position-relative w-100">
                            <span class="uk-form-icon">
                                <i class="icon-feather-lock"></i>
                            </span>
                            <input class="uk-input" name="usu_newpwd" type="password" placeholder="********">
                        </div>

                    </div>


                    <div class="uk-form-group">
                        <label class="uk-form-label">Repite Nuevo Password</label>

                        <div class="uk-position-relative w-100">
                            <span class="uk-form-icon">
                                <i class="icon-feather-lock"></i>
                            </span>
                            <input class="uk-input" name="usu_password2" type="password" placeholder="********">
                        </div>

                    </div>

                  

                    <div class="uk-flex-middle uk-grid-small" uk-grid>
                        
                        <div class="uk-width-auto@s">
                            <button type="submit" class="btn btn-default">Enviar</button>
                        </div>
                    </div>

                </form>

                <?php } else { ?>
              <div class="roja">La url de recuperación de contraseña ya fue utilizada</div>
              <?php }  ?>
        <?php } else { ?>
              <div class="roja">La url de recuperación de contraseña es inválida</div>
              <?php }  ?>
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