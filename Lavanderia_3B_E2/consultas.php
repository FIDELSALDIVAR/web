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
    $folio="";
 
    ?>
  <div class="container">
    <div class="row">
    <div class="col-md-4">
      <div class="list-group">
	<a href="" class="list-group-item list-group-item-action " aria-current="true">
		 BD APLICACION
	</a>
	<a href="APLICACION.php" class="list-group-item list-group-item-action">Altas</a>
	<a href="consultas.php" class="list-group-item list-group-item-action active">Consultas</a>
	<a href="cambios.php" class="list-group-item list-group-item-action">Cambios</a>
	<a href="bajas.php" class="list-group-item list-group-item-action">Bajas</a>
    <a href="LAVANDERIAFL.html" class="list-group-item list-group-item-action">Inicio</a>

	<a href="login.php" class="list-group-item list-group-item-action">Cerrar sesión</a>
</div>
      </div>

      <div class="col-md-7">
        
        <h1>CONSULTAS APLICACION</h1>
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
            
            <label for="folio" class="form-label">Folio a buscar</label>
            <input type="text" name="folio" id="folio" class="form-control" autofocus>
          </div>
          <br>
          <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Mostrar registro" name="buscar">
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Mostrar todo" name="todo">
          </div>
        </form>
        
        <?php
             $db= new Database();
        if (isset($_REQUEST['todo'])){
       
            $query = $db->connect()->prepare('select id,correo,nombre,paterno,materno,clave,grado from ejemplo2');
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            //$row = $query->fetch();
            if($query->rowCount()>=0){
                print "<h4>Registros encontrados</h4>";
                print "<table class='table table-striped'>";
                 print "<tr>";
                 print "<th>Id</th>";
                 print "<th>correo</th>";
                 print "<th>nombre</th>";
                 print "<th>paterno</th>";
                 print "<th>materno</th>";
                 print "<th>clave</th>";
                 print "<th>grado</th>";
                 print "</tr>";
            while ($row=$query->fetch()){
                print ("<tr>");
                print ("<td>".$row['id']."</td>");
                print ("<td>".$row['correo']."</td>");
                print ("<td>".$row['nombre']."</td>");
                print ("<td>".$row['paterno']."</td>");
                print ("<td>".$row['materno']."</td>");
                print ("<td>".$row['clave']."</td>");

                print ("<td>".$row['grado']."</td>");
                print "</tr>";

            }   
            }else if($query->rowCount()<=0){
                print "<h4>No hay registros disponibles</h4>";
            }
        }
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
                print ("<th>Paterno</th>\n");
                print ("<td>" .$row['paterno']. "</td>\n");
              print ("</tr>\n");
              print ("<th>Materno</th>\n");
                print ("<td>" .$row['materno']. "</td>\n");
              print ("</tr>\n");
              print ("<tr>\n");
              print ("<th>clave</th>\n");
                print ("<td>" .$row['clave']. "</td>\n");
              print ("</tr>\n");
              print ("<tr>\n");
                print ("<th>grado</th>\n");
                print ("<td>" . $row['grado'] . "</td>\n");
              print ("</tr>\n");
            print ("</table>\n");
            print ("<br /><hr />");
          } 
        }
        ?>
      </div>
     
    </div>
    <div class="col-md-1"></div>
  </div>
</body>
</html>