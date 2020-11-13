<!DOCTYPE HTML>
<html>
<head>
	<title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Read Product</h1>
        </div>
            <?php
                //Confirmamos que mediante GET ha llegado el ID del producto
                $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
                // Conexión a base de datos con el otro archivo (Importamos $con y sus funciones)
                include 'config/database.php';
                // Leemos los datos del producto
                try {
                    // Preparamos la query escrita
                    $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);
                    // Enlazamos el parámetro id pasado por get a la query por el "?"
                    $stmt -> bindParam(1, $id);
                    // Ejecutamos la query
                    $stmt -> execute();
                    // Guardamos la fila recibida en una variable
                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
                    // Guardamos los datos del producto en variables para utilizarlas en el formulario HTML
                    $name = $row['name'];
                    $description = $row['description'];
                    $price = $row['price'];
                }
                // Si hay algun error lo mostramos
                catch( PDOException $exception) {
                    die('ERROR: ' . $exception -> getMessage());
                }
            ?>
            <!-- Creamos la tabla y en los valor hacemos un echo de las variables de antes -->
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><?php echo "€".htmlspecialchars($price, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
	</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>