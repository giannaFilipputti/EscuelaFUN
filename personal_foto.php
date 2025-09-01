<?php
$page = "personal";
$scripts = "none";
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

/*
if ($authj->rowff['labor'] < 6)  {
	header("Location: index.php");	
	die();
}*/


if (!empty($authj->rowff['foto_perfil'])) { 
?>

    <img src="uploads/g_perfil_<?php echo $authj->rowff['id'];?>_<?php echo $authj->rowff['foto_perfil'];?>.jpg" alt="">
<?php } else { ?>
    <img src="../assets/images/avatars/home-profile.jpg?v=1" alt="">
<?php } ?>
