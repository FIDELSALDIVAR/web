<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambios</title>
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

$folio = isset($_REQUEST['folio']) ? $_REQUEST['folio'] : null;
$db = new Database();
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php include('menuLateral.php'); ?>
        </div>
        <div class="col-md-7">
            <h1>Ejemplo de cambios en registro en bases de datos</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="folio" class="form-label">Folio a modificar</label>
                    <input type="text" name="folio" id="folio" class="form-control" value="<?php echo htmlspecialchars($folio); ?>" autofocus>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Buscar Registro" name="buscar">
                </div>

                <?php
                if (isset($_REQUEST['buscar'])) {
                    $folio = isset($_REQUEST['folio']) ? $_REQUEST['folio'] : null;
                    $query = $db->connect()->prepare('SELECT * FROM usuarios WHERE id = :folio');
                    $query->setFetchMode(PDO::FETCH_ASSOC);
                    $query->execute(['folio' => $folio]);
                    $row = $query->fetch();
                    if ($query->rowCount() <= 0) {
                        echo "<br /><br /><h2>No existe ese número de folio.</h2>";
                    } else {
                        echo '
                        <div>
                            <label for="correo" class="form-label mt-4">Correo:</label>
                            <input type="text" name="correo" id="correo" class="form-control" value="'.htmlspecialchars($row['correo']).'">
                        </div>
                        <div>
                            <label for="nombre" class="form-label mt-4">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="'.htmlspecialchars($row['nombre']).'">
                        </div>
                        <div>
                            <p class="h4">Selecciona el grado:</p>
                            <label for="grado" class="form-label mt-4">Grado</label>
                            <select name="grado" id="grado" class="form-select">
                                <option value="'.htmlspecialchars($row['grado']).'">'.htmlspecialchars($row['grado']).'</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning mt-3" name="cambiar">Modificar datos</button>
                        ';
                    }
                }

                if (isset($_REQUEST['cambiar'])) {
                    $nombre = $_REQUEST['nombre'];
                    $correo = $_REQUEST['correo'];
                    $grado = $_REQUEST['grado'];
                    $folio = $_REQUEST['folio'];

                    $sql = "UPDATE usuarios SET nombre = ?, correo = ?, grado = ? WHERE id = ?";
                    $stmt = $db->connect()->prepare($sql);
                    $stmt->execute([$nombre, $correo, $grado, $folio]);

                    if ($stmt->rowCount() > 0) {
                        echo "Datos modificados";
                        echo "<hr/><br/>";
                        echo "<table class='table table-striped'>";
                        echo "<tr><th>Folio</th><td>$folio</td></tr>";
                        echo "<tr><th>Nombre</th><td>$nombre</td></tr>";
                        echo "<tr><th>Correo</th><td>$correo</td></tr>";
                        echo "<tr><th>Grado</th><td>$grado</td></tr>";
                        echo "</table>";
                    } else {
                        echo "No se modificó el registro";
                    }
                }
                ?>
            </form>
        </div>
        <div class="col-md-1">
            <p class="h4"><?php echo "Usuario: " . htmlspecialchars($_SESSION['usuario']); ?></p>
        </div>
    </div>
</div>
</body>
</html>
