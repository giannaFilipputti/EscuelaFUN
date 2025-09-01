<?php

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';

$row_Notas = Curso::getNotas($curso, $modulo, $capitulo, $authj->rowff['id']);

$cant_Notas = count($row_Notas);

$div_comentarios = "";

foreach ($row_Notas as $row) :

    $div_notas .= '
        <article class="uk-comment uk-comment-primary uk-visible-toggle" tabindex="-1" style="margin-bottom: 5px">
            <header class="uk-comment-header uk-position-relative">
                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                    <div class="uk-width-expand saltarV" rel="' . $row['tiempo'] . '">
                        <h4 class="uk-comment-title uk-margin-remove">
                        <a class="uk-link-reset" style="font-size: 13px" href="#">' . Funcion::conversorSegundosHoras($row['tiempo']) . '</a></h4>
                        <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" style="font-size: 11px" href="#">' . $row['fecha'] . '</a></p>
                    </div>
                </div>
               
            </header>
            <div class="uk-comment-body">
                <p>' . $row['comentario'] . '</p>
            </div>
        </article>
      
        ';



//$div_comentarios .= '<br>';

endforeach;



?>
<?php if ($primera_carga != 1) { ?>
   <?php echo $div_notas; ?>
<script type="text/javascript">
    $(document).ready(function() {


        $(".saltarV").click(function() {

            var accion = $(this).attr('rel');
            console.log("tiempo" + accion);

            player1.setCurrentTime(accion);
            player1.play();

        });

    });
</script>
<?php } ?>