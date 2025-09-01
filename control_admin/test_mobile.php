<?php
include("../includes/conn.php");
include("auto_n2.php");
include("../includes/extraer_variables.php");
require_once '../includes/Mobile_Detect.php';
/*
$detect = new Mobile_Detect;
$detect->setUserAgent('Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/38.0.2125.59 Mobile/12A405 Safari/600.1.4');
var_dump($detect->version('Chrome'));
var_dump($detect->version('iPhone'));
*/

/*
$user_agents = array(
    'android' => 'Mozilla/5.0 (Linux; Android 4.2; Nexus 7 Build/JOP40C) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Safari/535.19',
    'iphone6' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0_1 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A523 Safari/8536.25',
    'blackberry' => 'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.10+ (KHTML, like Gecko) Version/10.0.9.2372 Mobile Safari/537.10+'
);
$mobile_detect = new Mobile_Detect;

foreach($user_agents as $user_agent)
{
    $mobile_detect->setUserAgent($user_agent);
    var_dump($mobile_detect->isAndroidOS());
}
*/

$sql_nav = "SELECT id, user_agent FROM com_log WHERE ";
			 
			 
			  $sql_nav .= "id > 0";
			  $sql_nav .= " ORDER BY id DESC LIMIT 15000, 5000";
			  
			 // echo $sql_nav;
			  
			  $result_nav = mysql_query($sql_nav,$link) or die("el error es porque: ".mysql_error());
			  while ($row_nav = mysql_fetch_array($result_nav)){
				  

$detect = new Mobile_Detect;
//$detect->setUserAgent('Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko');
//var_dump($detect->version('IE'));
$detect->setUserAgent($row_nav['user_agent']);

$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

echo $row_nav['user_agent']." - <b>".$deviceType."</b><br>";

 $sqlp = "UPDATE com_log SET dispositivo = '".$deviceType."' WHERE id = ".$row_nav['id'];
  echo $sqlp."<br>";
  $result = mysql_query ($sqlp,$link);

//var_dump($detect->version('IE'));
			  }