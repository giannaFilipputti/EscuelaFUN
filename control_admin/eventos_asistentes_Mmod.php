<? include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");

$sql = "SELECT * FROM com_eventos WHERE id=".$evento;
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
				remote: {
                    url: "users1.php",
                    type: "post",
                    data: {
                      userid: '<?php echo $id?>'
                    }
                 }
				//remote: "users1.php?id=<?php echo $id;?>"
			},
		 nombre: {
				required: true
			},
		  
		  ape1: {
				required: true
			},

	      acepta: {
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
             },
			 
			 acepta: {
				required: "<span class='rojo comen'>Requerido</span>",
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
        <?php $sql = "SELECT * FROM com_alumnos WHERE id = ". $id ." AND codusuario LIKE '%asistente%'";
          $result = mysql_query($sql);
		  if ($row = mysql_fetch_array($result)) {
		  
		  ?>
        <div class="box">
        <h2>Agregar usuario:</h2>
        <form method="POST" id="frm1" action="eventos_asistentes_Mmod1.php">
        <input type="hidden" name="evento" value="<?php echo $evento?>" />
        <input type="hidden" name="id" value="<?php echo $id?>" />
       
        <label><span>Nombre: </span>
          <input type="text" name="nombre" id="nombre" size="20" value="<?php echo $row['nombre']?>"></label>
   
          <br class="clearfloat" />
         <label><span>Apellido 1: </span>
          <input type="text" name="ape1" id="ape1" size="20" value="<?php echo $row['ape1']?>"></label>
          <br class="clearfloat" />
          <label><span>Apellido 2: </span>
          <input type="text" name="ape2" id="ape2" size="20" value="<?php echo $row['ape2']?>"></label>
          <br class="clearfloat" />
          <label><span>Email: </span>
          <input type="text" name="email" id="email" size="20" value="<?php echo $row['email']?>"> (el usuario usará este email para realizar el examen)</label>
          <br class="clearfloat" />
         
          <br class="clearfloat" />
           
              
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
      
        </form>
        </div>
        
        <?php } ?>
         
       
  
    <br /><br />
    	<!-- HASTA AQUI CONTENIDO --></div>
    	<br class="clearfloat" />
      <div id="footer">
        <? include("pie.php"); ?>
      <!-- end #footer --></div>
    <!-- end #container --></div>
    </body>
</html>
