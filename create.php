<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> 
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
        <?php
            if($_POST){

            // Conexión a base de datos con el otro archivo (Importamos $con y sus funciones)
            include 'config/database.php';
            try{
                // Escribimos la query
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, image=:image, created=:created";
                // Preparamos la query
                $stmt = $con->prepare($query);
                // Recogemos los valores del POST
                $name=htmlspecialchars(strip_tags($_POST['name']));
                $description=htmlspecialchars(strip_tags($_POST['description']));
                $price=htmlspecialchars(strip_tags($_POST['price']));
                $image=!empty($_FILES["image"]["name"])
		                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
		                : "";
                $image=htmlspecialchars(strip_tags($image));
                // Enlazamos los parametros del POST con los de la query
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image', $image);
                // Especificamos cuando se ha creado esta query
                $created=date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);
                // Ejecutamos la query
                if($stmt->execute()){
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                    if($image){
                        // Creamos la ruta al directorio, asignamos el archivo y su extensión
                        $target_directory = "uploads/";
                        $target_file = $target_directory . $image;
                        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Mensaje de error vacio
                        $file_upload_error_messages="";
                        // Confirmar que es una imagen real
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if($check!==false){
                            // Archivo enviado es una imagen
                        }else{
                            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                        }
                        // Permitir solamente X tipos de archivos
                        $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                        if(!in_array($file_type, $allowed_file_types)){
                            $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                        }
                        // Comprobar que el archivo no existe ya con el mismo nombre
                        if(file_exists($target_file)){
                            $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                        }
                        // Comprobar que el archivo no pesa más de 1MB
                        if($_FILES['image']['size'] > (1024000)){
                            $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                        }
                        // Comprobar que existe la carpeta uploads, si no, la crea
                        if(!is_dir($target_directory)){
                            mkdir($target_directory, 0777, true);
                        }
                        // Si $file_upload_error_messages sigue vacio
                        if(empty($file_upload_error_messages)){
                            // Significa que no ha habido errores, entonces intenta subir el archivo
                            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                                // Significa que se ha subido
                            }else{
                                echo "<div class='alert alert-danger'>";
                                    echo "<div>Unable to upload photo.</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }

                        // Si $file_upload_error_messages NO está vacío
                        else{
                            // Significa que ha habido errores, y se lo mostramos al usuario
                            echo "<div class='alert alert-danger'>";
                                echo "<div>{$file_upload_error_messages}</div>";
                                echo "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }
                }else{
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>