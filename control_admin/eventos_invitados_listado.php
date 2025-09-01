<?php

    include_once ("../includes/conn.php");
	require_once("../includes/extraer_variables_seg.php");

    include_once ("auto.php");
    	
	
   
	
	
?> 

<h2>Usuarios Invitados <a href="eventos_invitaciones.php?id=<?php echo $id?>" onClick="return confirm('Estas seguro que quieres enviar un email de invitacion a todos los usuarios en este momento?');">(Enviar invitaciones a todos los usuarios ingresados como invitados)</a></h2>
          <?
          $sql1 = "SELECT * FROM com_invitados WHERE evento = ".$id." ORDER BY email";
          $result1 = mysql_query($sql1);
    ?>
    
        <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center">
        <tr>
        <td align="center" width="20%">Apellido</td>
        <td align="center" width="20%">Nombre</td>
        <td align="center" width="20%">Email</td>
        <td align="center" width="20%">Fecha Invitacion</td>
        <td align="center" width="20%">Delegado</td>
        </tr>
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
				 $check = 0;
				 }
			  } else {
				 $check = 0;
			  }
			 
		   ?>
                <tr>
        <td align="left"><?php echo $row1['apellido'];?></td>
        <td align="left"><?php echo $row1['nombre'];?></td>
        <td align="left"><?php echo $row1['email'];?><?php if ($check == 1) { ?><img src="body/activar.gif" /><?php } ?></td>
        <td align="left"><?php echo date("d-m-Y",strtotime($row1['fecin']));?><?php if ($row1['invitacion'] == 1) { ?><img src="body/activar.gif" /><?php } ?>
          <a href="eventos_invitacion.php?id=<?php echo $row1['id'];?>&evento=<?php echo $id?>"><img src="body/icono-email11.png" alt="Enviar Invitacion" title="Enviar Invitacion"/></a></td>
        <td align="left"><?php echo $row_del['nombre'] ?></td>
        
        </td>
       
         
      </tr>
                  <? } ?>
        </table>