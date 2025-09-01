<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
$page = "intro";
$scripts = "none";


                                                $prerequisitos = Curso::validPrerequisitos($curso, $authj->rowff['id']);  ?>
                                                    <ul>
                                                        <?php if ($prerequisitos['estado'] == 1) { ?>

                                                            <li class="alert alert-success"> <i class="icon-material-outline-check-circle" style="color:#2EAD52"></i> Pre-requisitos aceptados </li>
                                                        <?php } else if (count($prerequisitos['documentos']) > 0) { ?>
                                                            <li class="alert alert-warning"> <i class="icon-material-outline-check-circle" style="color:#2EAD52"></i> Enviados pre-requisitos (pendiente validación) </li>
                                                        <?php } else { ?>
                                                            <li class="alert alert-danger"> <i class="icon-line-awesome-clock-o" style="color:#FDB613"></i> Pendiente </li>
                                                        <?php }  ?>


                                                    </ul>