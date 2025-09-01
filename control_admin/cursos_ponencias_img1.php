<?php
include_once("../includes/conn.php");

extract($_GET);
if (empty($id)) $id = 'no'; 

          $sql = "SELECT * FROM com_ponencias_destacados WHERE tipo='".$tipo."' AND curso = ".$curso." ORDER BY orden_".$tipo;
          //echo $sql;
          $result = mysql_query($sql,$link);
		  
		  
		   
		   
		  
    ?>
       
    <form action="cursos_ponencias_act_tiempo.php?id=<?php echo $curso?>&tipo=<?php echo $tipo?>" method="post">
    <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
   <table cellpadding="0" cellspacing="0" border="1" width="95%" align="center" id="table-6">
        <tr class="nodrop nodrag">
        <td width="5%" align="center">Orden</td>
        <td width="20%" align="center">Imagen</td>
        <td width="70%" align="center" class="img_ponencias">Notas</td>
        <td width="5%" align="center">Acciones</td>
      
        </tr>
        <?php 
		$contador = 1;
		while($row = mysql_fetch_array($result)) {
			
			$sql_1 = "SELECT * FROM com_ponencias_ima WHERE id=".$row['id_ima']." ORDER BY orden LIMIT 1";
            //echo $sql;
            $result_1 = mysql_query($sql_1,$link);
			$row_1 = mysql_fetch_array($result_1);
			
			
			$sql_pag = "SELECT id, titulo, capitulo FROM com_capitulo_contenidos WHERE id=".$row_1['ponencia']." LIMIT 1";
            //echo $sql;
            $result_pag = mysql_query($sql_pag,$link);
			$row_pag = mysql_fetch_array($result_pag);
			
			$sql_cap = "SELECT id, modulo FROM com_cursos_mod_cap WHERE id=".$row_pag['capitulo']." LIMIT 1";
            $result_cap = mysql_query($sql_cap);
            $row_cap = mysql_fetch_array($result_cap);


            $sql_mod = "SELECT id, titulo, curso, periodo FROM com_cursos_mod WHERE id=".$row_cap['modulo']." LIMIT 1";
            $result_mod = mysql_query($sql_mod);
             $row_mod = mysql_fetch_array($result_mod);
			
			
			
			$tiempo = '';
			
			
			?>
           <tr id="table6-row-<?=$row['id']?>">
          <td class="dragHandle">&nbsp;</td>
          
       <td align="center">
       <?php if (empty($row['video'])) { ?>
         <img border="0" class="img_ponencias" src="<?php echo $baseURL;?>uploads/ponencias/<?php echo $row_1['ponencia']?>/<?php echo $row_1['nombre']?>?id=<?=mt_rand(0,5)?>" width="350" /><br /><?php echo $row_1['nombre']?>
         <br />
         URL: <?php echo $row_1['id']?><br />
        
       <?php } else { ?>
       <iframe src="http://player.vimeo.com/video/<?php echo $row_1['video']?>?api=1" width="220" height="110" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
       <?php }  ?></td>
       <td class="img_ponencias">
       <?php echo $row_mod['titulo']?><br>
       <?php echo $row_mod['periodo']?><br>
       <?php echo $row_pag['titulo']?><br>
       Titulo: <input type="text" name="tit_<?php echo $row['id']?>" value="<?php echo $row['titulo']?>"><br>
       SubTitulo: <input type="text" name="stit_<?php echo $row['id']?>" value="<?php echo $row['subtitulo']?>"><br>
       Descripcion: <input type="text" name="desc_<?php echo $row['id']?>" value="<?php echo $row['descr']?>">
       
       
      

</td>
        <td align="center">
		       <a href="ponencias_up.php?id=<?php echo $row_1['ponencia'];?>">Ir a diapos</a>
                 <!--
                  <?php if ($tipo == 'destacado') {  ?>
                  <a href="cursos_ponencias_img_estado.php?id=<?php echo $row['id'];?>&ref=<?php echo $row_cur['id'];?>&tipo=destacado&st=0" title="Click para agregar a destacados"><img src="body/activa_1.gif"></a>
                  <?php } else { ?>
                
                  <a href="cursos_ponencias_img_estado.php?id=<?php echo $row['id'];?>&ref=<?php echo $row_cur['id'];?>&tipo=masreciente&st=0" title="Click para agregar a Mas Recientes"><img src="body/oferta.gif"></a>
                  <?php }  ?> -->
		  
		            </td>
        
       
        
      </tr>
        <?php $contador = $contador + 1;
		} ?>
        </table>
         <div id="AjaxResult"></div>
    <br /><br />
    <script type="text/javascript"> 
 <? include_once('script_ordenar_pon_dest.php');?>
 
 $("#monstar_img").click(function() {  
	
	if ($(this).attr('rel') == 'mostrar') {
		$("#monstar_img").attr("rel", "ocultar");
	   $(".img_ponencias").removeClass("oculto");
	   
	} else {
		$(".img_ponencias").addClass("oculto");
		$("#monstar_img").attr("rel", "mostrar");
	
	}
	
	}); 
 </script>
        <div style="text-align:right; padding:0 15px;"><input name="" type="submit" /></div>
        </form>
      
    <br /><br />