<?php
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';

$sql1 = "SELECT * FROM com_cursos_mod_cap WHERE id=".$id."";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_array($result1);

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);



define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

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

/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';





echo date('H:i:s') , " Load from Excel2007 file" , EOL;
$callStartTime = microtime(true);

$objPHPExcel = PHPExcel_IOFactory::load("estadisticas.xlsx");

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
$colArray = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

              if (!empty($desde)) { 
			    $desde1 = $desde . " 00:00:00";
			  }
			  if (!empty($hasta)) {
				 $hasta1 = $hasta . " 23:59:59"; 
			  } else {
			     $hasta = date('Y/m/d');
				 $hasta1 = $hasta . " 23:59:59"; 
			  }
			  
			  
			   $sql_nav = "SELECT id, ape1, ape2, codusuario, email, nombre, perfil, especialidad, pais, provincia, fecha,fecreg FROM com_alumnos WHERE ";
			 
			 
		     
			 
			  
			  $sql_nav .= "id > 0";
			  
			  $sql_nav .= " ORDER BY ape1 DESC";
			  
			  //echo $sql_nav;
			  $contador = 3;
			  $result_nav = mysql_query($sql_nav,$link) or die("el error es porque: ".mysql_error());
			  while ($row_nav = mysql_fetch_array($result_nav)){
				  
				   $sql_navu0 = "SELECT id FROM com_alumnos_exam WHERE alumno = ".$row_nav['id']." AND estado = 1";
				     
				  $perfil = "";
				  $sql_perfil = "SELECT codigo, perfil FROM com_perfiles WHERE codigo = '".$row_nav['perfil']."'";
				
				   $result_perfil = mysql_query($sql_perfil,$link) or die("el error es porque user1: ".mysql_error());
				   
				   if ($row_perfil = mysql_fetch_array($result_perfil)) {
					   $perfil = $row_perfil['perfil'];
				   }
				  
				  if ($row_nav['perfil'] == 'ME' && $row_nav['especialidad'] != 0) {
					  
					  $sql_perfil1 = "SELECT especialidad FROM com_especialidades WHERE id = ".$row_nav['especialidad']."";
				
				      $result_perfil1 = mysql_query($sql_perfil1,$link) or die("el error es porque user2: ".mysql_error());
				   
				   if ($row_perfil1 = mysql_fetch_array($result_perfil1)) {
					   $perfil = $row_perfil1['especialidad'];
				   }
					  
				  }
				  
				  $provincia = "";
				  
				  if (!empty($row_nav['provincia'])) {
					  
					  $sql_pro = "SELECT provincia FROM com_provincias WHERE codigo = '".$row_nav['provincia']."' AND pais = '".$row_nav['pais']."'";
				
				      $result_pro = mysql_query($sql_pro,$link) or die("el error es porque user3: ".mysql_error());
				   
				   if ($row_pro = mysql_fetch_array($result_pro)) {
					   $provincia = $row_pro['provincia'];
				   }
					  
				  } else {
					  
					  $sql_pro = "SELECT pais FROM com_paises WHERE codigo = '".$row_nav['pais']."'";
				
				      $result_pro = mysql_query($sql_pro,$link) or die("el error es porque user4: ".mysql_error());
				   
				   if ($row_pro = mysql_fetch_array($result_perfil1)) {
					   $provincia = $row_pro['pais'];
				   }
					  
				  }
				   
                                  $trabajo = $row_nav['empresa'];
			      
			  
			  
               $datedesde = new DateTime($row_nav['fecha']);
				  $datedesde1 = new DateTime($row_nav['fecreg']);
				  $datemod = new DateTime($row_nav['fecmod']);
             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$contador, $row_nav['ape1']." ".$row_nav['ape2'])
			->setCellValue('B'.$contador, $row_nav['nombre'])
			->setCellValue('C'.$contador, $row_nav['email'])
			->setCellValue('D'.$contador, $row_nav['mailing']." (".$datemod->format('d-m-Y').")")
			->setCellValue('E'.$contador, $perfil)
                        ->setCellValue('F'.$contador, $trabajo)
				 ->setCellValue('G'.$contador, $provincia)
			->setCellValue('H'.$contador, $datedesde->format('d-m-Y'))
			->setCellValue('I'.$contador, $datedesde1->format('d-m-Y'));
			
			// ABORDAJE
			
			        $sql_navu1 = "SELECT id, modulo, nota, aprobado, fecfin, desc_diploma, estado FROM com_alumnos_exam WHERE alumno = ".$row_nav['id']." AND modulo = 1 ORDER BY fecini DESC LIMIT 1";
				
				   $result_nav1 = mysql_query($sql_navu1,$link) or die("el error es porque user: ".mysql_error());
				   
				   if ($row_nav1 = mysql_fetch_array($result_nav1)) {
					   if ($row_nav1['estado'] == 1) {
						   
					   if ($row_nav1['aprobado'] == 1) {
						    $estadoE = "Aprobado";
						    $color = "2DB200";
						   } else {
							$estadoE = "Suspendido";
						    $color = "FF0000";
						   }
						   
						   if ($row_nav1['desc_diploma'] == 1) {
						    $dipE = "SI";
						   } else {
							$dipE = "NO";
						   }
						   $fechaF = $row_nav1['fecfin'];
					   } else {
						   $color = "000000";
						   $estadoE = "Iniciado";
						   $dipE = "NO";
						   $fechaF = "-";
					   }
					   
					   
					   } else {
					   $color = "000000";
					      $estadoE = "-";
						   $dipE = "-";
					      $fechaF = "-";
				   	}
					   
					   
					   $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue('J'.$contador, $estadoE)
			              ->setCellValue('K'.$contador, $fechaF)
			              ->setCellValue('L'.$contador, $dipE);
					   
					 $objPHPExcel->getActiveSheet()->getStyle('I'.$contador.':I'.$contador)->applyFromArray(array('font' => array('color' => array('rgb' => $color))));
				  
				  
				  
				  
				   $sql_navu1 = "SELECT id, modulo, nota, aprobado, fecfin, desc_diploma, estado FROM com_alumnos_exam WHERE alumno = ".$row_nav['id']." AND modulo = 2 ORDER BY fecini DESC LIMIT 1";
				
				   $result_nav1 = mysql_query($sql_navu1,$link) or die("el error es porque user: ".mysql_error());
				   
				   if ($row_nav1 = mysql_fetch_array($result_nav1)) {
					   if ($row_nav1['estado'] == 1) {
						   
					   if ($row_nav1['aprobado'] == 1) {
						    $estadoE = "Aprobado";
						    $color = "2DB200";
						   } else {
							$estadoE = "Suspendido";
						    $color = "FF0000";
						   }
						   
						   if ($row_nav1['desc_diploma'] == 1) {
						    $dipE = "SI";
						   } else {
							$dipE = "NO";
						   }
						   $fechaF = $row_nav1['fecfin'];
					   } else {
						   $color = "000000";
						   $estadoE = "Iniciado";
						   $dipE = "NO";
						   $fechaF = "-";
					   }
					   
					   
					   } else {
					   $color = "000000";
					      $estadoE = "-";
						   $dipE = "-";
					      $fechaF = "-";
				   	}
					   
					   
					   $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue('M'.$contador, $estadoE)
			              ->setCellValue('N'.$contador, $fechaF)
			              ->setCellValue('O'.$contador, $dipE);
					   
					 $objPHPExcel->getActiveSheet()->getStyle('L'.$contador.':L'.$contador)->applyFromArray(array('font' => array('color' => array('rgb' => $color))));
					   
					// MODULO 3
				  
				   $sql_navu1 = "SELECT id, modulo, nota, aprobado, fecfin, desc_diploma, estado FROM com_alumnos_exam WHERE alumno = ".$row_nav['id']." AND modulo = 3 ORDER BY fecini DESC LIMIT 1";
				
				   $result_nav1 = mysql_query($sql_navu1,$link) or die("el error es porque user: ".mysql_error());
				   
				   if ($row_nav1 = mysql_fetch_array($result_nav1)) {
					   if ($row_nav1['estado'] == 1) {
						   
					   if ($row_nav1['aprobado'] == 1) {
						    $estadoE = "Aprobado";
						    $color = "2DB200";
						   } else {
							$estadoE = "Suspendido";
						    $color = "FF0000";
						   }
						   
						   if ($row_nav1['desc_diploma'] == 1) {
						    $dipE = "SI";
						   } else {
							$dipE = "NO";
						   }
						   $fechaF = $row_nav1['fecfin'];
					   } else {
						   $color = "000000";
						   $estadoE = "Iniciado";
						   $dipE = "NO";
						   $fechaF = "-";
					   }
					   
					   
					   } else {
					   $color = "000000";
					      $estadoE = "-";
						   $dipE = "-";
					      $fechaF = "-";
				   	}
					   
					   
					   $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue('P'.$contador, $estadoE)
			              ->setCellValue('Q'.$contador, $fechaF)
			              ->setCellValue('R'.$contador, $dipE);
					   
					 $objPHPExcel->getActiveSheet()->getStyle('O'.$contador.':O'.$contador)->applyFromArray(array('font' => array('color' => array('rgb' => $color))));
				  
				  // MODULO 4
				  
				  $sql_navu1 = "SELECT id, modulo, nota, aprobado, fecfin, desc_diploma, estado FROM com_alumnos_exam WHERE alumno = ".$row_nav['id']." AND modulo = 4 ORDER BY fecini DESC LIMIT 1";
				
				   $result_nav1 = mysql_query($sql_navu1,$link) or die("el error es porque user: ".mysql_error());
				   
				   if ($row_nav1 = mysql_fetch_array($result_nav1)) {
					   if ($row_nav1['estado'] == 1) {
						   
					   if ($row_nav1['aprobado'] == 1) {
						    $estadoE = "Aprobado";
						    $color = "2DB200";
						   } else {
							$estadoE = "Suspendido";
						    $color = "FF0000";
						   }
						   
						   if ($row_nav1['desc_diploma'] == 1) {
						    $dipE = "SI";
						   } else {
							$dipE = "NO";
						   }
						   $fechaF = $row_nav1['fecfin'];
					   } else {
						   $color = "000000";
						   $estadoE = "Iniciado";
						   $dipE = "NO";
						   $fechaF = "-";
					   }
					   
					   
					   } else {
					   $color = "000000";
					      $estadoE = "-";
						   $dipE = "-";
					      $fechaF = "-";
				   	}
					   
					   
					   $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue('S'.$contador, $estadoE)
			              ->setCellValue('T'.$contador, $fechaF)
			              ->setCellValue('U'.$contador, $dipE);
					   
					 $objPHPExcel->getActiveSheet()->getStyle('R'.$contador.':R'.$contador)->applyFromArray(array('font' => array('color' => array('rgb' => $color))));
					
					 
			
			
			
			 $contador =  $contador + 1;
			 
				 
			
			  }
			
			
			
			
			 
			
			  
			
			
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
echo 'Call time to read Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
$clave_st = uniqid();

echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('excel/estadisticas'.$clave_st.'.xlsx');





			  
			 ?> <a href="descargar_reporte.php?id=<?php echo $clave_st?>">Descargar reporte</a>