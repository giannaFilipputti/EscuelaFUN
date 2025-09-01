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
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
date_default_timezone_set('Europe/London');

const BORDER_NONE = 'none';
const BORDER_DASHDOT = 'dashDot';
const BORDER_DASHDOTDOT = 'dashDotDot';
const BORDER_DASHED = 'dashed';
const BORDER_DOTTED = 'dotted';
const BORDER_DOUBLE = 'double';
const BORDER_HAIR = 'hair';
const BORDER_MEDIUM = 'medium';
const BORDER_MEDIUMDASHDOT = 'mediumDashDot';
const BORDER_MEDIUMDASHDOTDOT = 'mediumDashDotDot';
const BORDER_MEDIUMDASHED = 'mediumDashed';
const BORDER_SLANTDASHDOT = 'slantDashDot';
const BORDER_THICK = 'thick';
const BORDER_THIN = 'thin';



 




$color_dir1 = "85A8C8";
$color_dir2 = "A9D08E";

$color_dir1_ger1 = "DDEBF7";
$color_dir1_ger2 = "9BC2E6";
$color_dir2_ger1 = "E2EFDA";
$color_dir2_ger2 = "C6E0B4";


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


$styleArrayTOP = array(
                                            'borders' => array(
                                              'top' => array(
                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                               )
                                             )
                                         );
								$styleArrayBOTTOM = array(
                                            'borders' => array(
                                              
											   'bottom' => array(
                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                               )
                                             )
                                         );
								$styleArrayRIGHT = array(
                                            'borders' => array(
                                              
											   'right' => array(
                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                               )
                                             )
                                         );
								
								$styleArrayLEFT = array(
                                            'borders' => array(
                                              
											   'left' => array(
                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                               )
                                             )
                                         );
								$styleArrayALL = array(
                                            'borders' => array(
                                              
											   'allborders' => array(
                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                               )
                                             )
                                         );

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

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(22);


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
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '548235')));
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'E2EFDA')));
			
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			$objPHPExcel->getActiveSheet()->getStyle('E1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'A9D08E')));
			
			$objPHPExcel->getActiveSheet()->getStyle('F1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'E2EFDA')));
			
			$objPHPExcel->getActiveSheet()->getStyle('G1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('H1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			$objPHPExcel->getActiveSheet()->getStyle('I1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '7DC1FF')));
			$objPHPExcel->getActiveSheet()->getStyle('J1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '9BC2E6')));
			$objPHPExcel->getActiveSheet()->getStyle('K1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '9BC2E6')));
			$objPHPExcel->getActiveSheet()->getStyle('L1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'BDD7EE')));
			$objPHPExcel->getActiveSheet()->getStyle('M1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'DDEBF7')));
			
			$objPHPExcel->getActiveSheet()->getStyle('N1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'F4B084')));
			$objPHPExcel->getActiveSheet()->getStyle('O1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('P1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			$objPHPExcel->getActiveSheet()->getStyle('Q1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'F4B084')));
			$objPHPExcel->getActiveSheet()->getStyle('R1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('S1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			$objPHPExcel->getActiveSheet()->getStyle('T1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'F4B084')));
			$objPHPExcel->getActiveSheet()->getStyle('U1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('V1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			$objPHPExcel->getActiveSheet()->getStyle('W1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'F4B084')));
			$objPHPExcel->getActiveSheet()->getStyle('X1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('Y1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			


$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'GERENTE (DT)')
            ->setCellValue('B1', 'TOTAL REUNIONES')
            ->setCellValue('C1', 'TOTAL ASISTENTES')
            ->setCellValue('D1', 'TOTAL EXAMINADOS');
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'A9D08E')));
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'E2EFDA')));
			
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCE4D6')));
			
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:Y1')->applyFromArray($styleArrayALL);
            
			
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(22);
$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('B')->setWidth(22);
$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('C')->setWidth(22);
$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('D')->setWidth(22);


			$dir_act = 0;
           	$fila_dir = 2;
			$RSM_fila_ger = 2;
			$conta_dir = 1;
			$conta_ger = 1;
			
			
			$Tcont_eveD = 0;
			$Tcont_asis_dir = 0;
			$Tcont_exa_dir = 0;

            $sql = "SELECT id, nombre FROM com_directores ORDER BY id";
            $result = mysql_query($sql);
		  
		   while ($row = mysql_fetch_array($result)) {
			  // echo "Director: ".$row['nombre']. " - ".$row['id']. " - ".$dir_act;
			   if ($row['id'] != $dir_act) {
				   $objPHPExcel->setActiveSheetIndex(0)
					    ->setCellValue('A'.$fila_dir, $row['nombre']);
						
						//echo 'el rango de borde de directores: A'.$fila_dir.':D'.$fila_dir;
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$fila_dir.':D'.$fila_dir)->applyFromArray($styleArrayTOP);
						
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
						
						//echo "<br>".$rowg['nombre']."<br>";
						
						
				     $objPHPExcel->setActiveSheetIndex(1)
					    ->setCellValue('A'.$RSM_fila_ger, $rowg['nombre']);
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
						
						//echo $rowu['nombre']."<br>";
					  }
					    $fila_eve = $fila_del;
						$cont_eve = 0;
					    $sqle = "SELECT id, lugar FROM com_eventos WHERE delegados LIKE '%*".$rowu['id']."*%' ORDER BY fecha";
                        $resulte = mysql_query($sqle);
						if (mysql_num_rows(mysql_query($sqle)) == 0) {
							// BORRAR ESTA LINEA SI NO ES NECESARIO MOSTRAR LOS DELEGADOS QUE NO TIENEN EVENTOS
							$fila_eve = $fila_eve + 1;
							}
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
							 
							 
							
							  
										 
										// echo 'Las filas del borde: I'.$fila_del.':Y'.$fila_eve."<br>";
										//echo 'aplicamos el TOP: I'.$fila_del.':Y'.$fila_del.'<br>';
										 $objPHPExcel->getActiveSheet()->getStyle('I'.$fila_del.':Y'.$fila_del)->applyFromArray($styleArrayTOP);
                                         //unset($styleArrayTOP);
										 
										 
										// $objPHPExcel->getActiveSheet()->getStyle('I'.$fila_del.':I'.$fila_eve)->applyFromArray($styleArrayLEFT);
                                        // unset($styleArrayLEFT);
										 
										// $objPHPExcel->getActiveSheet()->getStyle('Y'.$fila_del.':Y'.$fila_eve)->applyFromArray($styleArrayRIGHT);
                                        // unset($styleArrayRIGHT);
										 
										 
										 //echo 'aplicamos el bottom: I'.$fila_eve.':Y'.$fila_eve.'<br>';
										 //$objPHPExcel->getActiveSheet()->getStyle('I'.$fila_eve.':Y'.$fila_eve)->applyFromArray($styleArrayBOTTOM);
                                         //unset($styleArrayBOTTOM);
										 
						
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
					 
					 
					  // color de background del delegado
				  $var_colorde = "color_dir".$conta_dir."_ger".$conta_ger;
				 // echo "Color: ".$var_colord. " : ".$$var_colord."<br>"."A".$fila_dir.":D".$fila_ger."<br>";
				 $fila_delT = $fila_del - 1;
				 $objPHPExcel->getActiveSheet()->getStyle('E'.$fila_ger.':Y'.$fila_delT)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $$var_colorde)));
				 
				 
				 
                                        
                                         $objPHPExcel->getActiveSheet()->getStyle('E'.$fila_ger.':H'.$fila_ger)->applyFromArray($styleArrayTOP);
                                         //unset($styleArrayTOP);
										 
										 
										
                                        // unset($styleArrayRIGHT);
				 
				 
					 
					 
					 $objPHPExcel->setActiveSheetIndex(1)
					 ->setCellValue('B'.$RSM_fila_ger, $cont_eveG);
					 
					 $objPHPExcel->setActiveSheetIndex(1)
					 ->setCellValue('C'.$RSM_fila_ger, $cont_asis_ger);
					 
					 $objPHPExcel->setActiveSheetIndex(1)
					 ->setCellValue('D'.$RSM_fila_ger, $cont_exa_ger);
					 
					$objPHPExcel->getActiveSheet()->getStyle('A'.$RSM_fila_ger.':D'.$RSM_fila_ger)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $$var_colorde)));
					
					
					
					if ($conta_ger == 1) {
					 $conta_ger = 2;
					 }  else {
					  $conta_ger = 1;
					 }
					 
					 
				   $fila_ger = $fila_del;
				   $RSM_fila_ger = $RSM_fila_ger + 1;
				   $ger_act = $rowg['id'];
			   }
			   $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$fila_dir, $cont_eveD);
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C'.$fila_dir, $cont_asis_dir);
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('D'.$fila_dir, $cont_exa_dir);
				
				// color de background
				  $var_colord = "color_dir".$conta_dir;
				 // echo "Color: ".$var_colord. " : ".$$var_colord."<br>"."A".$fila_dir.":D".$fila_ger."<br>";
				 $fila_gerT = $fila_ger - 1;
				 $objPHPExcel->getActiveSheet()->getStyle('A'.$fila_dir.':D'.$fila_gerT)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $$var_colord)));
				 
				 if ($conta_dir == 1) {
					 $conta_dir = 2;
					 }  else {
					  $conta_dir = 1;
					 }
				
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('A'.$RSM_fila_ger, "Total Territorio");
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('B'.$RSM_fila_ger, $cont_eveD);
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('C'.$RSM_fila_ger, $cont_asis_dir);
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('D'.$RSM_fila_ger, $cont_exa_dir);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$RSM_fila_ger.':D'.$RSM_fila_ger)->getFont()->setBold(true);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$RSM_fila_ger.':D'.$RSM_fila_ger)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FFFF00')));
				
				$Tcont_eveD = $Tcont_eveD + $cont_eveD;
				$Tcont_asis_dir = $Tcont_asis_dir + $cont_asis_dir;
				$Tcont_exa_dir = $Tcont_exa_dir + $cont_exa_dir;
				
				$RSM_fila_ger = $RSM_fila_ger + 1;
			   
			   
			   $fila_dir = $fila_ger;
		       $dir_act = $row['id'];
			   
			   
			   
		   }
		   
		   $fila_dirT = $fila_dir - 1;
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('H2'.':H'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('G2'.':G'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('F2'.':F'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('E2'.':E'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('D2'.':D'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('C2'.':C'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('B2'.':B'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2'.':A'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   
		   
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('I2'.':I'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('J2'.':J'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('K2'.':K'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('L2'.':L'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('M2'.':M'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('N2'.':N'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('O2'.':O'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('P2'.':P'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q2'.':Q'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('R2'.':R'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('S2'.':S'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('T2'.':T'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('U2'.':U'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('V2'.':V'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('W2'.':W'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('X2'.':X'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('Y2'.':Y'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   
		   
		   $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$fila_dirT.':Y'.$fila_dirT)->applyFromArray($styleArrayBOTTOM);
		   
		   
		   // $objPHPExcel->setActiveSheetIndex(0)->getStyle('E2'.':E'.$fila_dirT)->applyFromArray($styleArrayLEFT);
                                         //unset($styleArrayLEFT);
			//$objPHPExcel->setActiveSheetIndex(0)->getStyle('H2'.':H'.$fila_dirT)->applyFromArray($styleArrayRIGHT);
		   
		   $objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('A'.$RSM_fila_ger, "TOTALES");
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('B'.$RSM_fila_ger, $Tcont_eveD);
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('C'.$RSM_fila_ger, $Tcont_asis_dir);
				
				$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('D'.$RSM_fila_ger, $Tcont_exa_dir);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$RSM_fila_ger.':D'.$RSM_fila_ger)->getFont()->setBold(true);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$RSM_fila_ger.':D'.$RSM_fila_ger)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FCC7C3')));
				
				
				$objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:D'.$RSM_fila_ger)->applyFromArray($styleArrayALL);
				
				
				

$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->getStyle("A1:Y".$fila_dir)->getFont()->setSize(8);
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle("A1:Y".$fila_dir)->getFont()->setSize(8);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//$objPHPExcel->setActiveSheetIndex(0);



// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="estadisticasPyC_'.date('d-m-Y').'.xls"');
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



//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
/*$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;*/


