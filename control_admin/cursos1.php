<?php 
require_once '../lib_c/autoloader.class.php';
require_once '../lib_c/init.class.php';
require_once '../lib_c/authAdmin.php';


          $sql = "SELECT * FROM com_cursos ORDER BY id";
          $result = mysql_query($sql);
   ?>