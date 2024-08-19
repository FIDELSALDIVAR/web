<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>Consultas</title>
</head>
<body>
    <?php
    include("DATABASE.php");
    $folio = isset($_REQUEST['folio'])? $_REQUEST['folio']:null;
 
    ?>
  <div class="container">
    <div class="row">
    <div class="col-md-4">
      <div class="list-group">
	<a href="" class="list-group-item list-group-item-action " aria-current="true">
		BD BAJAS
	</a>
	<a href="APLICACION.php" class="list-group-item list-group-item-action">Altas</a>
	<a href="consultas.php" class="list-group-item list-group-item-action">Consultas</a>
	<a href="cambios.php" class="list-group-item list-group-item-action">Cambios</a>
	<a href="bajas.php" class="list-group-item list-group-item-action active">Bajas</a>
  <a href="LAVANDERIAFL.html" class="list-group-item list-group-item-action">Inicio</a>

	<a href="#" class="list-group-item list-group-item-action">Cerrar sesión</a>
</div>
      </div>

      <div class="col-md-7">
        <h1>BAJAS APLICACION</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
          method="post">
          <div classs="mb-3">
            <label for="" class="class=form-label mt-4">FECHA:</label>
            <input type="date" class="form-control"
            id="fecha"
            name="apartado"
            value="<?php echo date("Y-m-d");?>"
            reandonly>
          <div classs="mb-3">
            <label for="folio" class="form-label">Folio a eliminar</label>
            <input type="text" name="folio" id="folio" class="form-control" autofocus value= <?php echo $folio ?>>
             
          </div>
          <br>
          <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="buscar registro" name="buscar">
          </div>
          
        <?php
        $db=new DATABASE();
        if (isset($_REQUEST['buscar'])){
          $folio=isset($_REQUEST['folio']) ? $_REQUEST['folio'] :  null;
          $query = $db->connect()->prepare('select * FROM ejemplo2 where id = :folio');    
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
                print ("<th>paterno</th>\n");
                print ("<td>" .$row['paterno']. "</td>\n");
              print ("</tr>\n");
              print ("<th>materno</th>\n");
                print ("<td>" .$row['materno']. "</td>\n");
              print ("</tr>\n");
                print ("<th>grado</th>\n");
                print ("<td>" . $row['grado'] . "</td>\n");
              print ("</tr>\n");
            print ("</table>\n");
            print ("<br /><hr />");
            print ("<input type='submit' name='borrar'
                          value='Eliminar registro'> </form>");
          }
          
        }
        if(isset($_REQUEST['borrar'])){
          echo "si entro a borrar";
          $folio = isset($_REQUEST['folio']) ? $_REQUEST['folio']: null; 
          $query = $db->connect()->prepare('delete from ejemplo2 where id= :folio');
          $query->execute(['folio'=>$folio]);
            if(!$query){
              echo "Error: ".$query->errorInfo();
            }
            echo "<h4>Folio eliminado</h4>";
            $query->closeCursor();
            $query=null;
            $db=null;
        } 
        ?>
      </div>

    </div>
    <div class="col-md-1"></div>
  </div>
</body>
</html>