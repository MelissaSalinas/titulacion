<?php
require_once 'conexion.php';
if(isset($_POST['btnsave']))
    {

        $certFile = $_FILES['archivo']['name'];
        $tmpcert_dir = $_FILES['archivo']['tmp_name'];
        $certSize = $_FILES['archivo']['size'];
        

        $uploadcertificado_dir = 'Archivos/pdf/';
    
            $certExt = strtolower(pathinfo($certFile,PATHINFO_EXTENSION));
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
        
            // rename uploading image
            $certificadopic = rand(1000,1000000).".".$certExt;


            if(in_array($certExt, $valid_extensions)){           
                // Check file size '5MB'
                if($certSize < 5000000)              {
                    move_uploaded_file($tmpcert_dir,$uploadcertificado_dir.$certificadopic);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }

        // if no error occured, continue ....
        if(!isset($errMSG))
        {
          $resul=mysqli_query($conn ,"INSERT INTO rutas (ruta) VALUES ('".$certificadopic."')");
          } 
        }
?>