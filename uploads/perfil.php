            <?php
            ini_set('gd.jpeg_ignore_warning', 1);

            error_reporting(E_ALL);
            ini_set('display_errors', '1');

            require_once '../lib/autoloader.class.php';

            require_once '../lib/init.class.php';

            require_once '../lib/auth.php';

            /*if ($authj->rowff['labor'] < 6)  {
                header("Location: index.php");	
                die();
            }*/

            function image_fix_orientation($filename)
            {
                $exif = exif_read_data($filename);
                if (!empty($exif['Orientation'])) {
                    $image = imagecreatefromjpeg($filename);
                    switch ($exif['Orientation']) {
                        case 3:
                            $image = imagerotate($image, 180, 0);
                            break;

                        case 6:
                            $image = imagerotate($image, -90, 0);
                            break;

                        case 8:
                            $image = imagerotate($image, 90, 0);
                            break;
                    }

                    imagejpeg($image, $filename, 90);
                }
            }




            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

                if (isset($_GET["delete"]) && $_GET["delete"] == true) {
                } else {




                    $file = $_FILES["file"]["name"];

                    $filetype = $_FILES["file"]["type"];

                    $filesize = $_FILES["file"]["size"];

                    $fileParts  = pathinfo($_FILES['file']['name']);

                    $nombre = $fileParts['filename'];

                    $ext = $fileParts['extension'];

                    $valor = uniqid();

                    $targetFile1 = "perfil_" . $authj->rowff['id'] . "_" . $valor . "." . $fileParts['extension'];






                    if ($file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile1)) {

                        $chequeo = "empezamos";
                        $file = fopen("archivo.txt", "w");
                        fwrite($file, $chequeo . " lo h movido " . $targetFile1 . " . el nombre del archivo" . $_FILES["file"]["tmp_name"] . " . peso" . $filesize . " . extension" . $fileParts['extension'] . $idpago . ", " . $usuario . ", " . $valor . ", " . $ext . ", " . $nombre);
                        fclose($file);

                        //image_fix_orientation($targetFile1);

                        $img = getimagesize($targetFile1);

                        $thumb = new easyphpthumbnail;

                        $ancho1 = $img[0];
                        $alto1 = $img[1];
                        //echo $ancho1."alto".$alto1."<br>";

                        // la imagen grande
                        // la imagen grande
                        $anchop = 300;
                        $altop = ($anchop * $alto1) / $ancho1;

                        if ($altop >= 300) {
                            $crl = 0;
                            $crr = 0;
                            $altoc = ($altop - 300) / 2;
                            $altof = ($alto1 * $altoc) / $altop;
                            $crt = intval($altof);
                            $crb = intval($altof);
                        } else {
                            $altop = 300;
                            $anchop = ($ancho1 * $altop) / $alto1;

                            $anchoc = ($anchop - 300) / 2;
                            $anchof = ($ancho1 * $anchoc) / $anchop;

                            $anchop = 300;

                            $crl = intval($anchof);
                            $crr = intval($anchof);
                            $crt = 0;
                            $crb = 0;
                        }


                        $thumb->Thumbwidth = $anchop;
                        $thumb->Cropimage = array(1, 1, $crl, $crr, $crt, $crb);

                        $thumb->Thumbsaveas = 'jpg';
                        $thumb->Thumbprefix = 'g_';

                        $thumb->Createthumb($targetFile1, 'file');



                        $authj->updateFotoPerfil($authj->rowff['id'], $valor);



                        //$subir = Curso::subirTransferencia($idpago, $usuario, $valor, $ext, $nombre);




                        //return $valor;

                    }
                }
            }

            ?>