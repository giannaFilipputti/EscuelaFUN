<script src="js/jquery.tablednd.js" type="text/javascript"></script>

<?php

require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$capitulo = new Capitulo();
$capitulo->getCapDown($id);
 
    ?>
    <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
        <td width="15%" align="center">Orden</td>
        <td width="45%" align="center">Nombre</td>
        <td width="10%" align="center">Ubicacion</td>
        <td width="10%" align="center">Link</td>
        <td width="20%" align="center">Acciones</td>
      
        </tr>
        <?php 
        
        if (!empty($capitulo->row)) {
            foreach ($capitulo->row as $Elem) {
		//$descr = strip_tags($row['fra']);
		
		?>
        <tr id="table6-row-<?=$Elem['id']?>">
          <td class="dragHandle">&nbsp;</td>
          <td align="center"><?php echo $Elem['nombre']?></td>
          <td align="center"><?php echo $Elem['ubicacion']?></td>
          <td><a href="../cap_down/<?php echo $Elem['contenido']?>">Descarga</a><br>
          <a href="capitulos_cap_down_texto.php?id=<?=$Elem['id'];?>&ref=<?php echo $id?>">Texto para busquedas</a>
          </td>
          <td align="center">
              
              <a href="capitulos_cap_down_elim.php?id=<?php echo $Elem['id'];?>&ref=<?php echo $id?>" onClick="return confirm('Seguro de eliminar este contenido?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a>
               <?php if ($Elem['estado'] == 0) { ?>
                    <a href="capitulos_cap_down_estado.php?st=1&id=<?=$Elem['id'];?>&ref=<?php echo $id?>"><img border="0" src="body/suspender.gif" title="Click para Activar"></a>&nbsp;
                    <?php } else { ?>
                    <a href="capitulos_cap_down_estado.php?st=0&id=<?=$Elem['id'];?>&ref=<?php echo $id?>"><img border="0" src="body/activar.gif" title="Click para Suspender"></a>&nbsp;
                    <?php } ?>
              
          </td>
          
        
       
        
      </tr>
      <?php } 
      }?>
        </table>
        <div id="AjaxResult"></div>
    <br /><br />
    </div>
    <script type="text/javascript"> 
 <?php  include_once('script_ordenar_capi_down.php');?>
 </script>