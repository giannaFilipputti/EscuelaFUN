<? include("../includes/conn.php");

include("auto.php");
extract($_GET);


$sql_cur = "SELECT id, titulo FROM com_cursos WHERE id=".$curso." LIMIT 1";
$result_cur = mysql_query($sql_cur);
$row_cur = mysql_fetch_array($result_cur);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$apptitle?></title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<? include("scripts1.php");?>


    
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
     
      <!-- DESDE AQUI CONTENIDO -->
        <h1> Ponencias destacadas por curso: <?php echo $row_cur['titulo']?></h1>
       
        
        
        
        
        
        
        <div id="imagenes1">
       
		
		    <? include('cursos_ponencias_img1.php') ;?>
       
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
