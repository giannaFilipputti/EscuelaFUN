<?php 
function cortar_string ($string, $largo) { 
   $marca = "<!--corte-->"; 

   if (strlen($string) > $largo) { 
        
       $string = wordwrap($string, $largo, $marca); 
       $string = explode($marca, $string); 
       $string = $string[0]; 
   } 
   return $string; 

} 
?>
