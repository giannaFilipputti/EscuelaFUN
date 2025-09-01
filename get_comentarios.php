<?php 

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$curso = $_GET['curso'];
$modulo = $_GET['modulo'];

$sql = "SELECT comco.id,UPPER(core.nombre) as nombre,UPPER(core.ape1) as ape1,comco.comentario,DATE_FORMAT(comco.fecha, '%d-%m-%Y %H:%i') as fecha,comco.principal,comco.respuesta 
        FROM com_comentarios comco
        JOIN com_registro core on core.id = comco.usuario
        WHERE comco.curso = $curso AND comco.modulo = $modulo AND principal = 1
        GROUP BY comco.comentario,comco.fecha,comco.principal,comco.respuesta,comco.id
        ORDER BY comco.id ASC";	

$db->run($sql);
$row_p = $db->fetchAll($sql);

$div_comentarios = "";

foreach($row_p as $row):

    $div_comentarios .= '
        <article class="uk-comment uk-comment-primary uk-visible-toggle" tabindex="-1" style="margin-bottom: 5px">
            <header class="uk-comment-header uk-position-relative">
                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                    <div class="uk-width-expand">
                        <h4 class="uk-comment-title uk-margin-remove">
                        <a class="uk-link-reset" style="font-size: 13px" href="#">'.$row['nombre'].' '.$row['ape1'].'</a></h4>
                        <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" style="font-size: 11px" href="#">'.$row['fecha'].'</a></p>
                    </div>
                </div>
                <div class="uk-position-top-right">
                    <button type="button" class="responder_comentario btn btn-primary btn-sm" href="#modal_resp_comentario" uk-toggle="" data-id="'.$row['id'].'" data-curso="'.$_GET['curso'].'" data-modulo="'.$_GET['modulo'].'">
                    Responder
                    </button>
                </div>
            </header>
            <div class="uk-comment-body">
                <p>'.$row['comentario'].'</p>
            </div>
        </article>';

        $sql2 = "SELECT comco.id,UPPER(core.nombre) as nombre,UPPER(core.ape1) as ape1,comco.comentario,DATE_FORMAT(comco.fecha, '%d-%m-%Y %H:%i') as fecha,comco.principal,comco.respuesta 
        FROM com_comentarios comco
        JOIN com_registro core on core.id = comco.usuario
        WHERE comco.curso = $curso AND comco.modulo = $modulo AND principal = 0
        GROUP BY comco.comentario,comco.fecha,comco.principal,comco.respuesta,comco.id
        ORDER BY comco.id ASC";
    
        $db->run($sql2);
        $row_p2 = $db->fetchAll($sql2);
    
        $j = 0;
        $leng = count($row_p2);
    
        foreach($row_p2 as $row2):
    
            if($row['id'] == $row2['respuesta']):
                
                $div_comentarios .= '
                    <ul style="margin-bottom: 5px">
                        <li>
                            <article class="uk-comment uk-comment-primary uk-visible-toggle" tabindex="-1">
                                <header class="uk-comment-header uk-position-relative">
                                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" style="font-size: 13px" href="#">'.$row2['nombre'].' '.$row2['ape1'].'</a></h4>
                                        <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="#" style="font-size: 11px">'.$row2['fecha'].'</a></p>
                                    </div>
                                </div>
                                </header>
                                <div class="uk-comment-body">
                                    <p>'.$row2['comentario'].'</p>
                                </div>
                            </article>
                        </li>
                    </ul>';
    
            if ($j == $leng - 1) {
    
               // echo '<br><br>';
                                                
            }else{
    
            }
    
            $j++;
    
            endif;
    
        endforeach;

    //$div_comentarios .= '<br>';

endforeach;

echo $div_comentarios;

?>