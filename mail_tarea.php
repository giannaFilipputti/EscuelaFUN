<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth_off.php';

$id_curso       = $_POST['id_curso'];
$id_modulo      = $_POST['id_modulo'];
$id_capitulo    = $_POST['id_capitulo'];

$nombre_tarea           = $_POST['nombre_tarea'];
$descripcion_tarea      = $_POST['descripcion_tarea'];
$fecha_entrega_tarea    = $_POST['fecha_entrega_tarea'];
$fecha_entrega_tarea    = date("d-m-Y", strtotime($fecha_entrega_tarea));
$comentario_tarea       = $_POST['comentario_tarea'];

$db = Db::getInstance();
$sql = "SELECT com_registro.nombre,com_registro.ape1,com_registro.ape2,com_registro.email,com_cursos.titulo as curso,com_cursos_mod.titulo as modulo,com_cursos_mod_cap.titulo as capitulo FROM com_registro 
          JOIN com_cursos on com_cursos.id = :id_curso
          JOIN com_cursos_registro on com_cursos_registro.curso = :id_curso
          JOIN com_cursos_mod on com_cursos_mod.id = :id_modulo
          JOIN com_cursos_mod_cap on com_cursos_mod_cap.id = :id_capitulo
         WHERE com_registro.id = com_cursos_registro.usuario";

$bind = array(
    ':id_curso' => $id_curso,
    ':id_modulo' => $id_modulo,
    ':id_capitulo' => $id_capitulo
);

$cont = $db->run($sql, $bind);

if ($cont > 0) {

    $data = $db->fetchAll($sql, $bind);

    foreach($data as $row) {

        $nombre     = $row['nombre'];
        $ape1       = $row['ape1'];
        $ape2       = $row['ape2'];
        $email      = $row['email'];
        $curso      = $row['curso'];
        $modulo     = $row['modulo'];
        $capitulo   = $row['capitulo'];

        $nota = "
        <table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#19ABB9\">
        
            <tr>
                <td valign=\"top\" align=\"center\"></td>
            </tr>
            
            <tr>
                <td valign=\"top\" align=\"left\">
                
                    <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
                    
                        <tr>
                
                            <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
                            
                            <td width=\"560\" align=\"left\" valign=\"top\">
                            
                                <font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\">
                                
                                    <br /><br />
                                    
                                    Apreciado/a <b>".$nombre." ".$ape1." ".$ape2."</b><br><br><br>
                                    Te informamos que se ha cargado una tarea en:<br><br>
                                    
                                    <b>Curso: </b>".$curso." <br>
                                    <b>Módulo: </b> ".$modulo." <br>
                                    <b>Capítulo: </b> ".$capitulo." <br><br>

                                    <br>

                                    Detalles de la tarea:<br><br>

                                    <b>Nombre: </b>".$nombre_tarea." <br>
                                    <b>Descripción: </b> ".$descripcion_tarea." <br>
                                    <b>Fecha de entrega: </b> ".$fecha_entrega_tarea." <br>
                                    <b>Comentario dejado por el profesor: </b> ".$comentario_tarea." <br><br><br>
                 
                                    Puedes acceder directamente haciendo clic <a href=\"".$app_url."visor.php?curso=".$id_curso."&modulo=".$id_modulo."&capitulo=".$id_capitulo."\"><b>aquí</b></a>
                                
                                </font>
                            
                            </td>
                                                    
                        </tr>

                        <tr>

                            <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
                            
                            <td width=\"560\" align=\"left\" valign=\"top\">
                            
                                <font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\">
                                
                                    <br>

                                    Si no puedes acceder a trav&eacute;s del enlace de arriba, ingresa manualmente con tu email y password y dirígete al menú Cursos.<br><br>

                                    Muchas gracias por tu participacion. <br><br><br>
                                
                                </font>

                            </td>

                        </tr>

                    </table>

                </td>
                    
            </tr>

        </table>";

        $asunto = "Nueva tarea cargada";

        require_once('includes/class.phpmailer.php');
        require_once('includes/class.smtp.php');

        $mail = new PHPMailer();

        $mail->IsSMTP();

        $mail->SMTPDebug = 0;

        $mail->Host = $mailhost;
        
        if (!empty($mailsecure)) {
        
            $mail->SMTPSecure = $mailsecure;
        
        }
        
        if (!empty($mailport)) {

            $mail->Port = $mailport;
        
        }

        $mail->From = 'info@pulpro.com';
        $mail->FromName = 'info@pulpro.com';
        $mail->addAddress($email,$email);
        $mail->addReplyTo('info@pulpro.com', 'Pulpro');

        $mail->isHTML(true);
        $mail->SMTPAuth = true;

        $mail->Username = $maillogin;
        $mail->Password = $mailpass;
        $mail->CharSet  = 'UTF-8';

        $mail->Subject  = $asunto;
        $mail->Body     = $nota;

        $mail->send();
        $mail->ClearAllRecipients();

    }

} else {

}

?>