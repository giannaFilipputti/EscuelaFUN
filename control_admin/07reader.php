<?php include("../includes/conn.php");
include("auto_n2.php");
include("../includes/extraer_variables.php");
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


if (!file_exists("estadisticas.xlsx")) {
	exit("Please run 05featuredemo.php first." . EOL);
}

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
			  
			  
			   $sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 7) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 7) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C6', $NroRegistros2n)
			->setCellValue('C7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 7) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 7) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C5', $NroRegistros5n)
			->setCellValue('C4', $NroRegistros4n);
			
			
			// ABORDAJE
			
			 $sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 2) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 2) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D6', $NroRegistros2n)
			->setCellValue('D7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 2) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 2) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D5', $NroRegistros5n)
			->setCellValue('D4', $NroRegistros4n);
			
			
			// COMPLICACIONES
			
			 $sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 4) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 4) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E6', $NroRegistros2n)
			->setCellValue('E7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 4) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 4) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E5', $NroRegistros5n)
			->setCellValue('E4', $NroRegistros4n);
			
			
			// FOCO 1
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 8) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 8) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F6', $NroRegistros2n)
			->setCellValue('F7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 8) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 8) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F5', $NroRegistros5n)
			->setCellValue('F4', $NroRegistros4n);
			
			
			// FOCO 2
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 13) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 13) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G6', $NroRegistros2n)
			->setCellValue('G7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 13) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 13) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G5', $NroRegistros5n)
			->setCellValue('G4', $NroRegistros4n);
			
			
			// FOCO 3
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 19) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 19) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H6', $NroRegistros2n)
			->setCellValue('H7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 19) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 3 AND com_log_pag.modulo = 19) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H5', $NroRegistros5n)
			->setCellValue('H4', $NroRegistros4n);
			
			
			
			//ZOOM 2 CONGRESS
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 5) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 5) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I6', $NroRegistros2n)
			->setCellValue('I7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 5) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 5) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I5', $NroRegistros5n)
			->setCellValue('I4', $NroRegistros4n);
			
			// DIABEST
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 6) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 6) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J6', $NroRegistros2n)
			->setCellValue('J7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 6) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 6) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J5', $NroRegistros5n)
			->setCellValue('J4', $NroRegistros4n);
			
			// DAD
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 8) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 8) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K6', $NroRegistros2n)
			->setCellValue('K7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 8) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 8) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K5', $NroRegistros5n)
			->setCellValue('K4', $NroRegistros4n);
			
			
			
			// DIABETES A LA CARTA
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 31) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 31) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L6', $NroRegistros2n)
			->setCellValue('L7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 31) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 31) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L5', $NroRegistros5n)
			->setCellValue('L4', $NroRegistros4n);
			
			
			
			// DIABEWEB
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.user FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav2 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 477) AND (com_log_pag.ignorar = 0)";
			  $sql_nav3 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 477) AND (com_log_pag.ignorar = 0)";
			  
			  
			   $NroRegistros1n=mysql_num_rows(mysql_query($sql_nav2));
			   $NroRegistros2n=mysql_num_rows(mysql_query($sql_nav3));


             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M6', $NroRegistros2n)
			->setCellValue('M7', $NroRegistros1n);
			
			
			
			
			$sql_nav1 = "SELECT DISTINCT com_log_pages.sesion FROM com_log_pages INNER JOIN com_log_pag ON com_log_pag.id = com_log_pages.id_page WHERE ";
			 $sql_nav = "";
			 
		      if (!empty($desde)) { 
			    
		        $sql_nav .= "com_log_pages.fecha >='". $desde1."' AND ";
			  }
			  if (!empty($hasta)) {
				 
		        $sql_nav .= "com_log_pages.fecha <='". $hasta1."' AND ";
			  }
			  
			  $sql_nav4 = $sql_nav1.$sql_nav."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 477) AND (com_log_pag.ignorar = 0)";
			  $sql_nav5 = $sql_nav1."com_log_pages.user > 0 AND (com_log_pag.curso = 7 AND com_log_pag.id = 477) AND (com_log_pag.ignorar = 0)";
			  
			
			  
			  echo $sql_nav4."<br>";
			  echo $sql_nav5;
			  
			  
			   $NroRegistros4n=mysql_num_rows(mysql_query($sql_nav4));
			   $NroRegistros5n=mysql_num_rows(mysql_query($sql_nav5));
			   

             $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M5', $NroRegistros5n)
			->setCellValue('M4', $NroRegistros4n);
			
			
			

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
echo 'Call time to read Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('estadisticas_mes.xlsx');

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;
