<?php
    // Conexión a la BBDD
    include 'config/database.php';

    try {
        // Confirmamos que mediante GET se ha pasado el ID que queremos hacer el delete
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        // Query para borrar el producto
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $con->prepare($query);
        // Asociamos el valor de id de la query al 1er parametro pasado por el GET
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()){
            // Redirecciona a index y en la barra de navegacion saldrá que deleted.
            header('Location: index.php?action=deleted');
        }else{
            // Cierra el script diciendo que no ha sido posible borrar la fila.
            die('Unable to delete record.');
        }
    }
    // Muestra el error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
?>