            <?php 

            require_once '../lib/autoloader.class.php';

            require_once '../lib/init.class.php';

            require_once '../lib/auth.php';

           /* if ($authj->rowff['labor'] < 6)  {
                header("Location: index.php");	
                die();
            }*/


           

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

                    $targetFile1 = $curso . "_" . $usuario . "_" . $valor . "." . $fileParts['extension'];


                    



                    if ($file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile1)) {
/*
                        $chequeo = "empezamos";
                    $file = fopen("archivo.txt", "w");

    fwrite($file, $chequeo." lo h movido ".$targetFile1." . el nombre del archivo".$_FILES["file"]["tmp_name"]." . peso".$filesize." . extension".$fileParts['extension']);

    fclose($file);*/

                       

                       $subir = Curso::subirPrerequisito($curso, $usuario, $valor, $ext, $nombre);

                      


                        //return $valor;

                    }
                }
            }

            ?>