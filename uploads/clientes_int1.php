<?php ini_set ('error_reporting', E_ALL);


   // Edit upload location here
   $id = $_GET['id'];
   $tipo= $_GET['tipo'];
   $cnt= $_GET['cnt'];
   $ref = $id;
   
   $j = $cnt;
   //echo $j."aqui";
  

   
   $destination_path = getcwd().DIRECTORY_SEPARATOR;
   
  

   $result = 0;
   
   $filename = @basename($_FILES['myfile1']['name']);
   
   $file_ext = @strtolower(@strrchr($filename,"."));
   
   //echo $ref."_".$tipo.".".$file_ext;
   
   $target_path = $filename; // . basename( $_FILES['myfile']['name'])
  echo "<br>".$target_path."<br>";
   
   //copy('blanco.jpg',$target_path);
   //copy('blanco.jpg',$target_path);
   

  // if (is_uploaded_file($HTTP_POST_FILES['myfile1']['tmp_name'])) { 
   
   if (is_uploaded_file($_FILES['myfile1']['tmp_name'])) { 
        copy($_FILES['myfile1']['tmp_name'], $target_path);
		echo "subio";
   }
 //  }
   
   

?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);</script>
  
