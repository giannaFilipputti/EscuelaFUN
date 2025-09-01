<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

$sql = "SELECT * FROM com_eventos WHERE id=".$id;
          $result = mysql_query($sql);
		  $row = mysql_fetch_array($result);
		  
		  $tags = explode('*',$row['delegados']);
		  $idm = '';

          foreach($tags as $key) {
			if (!empty($key)) {
			 if (!empty($idm)) {
				 $idm .= ', ';
				 }    
             $idm .= '"'.$key.'"';  
			}
           }
		  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts.php");?>
<script src="js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/uploadifive.css">
<script language="javascript">
$(document).ready(function(){
		
		$("#frm1").validate({
		rules: {
			
          email: {
				required: true,
				email: true,
				remote: "users.php"
			},
		 nombre: {
				required: true
			},
		  
		  ape1: {
				required: true
			}
		    
		},
		messages: {
			
			email: {
				required: "Ingrese un email",
                 email: "Direccion de email invalida",
				 remote: "Email ya registrado",
             },
			 nombre: {
				required: "<br><span class='rojo comen'>Requerido</span>",
             },
			 ape1: {
				required: "<br><span class='rojo comen'>Requerido</span>",
             }
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});
});
</script>
</head>

<body class="twoColLiqLtHdr">

    <div id="container"> 
      <div id="header">
        <? include("cabeza.php");?>
      <!-- end #header --></div>
      <div id="sidebar1">
        <? include("menu.php");?>
      <!-- end #sidebar1 --></div>
      <div id="mainContent">
      <div id="submenu"><!-- DESDE AQUI SUBMENU -->
      <!-- HASTA AQUI SUBMENU --></div>
      <!-- DESDE AQUI CONTENIDO -->
        <h1>Invitados a la reunión: <?php echo $row['lugar']." - ".$row['ciudad']?></h1>
        
        <div class="box">
        <h2>Agregar usuario:</h2>
        <form method="POST" id="frm1" action="eventos_asistentes_Madd1.php">
        <input type="hidden" name="evento" value="<?php echo $id?>" />
       
        <label><span>Nombre: </span>
          <input type="text" name="nombre" id="nombre" size="20"></label>
   
          <br class="clearfloat" />
         <label><span>Apellido 1: </span>
          <input type="text" name="ape1" id="ape1" size="20"></label>
          <br class="clearfloat" />
          <label><span>Apellido 2: </span>
          <input type="text" name="ape2" id="ape2" size="20"></label>
          <br class="clearfloat" />
          <label><span>Email: </span>
          <input type="text" name="email" id="email" size="20"> (el usuario usará este email para realizar el examen)</label>
          <br class="clearfloat" />
          
            
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
       <!--<div class="legal"><strong>Condiciones Legales:</strong> MEDIANTE la cumplimentación de este formulario, consientes de modo expreso la incorporación y tratamiento de tus datos en fichero automatizado de Laboratorios del Dr. Esteve, S.A. cuya finalidad es la gestión de acceso al Website y/o informarte sobre cuestiones relacionadas con ESTEVE y/o sus productos, así como sobre temas de ámbito científico, profesional, sanitario y/o farmacéutico que entendemos puedan resultar de tu interés. <br /><br />

Dado que la organización del grupo ESTEVE está basada en áreas funcionales, asimismo consientes de forma expresa la comunicación de tus datos entre las distintas empresas que lo conforman, con la finalidad antes mencionada. 
<br /><br />
PODRÁS ejercer los derechos de acceso, rectificación, cancelación y oposición, en los términos establecidos en la legislación vigente, comunicándolo por escrito a Laboratorios del Dr. Esteve (Atn. LEGAL), Avda. Mare de Déu de Montserrat, 221 - 08041 Barcelona (España)
</div> -->
        </form>
        </div>
         
       
  
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
