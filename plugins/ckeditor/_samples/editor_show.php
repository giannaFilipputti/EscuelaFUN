<? include('conn.php'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?
echo "texto:<br>"; 
if(isset($_POST['txtiarea1'])){ 
 
$categoria = utf8_encode($_POST["txtiarea1"]); 
//$result = mysql_query ("INSERT INTO com_categorias (categoria) VALUES ('".$categoria."')",$link) or die("el error es en el insert: ".mysql_error());
 
echo $_POST["txtiarea1"];
echo "<br>";
echo $_POST["txtiarea2"]; 
}else{ 
    echo "no ha llegado el texto"; 
}  
?>
</body>
</html>