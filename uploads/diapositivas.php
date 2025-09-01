<?php include("../includes/conn.php");

error_reporting(-1); // ALL messages and 
ini_set('error_reporting', E_ALL);


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
//if (!is_dir('ponencias/'.$_POST['contenido'])) {
		    mkdir("ponencias/".$_POST['contenido'], 0777, true);
	 //  }
	   
	   
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	$contenido = $_POST['contenido'];
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	
	 $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	 $fileTypes  = str_replace(';','|',$fileTypes);
	 $typesArray = split('\|',$fileTypes);
	 $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	 $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

	        
		//copy($tempFile, $targetFile);
		
	  move_uploaded_file($tempFile,$targetFile);
		
  
   
				
				$result1e = mysql_query("SELECT id FROM com_ponencias_ima ORDER BY id DESC LIMIT 1",$link) or die("el error es 2: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $id = 1;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $id = $rowe['id'] + 1;
                }
				
				
				$result1e = mysql_query("SELECT orden FROM com_ponencias_ima WHERE ponencia = '".$contenido."' ORDER BY orden DESC LIMIT 1",$link) or die("el error es 2: ".mysql_error());
               if(mysql_num_rows($result1e)==0) { 
                   $orden = 0;
               }
                else {
                  $rowe = mysql_fetch_array($result1e);
                  $orden = $rowe['orden'] + 1;
                }
				
				
      
  $sqlp = "INSERT INTO com_ponencias_ima (id, ponencia, nombre, orden) VALUES ('".$id."','".$contenido."','".$_FILES['Filedata']['name']."','".$orden."')";
				   
				  $result = mysql_query ($sqlp,$link);
			
			
			
   
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	 

}
echo "no encuentra";
?>