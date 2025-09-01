<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");
include("auto_n3.php");

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
				remote: "users_ponentes.php"
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
        <h1>Agregar ponentes a reunión</h1>
        
        <div class="box">
        <h2>Agregar ponente</h2>
        <form method="POST" action="eventos_ponentes_add.php" id="frm1">
        <input type="hidden" name="evento" value="<?php echo $id?>" />
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20"></label>
         <label><span>Apellido 1: </span>
          <input type="text" name="ape1" size="20"></label>
          <label><span>Apellido 2: </span>
          <input type="text" name="ape2" size="20"></label>
          <label><span>Email: </span>
          <input type="text" name="email" size="20"></label>
           
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
        </div>
         
       
        
    <br /><br />
       <div id="listado">
       <?php if ($err == 1) { ?>
         <div class="verde">Invitación enviada correctamente</div>
       <?php } ?>
      
          <?
          $sql1 = "SELECT * FROM com_alumnos_eventos WHERE evento = ".$id." AND tipo= 'Ponente'";
		  //echo $sql1;
          $result1 = mysql_query($sql1);
         ?>
    
        <table>
        <thead>
        <tr>
        <td width="30%">Nombre</td>
        <td width="30%">Email</td>
        <td width="20%">Acciones</td>
        <td width="20%">invitacion</td>
        </tr>
        </thead>
        <? while ($row1 = mysql_fetch_array($result1)) {
			
			$sql_pon = "SELECT * FROM com_alumnos WHERE id = ".$row1['alumno'];
            $result_pon = mysql_query($sql_pon);
		    $row_pon = mysql_fetch_array($result_pon);
			
			
			 
		   ?>
                <tr>
        <td align="left"><?php echo $row_pon['nombre']." ".$row_pon['ape1']." ".$row_pon['ape2'];?></td>
        <td align="left"><?php echo $row_pon['email'];?></td>
        <td align="left">
          <a href="eventos_ponentes_elim.php?id=<?php echo $row1['id'];?>&evento=<?php echo $id?>" onClick="return confirm('Esta seguro de borrar este ponente?');"><img src="body/elim.png" alt="Eliminar Ponente" title="Eliminar Ponentes"/></a></td>
        
        </td>
        <td><a href="eventos_ponentes_invitacion.php?id=<?php echo $row1['id'];?>&evento=<?php echo $id?>" onClick="return confirm('Esta a punto de reenviar la invitacion a este ponente. Desea continuar?');""><img src="body/icono-email11.png" alt="Reenviar Invitacion" title="Reenviar Invitacion"/></a></td>
       
         
      </tr>
                  <? } ?>
        </table>
        
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
