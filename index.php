<!DOCTYPE HTML>
<html>
<head>
	<title>PDO - Read Records - PHP CRUD Tutorial</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<style>
        .m-r-1em{ margin-right:1em; }
        .m-b-1em{ margin-bottom:1em; }
        .m-l-1em{ margin-left:1em; }
        .mt0{ margin-top:0; }
	</style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Read Products</h1>
        </div>
        <?php
            // Conexión a base de datos con el otro archivo (Importamos $con y sus funciones)
            include 'config/database.php';
            // page es la página actual, y si no hay definida, la por defecto es 1.
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            // Asignamos en una variable cuantos productos habrá por página.
            $records_per_page = 5;
            // calculate for the query LIMIT clause
            $from_record_num = ($records_per_page * $page) - $records_per_page;

            // SIMBOLO DOLAR
            $dolar = "$";

            // Selecciona los productos para la página actual
            $query = "SELECT id, name, description, price FROM products ORDER BY id DESC
            LIMIT :from_record_num, :records_per_page";
            $stmt = $con->prepare($query);
            // Asignamos los parametros del limit de las variables que tenemos creadas.
            $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
            $stmt->execute();
            // Devuelve el numero de filas devueltas
            $num = $stmt->rowCount();
            // Creamos un botón para ir al archivo de crear nuevo producto
            echo "<a href='create.php' class='btn btn-primary m-b-1em'>Crear nuevo producto</a>";
            // Chekeamos que no está vacia la BBDD
            if ($num>0) {
                //Iniciamos la tabla
                echo "<table class='table table-hover table-responsive table-bordered'>";
                //Creamos los headers de la tabla
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Description</th>";
                    echo "<th>Price</th>";
                    echo "<th>Action</th>";
                echo "</tr>";
                //Usamos fetch() para recorrer todas las filas
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    //Extramos una fila
                    extract($row);
                    // Creamos una fila por fila en la BBDD
                    echo "<tr>";
                        // Las variables vienen de la BBDD
                        echo "<td>{$id}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$description}</td>";
                        echo "<td>\${$price}</td>";
                        echo "<td>";
                            // Botón para entrar y leer el producto
                            echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";
                            // Botón para actualizar los datos del producto
                            echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";
                            // Botón para borrar el producto
                            echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                // Finalizamos la tabla
                echo "</table>";
                // PAGINATION
                // Cuenta el total de filas
                $query = "SELECT COUNT(*) as total_rows FROM products";
                $stmt = $con->prepare($query);
                // Ejecutamos la query
                $stmt->execute();
                // Conseguimos el total de filas
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $total_rows = $row['total_rows'];
                // Escribimos el nombre del archivo con un ? al final para añadir parámetros
                $page_url="index.php?";
                // Añadimos el código donde creamos la paginación
                include_once "paging.php";
                } else {
                    echo "<div class='alert-danger'>No hay datos en la BBDD</div>";
                }
            ?>
    </div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='text/javascript'>
// Borrar producto de la BBDDD
function delete_user( id ){
	var answer = confirm('Are you sure?');
	if (answer){
		// Si el usuario clicka en OK, pasa la id a delete.php y ejecuta la delete query 
		window.location = 'delete.php?id=' + id;
	} 
}
</script>
</body>
</html>