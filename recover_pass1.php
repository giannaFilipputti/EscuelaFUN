<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';

$db = Db::getInstance();
                $sql = "SELECT * FROM com_passrecover WHERE clave = :clave AND usuario = :usuario LIMIT 1";
                $bind = array(
                   ':clave' => $unique,
                   ':usuario' => $id
                );

                $cont = $db->run($sql, $bind);
                
	
	if ($cont > 0) {
        
            $db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
                        if ($rowff1[0]['estado'] == 0) {
                            $pass1 = sha1(md5(trim($usu_newpwd)));
                            $db4 = Db::getInstance();
                            $data4 = array(
                            'pass' => $pass1,
                            'activado' => 1

                            );
                            
                            $db4->update('com_registro', $data4, 'id = :id', array(':id' => $id));
                            
                            $db5 = Db::getInstance();
                            $data5 = array(
                            'estado' => '1'

                            );
                            $db5->update('com_passrecover', $data5, 'id = :id', array(':id' => $rowff1[0]['id']));
                            
                            header("Location: login.php?recpass=OK");
                        } else{
                            header("Location: recover_pass.php?res=KO&id=".$id."&unique=".$unique);
                        }
        } else {
            header("Location: recover_pass.php?res=KO&id=".$id."&unique=".$unique);
        }

?>