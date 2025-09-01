<?php

include("../../includes/conn.php");
//include("../auto.php");
$fecha = date('Y-m-d H:i:s');
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$id = remplazophp($_POST['id']);
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	
	
	 $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	 $fileTypes  = str_replace(';','|',$fileTypes);
	 $typesArray = split('\|',$fileTypes);
	 $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	 if (in_array($fileParts['extension'],$typesArray)) {
		 
		
		 
		    
				
				
				
				/*$targetFile =  str_replace('//','/',$targetPath) . "comite_" .$id.".".$fileParts['extension'];
	            $targetFile1 =  "comite_" .$id.".".$fileParts['extension'];*/
				
				
				$targetFile =  str_replace('//','/',$targetPath) . "modulo_" .$id.".".$fileParts['extension'];
	            $targetFile1 =  "modulo_" .$id.".".$fileParts['extension'];
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		
		move_uploaded_file($tempFile,$targetFile);
		
		//echo $targetFile;
		
   $img=getimagesize($targetFile1);
   $ancho1=$img[0];
   $alto1=$img[1];
  //echo $ancho1."alto".$alto1."<br>";
   
   // la imagen grande
   // la imagen grande
  
   
 
			   
				 //  $result = mysql_query ($sqlp,$link) or die("el error es 1: ".mysql_error());
				   
				   
   include_once('../../includes/easyphpthumbnail.class.php');
   $thumb = new easyphpthumbnail;
    
      	
   $thumb -> Thumbsaveas = 'jpg';
   $thumb -> Thumbprefix = 'g_';

   $thumb -> Createthumb($targetFile1,'file');
   
   
   
   $anchop = 362;
   $altop = ($anchop * $alto1) / $ancho1;
   
   if($altop >= 210) {
      $crl = 0;
	  $crr = 0;
	  $altoc = ($altop - 210) / 2;
	  $altof = ($alto1 * $altoc) / $altop;
	  $crt = intval($altof);
	  $crb = intval($altof);
   }
   else {
      $altop = 210;
	  $anchop = ($ancho1 * $altop) / $alto1;
	  
	  $anchoc = ($anchop - 362) / 2;
	  $anchof = ($ancho1 * $anchoc) / $anchop;
	  
	  $anchop = 362;
	    
	  $crl = intval($anchof);
	  $crr = intval($anchof);	  
	  $crt = 0;
	  $crb = 0;
   }
   
   
   $thumb = new easyphpthumbnail;
    
     $thumb -> Thumbwidth = $anchop;
     $thumb -> Cropimage = array(1,1,$crl,$crr,$crt,$crb);
  	
   $thumb -> Thumbsaveas = 'jpg';
   $thumb -> Thumbprefix = 'p_';

   $thumb -> Createthumb($targetFile1,'file'); 
   
   
   
   $anchop = 754;
   $altop = ($anchop * $alto1) / $ancho1;
   
   if($altop >= 269) {
      $crl = 0;
	  $crr = 0;
	  $altoc = ($altop - 269) / 2;
	  $altof = ($alto1 * $altoc) / $altop;
	  $crt = intval($altof);
	  $crb = intval($altof);
   }
   else {
      $altop = 269;
	  $anchop = ($ancho1 * $altop) / $alto1;
	  
	  $anchoc = ($anchop - 754) / 2;
	  $anchof = ($ancho1 * $anchoc) / $anchop;
	  
	  $anchop = 754;
	    
	  $crl = intval($anchof);
	  $crr = intval($anchof);	  
	  $crt = 0;
	  $crb = 0;
   }
   
   
   $thumb = new easyphpthumbnail;
    
     $thumb -> Thumbwidth = $anchop;
     $thumb -> Cropimage = array(1,1,$crl,$crr,$crt,$crb);
  	
   $thumb -> Thumbsaveas = 'jpg';
   $thumb -> Thumbprefix = 'gp_';

   $thumb -> Createthumb($targetFile1,'file'); 
		 

			
    $sqlp = "UPDATE com_cursos_mod SET imagen = '1' WHERE id = ".$id."";
		      $result = mysql_query ($sqlp,$link);
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	 
} else {
	 	echo 'Invalid file type.';
	 }
}
?>