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
        <h1>Invitados a reunión</h1>
        
        <div class="box">
        <h2>Invitar usuario</h2>
        <form method="POST" action="eventos_invitados_add.php">
        <input type="hidden" name="evento" value="<?php echo $id?>" />
        <label><span>Nombre: </span>
          <input type="text" name="nombre" size="20"></label>
          <label><span>Apellido: </span>
          <input type="text" name="apellido" size="20"></label>
          <label><span>Email: </span>
          <input type="text" name="email" size="20"></label>
           <label><span>Delegado: </span>
          <select name="delegado">
          <?
          $sql_p = "SELECT * FROM com_users WHERE  id IN (".$idm.") ORDER BY nombre";
          $result_p = mysql_query($sql_p);
		  while ($row_p = mysql_fetch_array($result_p)) {
    ?>
            <option value="<?php echo $row_p['id']?>"><?php echo $row_p['nombre']?></option>
            <?php } ?>
          </select></label>      
        
       
       <div class="spacer"><input type="submit" value="Enviar" name="B1" /></div>
        </form>
        </div>
         
         <div class="box">
         <div class="der"><a href="emails_cvs_down.php">Descargar archivos CVS de ejemplo</a></div>
        <h2>Subir invitados de forma masiva</h2>
        
        <div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
		<div id="imagenes"></div>
        
        <script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadifive({
				'auto'             : true,
				'multi'            : false,
				'formData'  : {'evento':<?=$id?>},
				'buttonText'  : 'Seleccione archivo csv',
				'width'  : 200,
				'uploadScript'     : 'upload_csv.php',
	            'onAddQueueItem' : function(file){
                    var fileName = file.name;
                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                    switch (ext) {
                     case 'csv':
                      //alert('filetype ok');
                     break;
                     default:
                     alert('Solo puedes agregar archivos con extension .csv');
                     $('#file_upload').uploadifive('cancel', file);
                     break;
                    }
                  }
                ,
				'onUploadComplete' : function(file, data) { console.log(data); 
				
				      $("#imagenes").html(data); 
					  
	                  $('#file_upload').uploadifive('clearQueue');
				      $.post("eventos_invitados_listado.php?id=<?=$id?>",   function(data1){            
       /// Ponemos la respuesta de nuestro script en el párrafo recargado  
                         $("#listado").html(data1);      }); 
	  //alert("Successfully uploaded: "+response);
   
				
				}
				/*'onQueueComplete' : function(event,data) {
		
                      $.post("contenidos_imagen.php?clave=<?=$receta_clave?>",   function(data1){            
        
                      $("#imagenes").html(data1);   
	                  $('#img_upload').uploadifive('clearQueue');
	     }); 
    }*/
			});
			
		});
	</script>
    
    
    
    
        
        
        </div>
        
    <br /><br />
       <div id="listado">
    
        <h2>Usuarios invitados <?php if ($rowff['nivel'] >= 3) { ?><a href="eventos_invitaciones.php?id=<?php echo $id?>" onClick="return confirm('Estas seguro que quieres enviar un email de invitacion a todos los usuarios en este momento?');">(Enviar invitaciones a todos los usuarios agregados como invitados)</a><?php } ?></h2>
        <?php if ($rowff['nivel'] >= 3) { ?><div class="der"><a href="eventos_invitados_elim.php?id=<?php echo $id;?>" onClick="return confirm('Esta seguro de borrar todos los invitados?');">Eliminar todos los invitados</a></div><?php } ?>
          <?
          $sql1 = "SELECT * FROM com_invitados WHERE evento = ".$id." ORDER BY apellido";
          $result1 = mysql_query($sql1);
    ?>
    
        <table>
        <thead>
        <tr>
        <td align="center">Apellido</td>
        <td align="center">Nombre</td>
        <td align="center">Email</td>
        <td align="center">Fecha Invitacion</td>
        <td align="center">Delegado</td>
        </tr>
        </thead>
        <? while ($row1 = mysql_fetch_array($result1)) {
			
			$sql_del = "SELECT * FROM com_users WHERE id = ".$row1['delegado'];
          $result_del = mysql_query($sql_del);
		  $row_del = mysql_fetch_array($result_del);
			
			 $sql_u = "SELECT * FROM com_alumnos WHERE email ='".$row1['email']."'";
		
             $result_u = mysql_query($sql_u);
		     if ($row_u = mysql_fetch_array($result_u)) {
				 
				  $sql_u1 = "SELECT * FROM com_alumnos_eventos WHERE alumno =".$row_u['id']."  AND evento = ".$id;
                  $result_u1 = mysql_query($sql_u1);
		          if ($row_u1 = mysql_fetch_array($result_u1)) {
				      $check = 1;
			      } else {
				     $check = 2;
					 $sql_u1e = "SELECT * FROM com_alumnos_eventos WHERE alumno =".$row_u['id']."";
					 //echo $sql_u1e;
                     $result_u1e = mysql_query($sql_u1e);
		             if ($row_u1e = mysql_fetch_array($result_u1e)) {
					   $id_us_ev = $row_u1e['evento'];
				     } else {
						$id_us_ev = 0;
					 }
				 }
			  } else {
				 $check = 0;
			  }
			 
		   ?>
                <tr>
        <td align="left"><?php echo fMayuscula($row1['apellido']);?></td>
        <td align="left"><?php echo fMayuscula($row1['nombre']);?></td>
        <td align="left"><?php echo $row1['email'];?>
		<?php if ($check == 1) { ?><img src="body/activar.png" /><?php }
		 else if ($check == 2) { 
		    if ($rowff['nivel'] >= 3) { ?>
               <a href="usuarios_eventos.php?evento=<?php echo $id_us_ev;?>&alumno=<?php echo $row_u['id'];?>"><img src="body/activar2.png" /></a>
             <?php } else  { ?>
                <img src="body/activar2.png" />
             <?php }  ?>
            
		 <?php } ?>
         </td>
        <td align="left"><?php echo date("d-m-Y",strtotime($row1['fecin']));?><?php if ($row1['invitacion'] == 1) { ?><img src="body/activar.png" /><?php } ?>
        <?php if ($rowff['nivel'] >= 3) { ?>
        
          <a href="eventos_invitacion.php?id=<?php echo $row1['id'];?>&evento=<?php echo $id?>"><img src="body/icono-email11.png" alt="Enviar Invitacion" title="Enviar Invitacion"/></a>
          <?php } ?>
          </td>
        <td align="left"><?php echo $row_del['nombre'] ?></td>
        
        </td>
       
         
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
