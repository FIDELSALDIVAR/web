<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['grado']) || $_SESSION['grado'] != 1) {
    header('Location: ../login.php');
    exit();
}

include ("../DATABASE.php");
$folio = "";
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php include('menuLateral.php'); ?>
        </div>
        <div class="col-md-8">
            <h1>Ejemplo de consulta en base de datos</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="folio" class="form-label">Folio a buscar</label>
                    <input type="text" name="folio" id="folio" class="form-control" value="<?php echo htmlspecialchars($folio); ?>" autofocus>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Mostrar Registro" name="buscar">
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Mostrar todo" name="todo">
                </div>
            </form>

            <?php
            $db = new Database();

            // Mostrar todos los registros
            if (isset($_REQUEST['todo'])) {
                $query = $db->connect()->prepare('SELECT * FROM usuarios ORDER BY id DESC');
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();
                
                if ($query->rowCount() > 0) {
                    echo "<h4>Registros encontrados</h4>";
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Id</th>";
                    echo "<th>Correo</th>";
                    echo "<th>Nombre</th>";
                    echo "<th>Paterno</th>";
                    echo "<th>Materno</th>";
                    echo "<th>Grado</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = $query->fetch()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['paterno']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['materno']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['grado']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<h4>No hay registros disponibles</h4>";
                }
            }

            // Buscar un registro específico
            if (isset($_REQUEST['buscar'])) {
                $folio = isset($_REQUEST['folio']) ? $_REQUEST['folio'] : null;
                $query = $db->connect()->prepare('SELECT * FROM usuarios WHERE id = :folio');
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute(['folio' => $folio]);
                $row = $query->fetch();
                
                if ($query->rowCount() <= 0) {
                    echo "<br /><br /><h2>No existe ese número de folio.</h2>";
                } else {
                    echo "<h4>Datos del registro</h4>";
                    echo "<br /><br /><hr /><br />";
                    echo "<table class='table table-striped'>";
                    echo "<tr>";
                    echo "<th>Id</th>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Correo</th>";
                    echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Nombre</th>";
                    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Paterno</th>";
                    echo "<td>" . htmlspecialchars($row['paterno']) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Materno</th>";
                    echo "<td>" . htmlspecialchars($row['materno']) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Grado</th>";
                    echo "<td>" . htmlspecialchars($row['grado']) . "</td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "<br /><hr />";
                }
            }
            ?>

        </div>
        <div class="col-md-12">
            <p class="h4"><?php echo "Usuario: " . htmlspecialchars($_SESSION['usuario']); ?></p>
        </div>
    </div>
</div>
</body>
</html>
