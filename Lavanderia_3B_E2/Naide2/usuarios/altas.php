<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['grado']) || $_SESSION['grado'] != 1) {
    header('Location: ../login.php');
    exit();
}

include('../DATABASE.php');
$correo = "";
$nombre = "";
$paterno = "";
$materno = "";
$grado = "";
$fecha = date('d-m-Y');
$db = new Database();
$query = $db->connect()->prepare('SELECT MAX(id) AS id FROM usuarios');
$query->execute();
$row = $query->fetch();
$numero = $row['id'] + 1;
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php include('menuLateral.php'); ?>
        </div>
        <div class="col-md-8">
            <h1>Ejemplo de alta en la base de datos</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="" class="form-label mt-4">Fecha:</label>
                    <span><?php echo htmlspecialchars($fecha); ?></span>
                </div>
                <div class="mb-3">
                    <label for="folio" class="form-label mt-4">Id:</label>
                    <input type="text" name="folio" id="folio" readonly class="form-control" value="<?php echo htmlspecialchars($numero); ?>">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label mt-4">Correo:</label>
                    <input type="email" name="correo" id="correo" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label mt-4">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="paterno" class="form-label mt-4">Apellido Paterno:</label>
                    <input type="text" name="paterno" id="paterno" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="materno" class="form-label mt-4">Apellido Materno:</label>
                    <input type="text" name="materno" id="materno" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="grado" class="form-label mt-4">Grado:</label>
                    <select name="grado" id="grado" class="form-select" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="enviar">Enviar Datos</button>
            </form>

            <?php
            if (isset($_POST['enviar'])) {
                $correo = $_POST['correo'];
                $nombre = $_POST['nombre'];
                $grado = $_POST['grado'];
                $paterno = $_POST['paterno'];
                $materno = $_POST['materno'];
                
                $query = $db->connect()->prepare('SELECT correo FROM usuarios WHERE correo = :correo');
                $query->execute(['correo' => $correo]);

                if ($query->rowCount() <= 0) {
                    $insert = 'INSERT INTO usuarios (correo, nombre, grado, paterno, materno) VALUES (:correo, :nombre, :grado, :paterno, :materno)';
                    $insertStmt = $db->connect()->prepare($insert);
                    $insertStmt->bindParam(':correo', $correo, PDO::PARAM_STR, 50);
                    $insertStmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 50);
                    $insertStmt->bindParam(':paterno', $paterno, PDO::PARAM_STR, 50);
                    $insertStmt->bindParam(':materno', $materno, PDO::PARAM_STR, 50);
                    $insertStmt->bindParam(':grado', $grado, PDO::PARAM_INT);
                    $insertStmt->execute();
                    echo 'DATOS REGISTRADOS';
                } else {
                    echo '<script type="text/javascript">
                            alert("CORREO YA REGISTRADO INTENTA CON OTRO")
                          </script>';
                }
            }
            ?>
        </div>
        <div class="col-md-12">
            <p class="h4"><?php echo "Usuario: " . htmlspecialchars($_SESSION['usuario']); ?></p>
            <hr>
        </div>
    </div>
</div>
</body>
</html>
