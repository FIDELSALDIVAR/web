<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="css2/bootstrap.min.css">
    
</head>
<body>
<?php include ("database.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                    Noticias Registradas
                </a>
                <a href="altas3.php" class="list-group-item list-group-item-action">Altas</a>
                <a href="consultas.php" class="list-group-item list-group-item-action">Consultas</a>
                <a href="cambios.php" class="list-group-item list-group-item-action">Cambios</a>
                <a href="bajas.php" class="list-group-item list-group-item-action">Bajas</a>
                <a href="login.php" class="list-group-item list-group-item-action">Volver al Login</a>
            </div>
        </div>
        <div class="col-md-8">
            <h1>Listado de noticias Registradas</h1>
            <?php
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM ejemploo ORDER BY id DESC');
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();

            if($query->rowCount() > 0) {
                echo "<h4>Registros encontrados</h4>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr>";
                echo "<th>Id</th>";
                echo "<th>correo</th>";
                echo "<th>nombre</th>";
                echo "<th>genero</th>";
                echo "<th>nivel</th>";
                echo "<th>mensaje</th>";
                echo "<tbody>";
                while($row = $query->fetch()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['correo']."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    echo "<td>".$row['genero']."</td>";
                    echo "<td>".$row['nivel']."</td>";
                    echo "<td>".$row['mensaje']."</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<h4>No hay registros disponibles</h4>";
            }
            ?>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
