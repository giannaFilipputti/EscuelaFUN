<?php include("../includes/conn.php");
require_once("../includes/extraer_variables_seg.php");
include ("auto.php");
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */
 
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("TBA")
							 ->setLastModifiedBy("TBA")
							 ->setTitle("Estadisticas Reuniones Practica y Clinica")
							 ->setSubject("Estadisticas Reuniones Practica y Clinica")
							 ->setDescription("Estadisticas Reuniones Practica y Clinica.")
							 ->setKeywords("")
							 ->setCategory("");

$colArray = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

$objPHPExcel->getActiveSheet()->setTitle('Estadisticas Completas');

$objPHPExcel->createSheet(1);
// Miscellaneous glyphs, UTF-8
/*$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');*/

// Rename worksheet
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setTitle('Resumen');

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Estadisticas Completas');


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'DIRECTOR TERRITORIO (DT)')
            ->setCellValue('B1', 'TOTAL REUNIONES POR DT')
            ->setCellValue('C1', 'TOTAL ASISTENTES POR DT')
            ->setCellValue('D1', 'TOTAL EXAMINADOS POR DT')
			->setCellValue('E1', 'GERENTE (GT)')
			->setCellValue('F1', 'TOTAL REUNIONES POR GERENTE')
			->setCellValue('G1', 'TOTAL ASISTENTES POR GERENTE')
			->setCellValue('H1', 'TOTAL EXAMINADOS POR GERENTE')
			->setCellValue('I1', 'DELEGADO (DVM)')
			->setCellValue('J1', 'TOTAL REUNIONES POR DELEGADO')
			->setCellValue('K1', 'REUNION')
			->setCellValue('L1', 'TOTAL DE ASISTENTES REUNIÓN')
			->setCellValue('M1', 'TOTAL EXAMINADOS POR REUNIÓN')
			->setCellValue('N1', 'EXAMINADOS CASO 1')
			->setCellValue('O1', 'APROBADOS')
			->setCellValue('P1', 'SUSPENDIDOS')
			->setCellValue('Q1', 'EXAMINADOS CASO 2')
			->setCellValue('R1', 'APROBADOS')
			->setCellValue('S1', 'SUSPENDIDOS')
			->setCellValue('T1', 'EXAMINADOS CASO 3')
			->setCellValue('U1', 'APROBADOS')
			->setCellValue('V1', 'SUSPENDIDOS')
			->setCellValue('W1', 'EXAMINADOS CASO 4')
			->setCellValue('X1', 'APROBADOS')
			->setCellValue('Y1', 'SUSPENDIDOS');

            
			$dir_act = 0;
           	$fila_dir = 2;
            $sql = "SELECT id, nombre FROM com_directores ORDER BY id";
            $result = mysql_query($sql);
		  
		   while ($row = mysql_fetch_array($result)) {
			   echo "Director: ".$row['nombre']. " - ".$row['id']. " - ".$dir_act;
			   if ($row['id'] != $dir_act) {
				   $objPHPExcel->setActiveSheetIndex(0)
					    ->setCellValue('A'.$fila_dir, $row['nombre']);
						
						//echo "Director: ".$row['nombre'];
				   } 
		      $sqlg = "SELECT id, nombre FROM com_gerentes WHERE director = ".$row['id']. " ORDER BY id";
              $resultg = mysql_query($sqlg);
			  $fila_ger = $fila_dir;
			  $cont_eveD = 0;
			  $cont_asis_dir = 0;
			  $cont_exa_dir = 0;
			  	
			   while ($rowg = mysql_fetch_array($resultg)) {
				   if ($rowg['id'] != $ger_act) {
				      $objPHPExcel->setActiveSheetIndex(0)
					    ->setCellValue('E'.$fila_ger, $rowg['nombre']);
				   } 
				   $fila_del = $fila_ger;
				   $cont_eveG = 0;
				   $cont_asis_ger = 0;
				   $cont_exa_ger = 0;
				    $sqlu = "SELECT id, nombre FROM com_users WHERE gerente = ".$rowg['id']. " ORDER BY id";
                    $resultu = mysql_query($sqlu);
				
			        while ($rowu = mysql_fetch_array($resultu)) {
					  if ($rowu['id'] != $del_act) {
				       $objPHPExcel->setActiveSheetIndex(0)
					    ->setCellValue('I'.$fila_del, $rowu['nombre']);
					  }
					    $fila_eve = $fila_del;
						$cont_eve = 0;
					    $sqle = "SELECT id, lugar FROM com_eventos WHERE delegados LIKE '%*".$rowu['id']."*%' ORDER BY fecha";
                        $resulte = mysql_query($sqle);
			            while ($rowe = mysql_fetch_array($resulte)) {
							
							$var = "eve_".$rowe['id'];
							$cont_eve = $cont_eve + 1;
							    $cont_eveG = $cont_eveG + 1;
							    $cont_eveD = $cont_eveD + 1;
							if (empty($$var)) {
							 $$var = $rowu['nombre'];
							 $objPHPExcel->setActiveSheetIndex(0)
					         ->setCellValue('K'.$fila_eve, $rowe['lugar']);
							 // aqui todo el detalle del evento
							 $sql1 = "select com_alumnos.id, com_alumnos_eventos.tipo AS tipoz  from com_alumnos inner join com_alumnos_eventos on com_alumnos.id = com_alumnos_eventos.alumno WHERE com_alumnos_eventos.evento = ".$rowe['id']. " ORDER BY com_alumnos.ape1";
							 $NroRegistros=mysql_num_rows(mysql_query($sql1));
							 
							 $cont_asis_ger = $cont_asis_ger + $NroRegistros;
							 $cont_asis_dir = $cont_asis_dir + $NroRegistros;
							 
							 $objPHPExcel->setActiveSheetIndex(0)
					         ->setCellValue('L'.$fila_eve, $NroRegistros);
							 
							 $sql1e = "select DISTINCT alumno from com_alumnos_exam WHERE evento = ".$rowe['id']. " AND estado = 1";
							 $NroRegistrose=mysql_num_rows(mysql_query($sql1e));
							 
							 $cont_exa_ger = $cont_exa_ger + $NroRegistrose;
							 $cont_exa_dir = $cont_exa_dir + $NroRegistrose;
							 
							 $objPHPExcel->setActiveSheetIndex(0)
					         ->setCellValue('M'.$fila_eve, $NroRegistrose);
							 
							 // CASO 1
							 $sql_mod = "SELECT * FROM com_cursos_mod WHERE prueba = 0 ORDER BY orden";
                             $result_mod = mysql_query($sql_mod);
							 $noCol = 13;
							 while ($row_mod = mysql_fetch_array($result_mod)) { 
							 
							   $sql1e = "select DISTINCT alumno from com_alumnos_exam WHERE evento = ".$rowe['id']. " AND estado = 1 AND modulo = ".$row_mod['id'];
							   $NroRegistrose=mysql_num_rows(mysql_query($sql1e));
							 
							   $objPHPExcel->setActiveSheetIndex(0)
					           ->setCellValue($colArray[$noCol].$fila_eve, $NroRegistrose);
							   
							   $noCol= $noCol + 1;
							 
							   $sql1e = "select DISTINCT alumno from com_alumnos_exam WHERE evento = ".$rowe['id']. " AND estado = 1 AND modulo = ".$row_mod['id']." AND aprobado = 1";
							   $NroRegistrose=mysql_num_rows(mysql_query($sql1e));
							 
							   $objPHPExcel->setActiveSheetIndex(0)
					           ->setCellValue($colArray[$noCol].$fila_eve, $NroRegistrose);
							 
							   $noCol= $noCol + 1;
							   
							   $sql1e = "select DISTINCT alumno from com_alumnos_exam WHERE evento = ".$rowe['id']. " AND estado = 1 AND modulo = ".$row_mod['id']." AND aprobado = 0";
							   $NroRegistrose=mysql_num_rows(mysql_query($sql1e));
							 
							   $objPHPExcel->setActiveSheetIndex(0)
					           ->setCellValue($colArray[$noCol].$fila_eve, $NroRegistrose);
							   
							   $noCol= $noCol + 1;
							 
							 }
							 // termina todo el detalle del evento
							} else {
							$objPHPExcel->setActiveSheetIndex(0)
					         ->setCellValue('K'.$fila_eve, 'Conjunta con: '.$$var);
							}
							 
							 $fila_eve = $fila_eve + 1;
						     $eve_act = $rowe['id'];
						}
						 
						 $objPHPExcel->setActiveSheetIndex(0)
					         ->setCellValue('J'.$fila_del, $cont_eve);
						
						$fila_del = $fila_eve;
						$del_act = $rowu['id'];
						//echo $rowu['nombre'];
			        }
					$objPHPExcel->setActiveSheetIndex(0)
					 ->setCellValue('F'.$fila_ger, $cont_eveG);
					 
					 $objPHPExcel->setActiveSheetIndex(0)
					 ->setCellValue('G'.$fila_ger, $cont_asis_ger);
					 
					 $objPHPExcel->setActiveSheetIndex(0)
					 ->setCellValue('H'.$fila_ger, $cont_exa_ger);
					 
				   $fila_ger = $fila_del;
				   $ger_act = $rowg['id'];
			   }
			   $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$fila_dir, $cont_eveD);
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C'.$fila_dir, $cont_asis_dir);
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('D'.$fila_dir, $cont_exa_dir);
			   $fila_dir = $fila_ger;
		    $dir_act = $row['id'];
		   }




// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

/*

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

*/

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
/*$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;*/


