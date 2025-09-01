<?php
include("../includes/conn.php");
include("../includes/extraer_variables_seg.php");
include("auto.php");



function verificaremail($email){ 
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function verificaremail2($email){ 
  if (!ereg("^([a-zA-Z0-9._]+)*@([a-zA-Z0-9|_|-]+).([a-zA-Z]{2,4})$",$email)){ 
      return FALSE; 
  } else { 
       return TRUE; 
  } 
}




if (verificaremail('aurora-rivas.perez@hot-mail.com')) {
	echo "true";
	} else {
		echo "false";
		}


?>