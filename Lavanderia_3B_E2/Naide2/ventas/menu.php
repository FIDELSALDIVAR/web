<?php
session_start();
if(!isset($_SESSION['grado'])){
    header('location:../login.php');
}else{
    if($_SESSION['grado'] !=2){
        header('location:../login.php');
    }
}
    include_once '../DATABASE.php';
    $db = new Database();
    
    $query = $db->connect()->prepare('SELECT * FROM rentas ORDER BY folio ASC');
    $query->execute();
    $resultado=$query->fetchAll();

  // metodo buscar
  if(isset($_POST['btn_buscar'])){
    $buscar_text=$_POST['buscar'];
    $select_buscar=$db->connect()->prepare('
      SELECT * FROM rentas WHERE nombre_cliente LIKE :campo OR estado_renta LIKE :campo;'
    );

    $select_buscar->execute(array(
      ':campo' =>"%".$buscar_text."%"
    ));

    $resultado=$select_buscar->fetchAll();

  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio</title>
  <link rel="stylesheet" href="css/estilo.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <style>
    .btn__consult{
    display: inline-block;
    font-size: 14px;
    background: yellow;
    background-color: gold;
    color: black;
    border-radius: 5px;
    padding: 5px 10px;
}
  </style>

</head>
<body>
  <div class="contenedor">
    <h2>CAPTURA DE RENTAS DEL SISTEMA.</h2>
    <div class="barra__buscador">
      <form action="" class="formulario" method="post">
        <input type="text" name="buscar" placeholder="buscar nombre o estado de la renta" 
        value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
        <input type="submit" class="btn" name="btn_buscar" value="Buscar">
        <a href="insert.php" class="btn btn__nuevo">Nuevo</a>
        <a href="../cerrar.php" class="btn btn-info" role="button">Cerrar Sesión</a>
        
      </form>
    </div>
    <table>
      <tr class="head">
        <td>Folio</td>
        <td>Apartado</td>
        <td>Cliente</td>
        <td>Descripción</td>
        <td>Saldo pendiente</td>
        <td>Estado renta</td>
        <td colspan="3">Acción</td>
      </tr>
      <?php foreach($resultado as $fila):?>
        <tr >
          <td><?php echo $fila['folio']; ?></td>
          <td><?php echo $fila['fecha_apartado']; ?></td>
          <td><?php echo $fila['nombre_cliente']; ?></td>
          <td><?php echo $fila['descripcion']; ?></td>
          <td><?php echo $fila['saldo_pendiente']; ?></td>
          <td><?php echo $fila['estado_renta']; ?></td>
          <td><a href="update.php?folio=<?php echo $fila['folio']; ?>" class="btn__update" >Editar</a></td>
          <td><a href="delete.php?folio=<?php echo $fila['folio']; ?>" class="btn__delete">Eliminar</a></td>
          <td><a href="consultar.php?folio=<?php echo $fila['folio']; ?>" class="btn__consult">Consultar</a></td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
</body>
</html>