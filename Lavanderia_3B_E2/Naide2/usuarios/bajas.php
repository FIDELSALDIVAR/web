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
if(!isset($_SESSION['grado'])){
    header('location:../login.php');
}else{
    if($_SESSION['grado'] !=1){
        header('location:../login.php');
    }
}

        
       include ("../DATABASE.php");
       $folio= isset($_REQUEST['folio'])? $_REQUEST['folio']: null;
      
?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
            <?php include('menuLateral.php'); ?>
            </div>
            <div class="col-md-7">
                <h1>Ejemplo de eliminar registro en base de datos</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
                <div class="mb-3">
                <label for="folio" class="form-label">Folio a eliminar</label>
                <input type="text" name="folio" id="folio" value="<?php echo $folio?>" class="form-control" autofocus>
                
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Buscar Folio" name="buscar"> 
            </div>
            

           
            <?php
            
            $db = new Database();
            if (isset($_REQUEST['buscar'])){
                $folio=isset($_REQUEST['folio']) ? $_REQUEST['folio'] :  null;
                $query = $db->connect()->prepare('select * FROM usuarios where id = :folio');
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute(['folio' => $folio]);
                $row = $query->fetch();
                if($query -> rowCount() <= 0){
                    echo "<br /><br /><h2>No existe ese número de folio.</h2>";
                }elseif ($query -> rowCount() > 0){
                    print ("Datos del registro.");
                    print ("<br/><br/><hr/><br/>");
                    print ("<table class='table table-striped'>\n");
                        print ("<tr>\n");
                            print ("<th>Id</th>\n");
                            print ("<td>".$row['id']. "</td>\n");
                        print ("</tr>\n");
                        print ("<tr>\n");
                            print ("<th>Correo</th>\n");
                            print ("<td>" . $row['correo'] . "</td>\n");
                        print ("</tr>\n");
                        print ("<tr>\n");
                            print ("<th>Nombre</th>\n");
                            print ("<td>" . $row['nombre'] . "</td>\n");
                        print ("</tr>\n");
                        print ("<tr>\n");
                            print ("<th>Apellido Paterno</th>\n");
                            print ("<td>" .$row['paterno']. "</td>\n");
                        print ("</tr>\n");
                        print ("<tr>\n");
                            print ("<th>Apellido Materno</th>\n");
                            print ("<td>" .$row['materno']. "</td>\n");
                        print ("</tr>\n");
                        print ("<tr>\n");
                            print ("<th>Grado</th>\n");
                            print ("<td>" . $row['grado'] . "</td>\n");
                        print ("</tr>\n");
                    print ("</table>\n");
                    print ("<br /><hr />");
                    print ("<input type='submit' name='borrar' value='Eliminar registro' class='btn btn-danger'> </form>");
                }
            }
            if(isset($_REQUEST['borrar'])){
                $folio= isset($_REQUEST['folio'])? $_REQUEST['folio']: null;
                $query = $db->connect()->prepare('delete from usuarios where id = :folio');
                $query->execute(['folio'=>$folio]);
                if(!$query){
                    echo "Error: " .$query->errorinfo();
                }
                echo "<h4>Folio eliminado</h4>";
                $query->closeCursor();
                $query=null;
                $db=null;

            }
            
            ?>
            
            </div>
            <div class="col-md-1">
            <p class="h4"><?php echo "Usuario: ". $_SESSION['usuario']; ?></p>
            </div>
        
</body>
</html>