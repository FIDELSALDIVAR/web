         <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
        }

        h1 {
            color: #343a40;
            margin-bottom: 30px;
        }

        table.table-striped {
            width: 100%;
            margin-top: 20px;
        }

        table.table-striped th, table.table-striped td {
            padding: 10px;
            text-align: left;
        }

        table.table-striped th {
            background-color: #007bff;
            color: white;
        }

        table.table-striped tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php
session_start();
if(!isset($_SESSION['grado'])){
    header('location:../login.php');
}else{
    if($_SESSION['grado'] !=1){
        header('location:../login.php');
    }
}

include ("../DATABASE.php");
$folio="";
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
        <?php include('menuLateral.php'); ?>
        </div>
        <div class="col-md-6">
            <h1>Registros de la tabla ejemplos</h1>
            <?php
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM usuarios ORDER BY id DESC');
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();

            if($query->rowCount() > 0) {
                echo "<h4>Registros encontrados</h4>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr>";
                echo "<th>Id</th>";
                echo "<th>Correo</th>";
                echo "<th>Nombre</th>";;
                echo "<th>Grado</th>";
                echo "</tr></thead>";
                echo "<tbody>";
                while($row = $query->fetch()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['correo']."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    echo "<td>".$row['grado']."</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<h4>No hay registros disponibles</h4>";
            }
            ?>
        </div>
        <div class="col-md-2">
        <p class="h4"><?php echo "Usuario: ". $_SESSION['usuario']; ?></p>

        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
