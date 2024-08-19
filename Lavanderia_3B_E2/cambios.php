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
    $db = new Database();
 ?>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
      <div class="list-group">
	<a href="" class="list-group-item list-group-item-action " aria-current="true">
		BD CAMBIOS
	</a>
    <a href="APLICACION.php" class="list-group-item list-group-item-action">Altas</a>
	<a href="consultas.php" class="list-group-item list-group-item-action">Consultas</a>
	<a href="cambios.php" class="list-group-item list-group-item-action active">Cambios</a>
	<a href="bajas.php" class="list-group-item list-group-item-action">Bajas</a>
    <a href="LAVANDERIAFL.html" class="list-group-item list-group-item-action">Inicio</a>

	<a href="#" class="list-group-item list-group-item-action">Cerrar sesión</a>
</div>
      </div>
      <div class="col-md-7">
        
        <h1>CAMBIOS APLICACION</h1>
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
            <label for="folio" class="form-label">Folio a modificar</label>
            <input type="text" name="folio" id="folio" class="form-control" autofocus value="<?php echo $folio ?>">
          </div>
          <br>
          <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Buscar registro" name="buscar">
          </div>
       
        <?php
             if (isset($_REQUEST['buscar'])){
                $folio=isset($_REQUEST['folio']) ? $_REQUEST['folio'] :  null;
                $query = $db->connect()->prepare('select * FROM ejemplo2 where id = :folio');    
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute(['folio' => $folio]);
                $row = $query->fetch();
                if($query -> rowCount() <= 0){
                  echo "<br /><br /><h2>No existe ese número de folio.</h2>";
                }elseif ($query -> rowCount() > 0){
                                  
                print('<div class="mb-3">
                    <label for="correo" class="form-label mt-4">Correo:</label>
                    <input type="text" name="correo" id="correo"
                    class="form-control" value="'.$row['correo'].'">
                </div>
                 ');
                 print ('
                 <div class="mb-3">
                    <label for="nombre" class="form-label mt-4">Nombre:</label>
                    <input type="text" name="nombre" id="nombre"
                    class="form-control" value= "'.$row['nombre'].'">
                 </div> 
                 ');
                 print ('
                 <div class="mb-3">
                    <label for="paterno" class="form-label mt-4">Paterno:</label>
                    <input type="text" name="paterno" id="paterno"
                    class="form-control" value= "'.$row['paterno'].'">
                 </div> 
                 ');
                 print ('
                 <div class="mb-3">
                    <label for="materno" class="form-label mt-4">Materno:</label>
                    <input type="text" name="materno" id="materno"
                    class="form-control" value= "'.$row['materno'].'">
                 </div> 
                 ');
                 print ('
                 <div class="mb-3">
                    <label for="clave" class="form-label mt-4">clave:</label>
                    <input type="clave" name="clave" id="clave"
                    class="form-control" value= "'.$row['clave'].'">
                 </div> 
                 ');
                 print('
                 <div>
                        <p class="h4">Selecciona el grado:</p>
                    <label for="grado" class="form-label mt-4">grado</label>
                    <select name="grado" id="grado" class="form-select">
                        <option value="'.$row['grado'].'">'.$row['grado'].'</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                 </div>
                 ');
                 print('
                 <div>
                        <br>
                     <button type="submit" class="btn btn-warning" 
                     name="cambiar">Modificar datos</button>
                 </div>
                 ');
                }//else if 
            }//boton buscar 
            if (isset ($_REQUEST['cambiar'])){
              $nombre = $_REQUEST['nombre'];
              $paterno = $_REQUEST['paterno'];
              $materno = $_REQUEST['materno'];
              $clave = $_REQUEST['clave'];

              $grado=$_REQUEST['grado'];
              $sql ="UPDATE ejemplo2 SET nombre=?, paterno=?,materno=?,clave=?, grado=? WHERE id=?";
              $stmt = $db->connect() ->prepare($sql);
              $stmt -> execute([$nombre, $paterno, $materno,$clave, $grado, $folio]);
              $row =$stmt->fetch();
              if ($stmt->rowCount()>0){
                echo "Datos modificados!!!";
              }else if ($stmt->rowCount()<=0){
                echo "No se actualizo el registro";
              }
            }
        ?>
         </form>
    </div>
   <div class="col-md-1"></div>
</div>
</body>