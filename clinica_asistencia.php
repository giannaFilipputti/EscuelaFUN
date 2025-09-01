<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';
$page = "registro";
$scripts = "none";

$curs = new Presenciales();
$cursos = $curs->getOne($clinica);

$profes = $curs->getDocentes($clinica);



$cap = new Capitulo();
if ($authj->logueado == 1) {
    $getPrecio = Alumno::getPrecio($authj->rowff['tipouser'], $authj->rowff['pais']);
    $inscrito = Presenciales::getInscritoCurso($id, $authj->rowff['id']);
}



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
                    <p class="my-0">Sistema de registro de asistencia a:<br> <strong><?php echo $cursos[0]['titulo'] ?></strong>.</p>
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
          <?php } else  if ($err=='1') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-danger bg-Danger" role="alert">
			  Email no está registrado, verifique su dirección de email o <a href="registro.php">regístrese</a> .
			</div>			
		  </div>
		  <?php } else  if ($err=='2') { ?>
          <div class="col-md-12 paddsup">
			<div class="alert alert-danger bg-Danger" role="alert">
			  Contraseña incorrecta.
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
                <form method="POST" action="clinica_asistencia_action.php">
                    <input type="hidden" name="curso" value="<?php echo $curso;?>">
                    <input type="hidden" name="clinica" value="<?php echo $clinica;?>">

                    <div id="div_rut">
                            <span class="icon text-gray-600">Rut</span>
                            <div class="form-group">
                                <input type="text" class="form-control" oninput="checkRut(this)" maxlength="10" name="rut_alumno" id="rut_alumno" required="required">
                            </div> 
                        </div>
                        <span class="icon text-gray-600">Email</span>

                        <div class="form-group">
                            <input type="email" class="form-control"name="email_alumno" id="email_alumno" required="required">
                        </div>


                        <div>                      
                      
                            <button type="submit"  class="uk-width-1-1 transition-3d-hover btn btn-success">Registrar asistencia</a>
                
                        </div>

                    

                  

                    <div class="uk-flex-middle uk-grid-small" uk-grid>
                      
                       
                    </div>

                </form>
                <br><br>

                
            </div>


        </div>

    </div>

        <!-- footer
        ================================================== -->
        <?php include('footer.php'); ?>

    </div>

    <?php include('cierre.php'); ?>

    <script type="text/javascript">
  
    function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');

    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();

    // Formatear RUN
    rut.value = cuerpo + '-'+ dv

    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}

    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;

    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {

        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }

    }

    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);

    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;

    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }

    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');

}

</script>

</body>

</html>