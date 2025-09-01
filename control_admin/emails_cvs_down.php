<?php

    include_once ("../includes/conn.php");
	require_once("../includes/extraer_variables_seg.php");
    include ("auto.php");
    
	
	
    
	$f = "ejemplo.csv";
	
 

    
	$elnombre = "contatos.csv";
   
	
	
	header ("Content-Disposition: attachment; filename=$elnombre\n\n");
    header("Content-Type: application/force-download");
    @readfile($f);
	
	
?> 