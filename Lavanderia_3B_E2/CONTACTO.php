<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Css/bootstrap.min.css">
  <title>CONTACTO LAVANDERIA</title>

</head>
<body>
<nav class="navbar">
      
      <a href="LAVANDERIAFL.html" class="button1">Inicio</a>
      <a href="Producto.html" class="button1">Producto</a>
      <a href="CONTACTO.php" class="button1">Contacto</a>
  
       
       
     
   </nav>
  <?php 
    include('database.php'); 
    $correo="";
    $nombre="";
    $genero="";
    $nivel="";
    $mensaje="";

    $db = new Database();
    $query = $db->connect()->prepare('select max(id) as id from contacto');
    $query->execute();
    $row = $query->fetch();
    $numero = $row["id"];
    $numero++;
    echo "valor de numero: ".$numero;
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h1>CONTACTO</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
          method="post">
          <div class="mb-3">
            <label for="folio" class="form-label mt-4">No.mensaje:</label>
            <input type="text" name="folio" id="folio"
                readonly class="form-control" value="<?php echo $numero; ?>">
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label mt-4">Correo:</label>
            <input type="text" name="correo" id="correo"
               class="form-control">
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label mt-4">Nombre:</label>
            <input type="text" name="nombre" id="nombre"
               class="form-control">
          </div>
          <div class="mb-3">
            <p class="h4">Selecciona tu género</p>
            <input type="radio" name="genero" id="masculino" value="masculino"
          class="form-check-input" checked>
          <label for="masculino" class="form-check-label">Masculino</label>
          
          <input type="radio" name="genero" id="femenino" value="femenino"
          class="form-check-input">
          <label for="femenino" class="form-check-label">Femenino</label>
          </div>
         <div>
          <p class="h4">Selecciona tu edad:</p>
          <label for="grado" class="form-label mt-4"></label>
          <select name="grado" id="grado" class="form-select">
            <option value="18-20">18-20</option>
            <option value="21-30">21-30</option>
            <option value="31-40">31-40</option>
            <option value="45-50">45-50</option>
            <option value="50">50 o mas</option>
          </select>
         </div>
          <div>
            <p class="h4">Agrega tu mensaje:</p>
           
            <textarea name="mensaje" id="mensaje" cols="20" rows="7"></textarea>
            <br>
            <button type="submit" class="btn btn-primary"
              name="enviar">Enviar datos</button>
          </div>
        </form>
      </div>
      <?php
        if (isset($_REQUEST['enviar'])){
          $correo=$_POST['correo'];
          $nombre=$_POST['nombre'];
          $genero=$_POST['genero'];
          $grado=$_POST['grado'];
          $mensaje=$_POST['mensaje'];



          $query = $db->connect()->prepare('select correo from contacto 
            where correo = :correo');
            $query->execute(['correo'=>$correo]);
          if($query->rowCount()<=0){
            echo "SI ENTRO AL IF....";
            $nombre = $_POST['nombre'];
            $insert='insert into contacto(correo,nombre,genero,nivel, mensaje) 
            values(:correo, :nombre, :genero,:grado, :mensaje)';
            $insert=$db->connect()->prepare($insert);

            $insert->bindParam(':correo',$correo,PDO::PARAM_STR,50);
            $insert->bindParam(':nombre',$nombre,PDO::PARAM_STR,50);
            $insert->bindParam(':genero',$genero,PDO::PARAM_STR,10);
            $insert->bindParam(':grado',$grado,PDO::PARAM_STR,6);
            $insert->bindParam(':mensaje',$mensaje,PDO::PARAM_STR,300);

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