<!DOCTYPE HTML>
<html>
<head>
	<title>PDO - Update a Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <?php
            // Confirmamos que mediante GET se ha pasado el ID que queremos hacer el update
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: El ID del producto no se ha encontrado.');

            // Conexión a base de datos con el otro archivo (Importamos $con y sus funciones)
            include 'config/database.php';

            // Leemos los datos del producto
            try {
                // Preparamos la query escrita
                $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
                $stmt = $con->prepare( $query );
                // Enlazamos el parámetro id pasado por get a la query por el "?"
                $stmt->bindParam(1, $id);
                // Ejecutamos la query
                $stmt->execute();
                // Guardamos la fila recibida en una variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // Guardamos los datos del producto en variables para utilizarlas en el formulario HTML
                $name = $row['name'];
                $description = $row['description'];
                $price = $row['price'];
            }
            // Si hay algun error lo mostramos
            catch(PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        ?>
        <?php
            //Chekeamos si el formulario ha sido enviado mediante POST
            if ($_POST) {
                try {
                    // Creamos la query que haga un update de los atributos del producto
                    $query = "UPDATE products
                                SET name=:name, description=:description, price=:price
                                WHERE id = :id";
                    // Preparamos la query para ejecutarla  
                    $stmt = $con -> prepare($query);
                    // Guardamos en variables los valores del post
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                    $price = htmlspecialchars(strip_tags($_POST['price']));
                    // Enlazamos los parametros del POST a la query
                    $stmt -> bindParam(':name', $name);
                    $stmt -> bindParam(':description', $description);
                    $stmt -> bindParam(':price', $price);
                    $stmt -> bindParam(':id', $id);
                    // Ejecutamos la query
                    if ($stmt -> execute()) {
                        echo "<div class='alert alert-success'>El producto ha sido actualizado</div>";
                    } else {
                        echo "<div class='alert alert-danger'>El producto no puede ser actualizado</div>";
                    }
                }
                // Si hay algun error, lo mostramos
                catch(PDOException $exception) {
                    die('ERROR: ' . $exception -> getMessage());
                }
            }
        ?>
        <!-- Creamos un formulario que apunte a este mismo archivo php pasandole como POST el id-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>"  method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
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