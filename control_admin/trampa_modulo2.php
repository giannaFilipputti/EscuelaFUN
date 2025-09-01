<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once 'Spreadsheet/Excel/Writer.php';

include("../includes/conn.php");
include("auto.php");

include("../includes/extraer_variables.php");

$modulo = 2;



foreach ($_GET as $key => $value) 
{ 
  if ($key != 'pag') {
	  $listvar .=  $key."=".$value."&";
  }
  if ($key != 'orden' && $key != 'tiporden' && $key != 'pag') {
  $listvaro .=  $key."=".$value."&";
  }
  
}
if (empty($_GET['orden'])) {
	$orden = 'ape1';
	} else {
		if (empty($_GET['tiporden'])) {
	            $orden = $_GET['orden'];
	       } else {
	            $orden = $_GET['orden']." DESC";
	       }
	
	}
	
 //estos valores los recibo por GET
            if(isset($pag)){
               $RegistrosAEmpezar=($pag-1)*$RegistrosAMostrar;
               $PagAct=$pag;
              //echo "aqui vemos";
              //caso contrario los iniciamos
            }else{
               $RegistrosAEmpezar=0;
               $PagAct=1;
            } 
			
            
  
           $sql_men3 = "SELECT com_alumnos.*, com_alumnos_exam.id AS idexam, com_alumnos_exam.aprobado, com_alumnos_exam.estado, com_alumnos_exam.fecini, com_alumnos_exam.forzar_cierre  FROM com_alumnos INNER JOIN com_alumnos_exam ON com_alumnos.id = com_alumnos_exam.alumno  WHERE com_alumnos_exam.modulo = ".$modulo." AND com_alumnos_exam.fecini <= '2021-07-06 00:00:00'";
	
		   
		   
		   
		   
		   $sql_men31 = $sql_men3."";
		   
           $result_men3 = mysql_query($sql_men31,$link) or die("el error es porque44grt: ".mysql_error());
		   $NroRegistros=mysql_num_rows(mysql_query($sql_men3));
           $NroRegistrosc=mysql_num_rows(mysql_query($sql_men31));
 
		   
		   $cantproductos = $RegistrosAEmpezar + $RegistrosAMostrar ;
            if ($cantproductos > $NroRegistros) {
	          $cantproductos = $NroRegistros;
	         }
			 
			 $PagAnt=$PagAct-1;
			$PagSig=$PagAct+1;
			$PagUlt=$NroRegistros/$RegistrosAMostrar;

			//verificamos residuo para ver si llevará decimales
			$Res=$NroRegistros%$RegistrosAMostrar;
 
			if($Res>0)  $PagUlt=floor($PagUlt)+1;
$fila = 2;

while ($row_men3 = mysql_fetch_array($result_men3)) { 

    echo "Usuario: ".$row_men3['id']." - ".$row_men3['email']."<br>";

            $sql_men3cp = "SELECT fecha FROM com_alumnos_resp  WHERE id_exam_mod = ".$row_men3['idexam']." ORDER BY fecha LIMIT 1";		   
		    $cantresp=mysql_num_rows(mysql_query($sql_men3cp));
            $result_men3CP = mysql_query($sql_men3cp,$link) or die("el error es porque33grt: ".mysql_error());

            if ($row_men3['forzar_cierre'] == 1) {
                echo "se cerro por el plazo<br>";
                $sql_up = "UPDATE com_alumnos_modulo SET alumno = '0', alumno_ant = ".$row_men3['id']." WHERE modulo = ". $modulo ." AND alumno = ".$row_men3['id']."";
                $result_up = mysql_query($sql_up,$link);

                $sql_up1 = "UPDATE com_alumnos_exam SET alumno = '0', alumno_ant = ".$row_men3['id']." WHERE id = ".$row_men3['idexam']."";
                $result_up1 = mysql_query($sql_up1,$link);

            } else if ($row_men3['estado'] == 0 && $cantresp==0) {
                echo "esta abierto y no tiene respuestas<br>";
                $sql_up = "UPDATE com_alumnos_modulo SET alumno = '0', alumno_ant = ".$row_men3['id']." WHERE modulo = ". $modulo ." AND alumno = ".$row_men3['id']."";
                $result_up = mysql_query($sql_up,$link);

                $sql_up1 = "UPDATE com_alumnos_exam SET alumno = '0', alumno_ant = ".$row_men3['id']." WHERE id = ".$row_men3['idexam']."";
                $result_up1 = mysql_query($sql_up1,$link);

            } else if ($row_men3['estado'] == 0 && $cantresp>0) {
                echo "esta abierto y tiene respuestas<br>";
                $row_men3CP = mysql_fetch_array($result_men3CP);
                $fecha = $row_men3CP['fecha'];
                $sql_up1 = "UPDATE com_alumnos_exam SET fecin = '".$fecha."' WHERE id = ".$row_men3['idexam']."";
                $result_up1 = mysql_query($sql_up1,$link);

                $sql_up = "UPDATE com_alumnos_modulo SET fecin = '".$fecha."' WHERE modulo = ". $modulo ." AND alumno = ".$row_men3['id']."";
                $result_up = mysql_query($sql_up,$link);

          

            } else {
                echo "esta cerrado pero no fue forzozo el cierre y tiene respuestas<br>";
                $row_men3CP = mysql_fetch_array($result_men3CP);
                $fecha = $row_men3CP['fecha'];
                $sql_up = "UPDATE com_alumnos_modulo SET fecin = '".$fecha."' WHERE modulo = ". $modulo ." AND alumno = ".$row_men3['id']."";
                $result_up = mysql_query($sql_up,$link);

            } 
	
 




}
    

?>