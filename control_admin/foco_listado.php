<script src="js/jquery.tablednd.js" type="text/javascript"></script>

<?php



include_once("../includes/conn.php");

include_once("../includes/extraer_variables.php");

          $sql_1 = "SELECT * FROM com_foco WHERE curso = ". $id ." ORDER BY nombre";
          $result_1 = mysql_query($sql_1);
    ?>
    <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
        <td width="15%" align="center">Orden</td>
        <td width="45%" align="center">Nombre</td>
        <td width="15%" align="center">Congreso</td>
        <td width="25%" align="center">Link</td>
        <td width="25%" align="center">Acciones</td>
        
        </tr>
        <?php while ($row_1 = mysql_fetch_array($result_1)) { 
		//$descr = strip_tags($row['fra']);
		
		?>
        <tr id="table6-row-<?=$row['id']?>">
          <td class="dragHandle">&nbsp;</td>
          <td align="center"><?php echo $row_1['nombre']?></td>
          <td align="center"><?php echo $row_1['congreso']?></td>
          <td><a href="../foco/<?php echo $row_1['archivo']?>"><img src="body/<?php echo mostrarExtension (end( explode('.', $row_1['archivo']) ))?>"></a></td>
          <td align="center">
              
              <a href="foco_elim.php?id=<?php echo $row_1['id'];?>&ref=<?php echo $id?>" onClick="return confirm('Seguro de eliminar este contenido?');"><img border="0" alt="Eliminar" title="Eliminar" src="body/elim.gif"></a><br>
              <a href="foco_texto.php?id=<?php echo $row_1['id'];?>&ref=<?php echo $id?>">Contenido para buscador</a>
              
              
          </td>
         
        
       
        
      </tr>
      <?php } ?>
        </table>
        <div id="AjaxResult"></div>
    <br /><br />
    </div>
    <script type="text/javascript"> 
 <? // include_once('script_ordenar_comi.php');?>
 </script>