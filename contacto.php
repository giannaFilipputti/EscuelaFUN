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
                <?php if ($act=='OK' or $act=='rOK') { ?>
                <div class="col-md-12 paddsup">
					<div class="alert alert-success" role="alert">
					  Gracias por registrarse, debe confirmar su registro,. <br>Revise la bandeja de entrada de su correo electrónico  y haga clic en el enlace que aparece en el email que le hemos enviado.<br>En caso de que no aparezca en su bandeja principal , revise en la carpeta de "Correo no deseado".
					</div>
					
				</div>
          <?php } else if ($reg=='OK') { ?>
          <div class="col-md-12 paddsup">		  
			  <div class="alert alert-success" role="alert">
						  Gracias por registrarse, a partir de ahora puede acceder a nuestro servicio introduciendo sus datos de acceso.
			  </div>
		  </div>
          <?php } else if ($recpass=='OK') { ?>
          <div class="col-md-12 paddsup">
				<div class="alert alert-success" role="alert">
						Se ha guardado su nueva contraseña, puede acceder a su cuenta.
			  </div>
		  </div>
          <?php } else  if ($err=='2' or $err=='1') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-danger bg-Danger" role="alert">
			  Correo y contraseña no coincide.
			</div>			
		  </div>
          <?php } else if ($err=='3') { ?>
          <div class="col-md-12 paddsup">
				<div class="alert alert-success" role="alert">
						Su cuenta ha sido activada previamente, ya puede acceder con su email y contraseña.
			  </div>
		  </div>
          <?php } else  if ($err=='4') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-danger bg-Danger" role="alert">
			  Debe activar su cuenta antes de acceder usando el email que recibió en su correo electrónico en el momento del registro.
			</div>	
			
		  </div>
          <?php } else  if ($err=='6') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-danger bg-Danger" role="alert">
			  El email que está intentado registrar ya está registrado en la base de datos, use su correo y contraseña para acceder o recupere su contraseña si la ha olvidado.
			</div>
			
		  </div>
          <?php } else  if ($err=='7') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-danger bg-Danger" role="alert">
			   Su identidad no ha sido verificada aún.<br> Revise la bandeja de entrada de su correo electrónico  y haga clic en el enlace que aparece en el email que le hemos enviado.<br>
              En caso de que no aparezca en su bandeja principal , revise en la carpeta de "Correo no deseado".<br>
              Si no recibió el correo de confirmación <a href="confirmacion_email.php?id=<?php echo $id;?>&uniqueid=<?php echo $uniqueid;?>">haga click aqui para volver a enviarlo</a>.
			</div>
		 
		 </div>
          <?php } else  if ($err=='8') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-primary" role="alert">
			  No se ha podido enviar el email. 
			</div>
			
		  </div>
          
          <?php } ?>

          <p>Para soporte tecnico y asistencia contactanos a</p>
          <p>Email: info@pulpro.com</p>
          <p>Whatsapp: +56 9 4294 4264</p>
                
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