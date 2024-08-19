<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Css/bootstrap.min.css">
  <title>REGISTRO DE USUARIOS</title>

</head>
<body>
<nav class="navbar">
      
<a href="LAVANDERIAFL.html" class="button1">Regresar a inicio</a>
<a href="./Naide2/login.php" class="button1">Ingresar a la aplicacion</a>
      
  
       
       
     
   </nav>
  <?php 
    include('database.php'); 
    $correo="";
    $nombre="";
    $paterno="";
    $materno="";
    $clave="";
    $grado="";

    $db = new Database();
    $query = $db->connect()->prepare('select max(id) as id from aplicacion');
    $query->execute();
    $row = $query->fetch();
    $numero = $row["id"];
    $numero++;
    echo "valor de numero: ".$numero;
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-4">

      </div>
      <div class="col-md-6">
        <h1>APLICACION</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
          method="post">
          <div class="mb-3">
            <label for="" class="class=form-label mt-4">FECHA:</label>
            <input type="date" class="form-control"
            id="fecha"
            name="apartado"
            value="<?php echo date("Y-m-d");?>"
            reandonly>
            <label for="folio" class="form-label mt-4">No. de registro:</label>
            <input type="text" name="folio" id="folio"
                readonly class="form-control" value="<?php echo $numero; ?>">
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label mt-4">Nombre:</label>
            <input type="text" name="nombre" id="nombre"
               class="form-control" class="form-control" autofocus>
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label mt-4">Apellido paterno:</label>
            <input type="text" name="paterno" id="paterno"
               class="form-control">
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label mt-4">Apellido materno:</label>
            <input type="text" name="materno" id="materno"
               class="form-control">
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label mt-4">Correo:</label>
            <input type="text" name="correo" id="correo"
               class="form-control">
          </div>
          <div class="mb-3">
            <label for="clave" class="form-label mt-4">clave:</label>
            <input type="password" name="clave" id="clave"
               class="form-control">
          </div>
          <p class="h4">Selecciona tu grado:</p>
          <label for="grado" class="form-label mt-4"></label>
          <select name="grado" id="grado" class="form-select">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
         </div>
          <div>
            <button type="submit" class="btn btn-primary"
              name="enviar">Enviar datos</button>
          </div>
        </form>
      </div>
      <?php
        if (isset($_REQUEST['enviar'])){
          $correo=$_POST['correo'];
          $nombre=$_POST['nombre'];
          $paterno=$_POST['paterno'];
          $materno=$_POST['materno'];
          $clave=$_POST['clave'];
          $grado=$_POST['grado'];



          $query = $db->connect()->prepare('select correo from aplicacion
            where correo = :correo');
            $query->execute(['correo'=>$correo]);
          if($query->rowCount()<=0){
            echo "SI ENTRO AL IF....";
            $nombre = $_POST['nombre'];
            $insert='insert into aplicacion(correo,nombre,paterno,materno,clave,grado) 
            values(:correo, :nombre, :paterno,:materno,:clave,:grado)';
            $insert=$db->connect()->prepare($insert);

            $insert->bindParam(':correo',$correo,PDO::PARAM_STR,50);
            $insert->bindParam(':nombre',$nombre,PDO::PARAM_STR,50);
            $insert->bindParam(':paterno',$paterno,PDO::PARAM_STR,30);
            $insert->bindParam(':materno',$materno,PDO::PARAM_STR,30);
            $insert->bindParam(':clave',$clave,PDO::PARAM_STR,30);
            $insert->bindParam(':grado',$grado,PDO::PARAM_STR,6);

 $insert->execute();
            echo 'DATOS REGISTRADOS!!!';
          }
            else if($query->rowCount()>0){
             echo'<script type="text/javascrpt">
             alert("CORREO YA REGISTRADO INTENTA CON OTRO!!!);
             </script>';
            }
          
        }
      ?>
      <div class="col-md-2"></div>
    </div>
  </div>
</body>
</html>