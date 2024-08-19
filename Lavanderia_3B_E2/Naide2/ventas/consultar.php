<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Renta</title>
  <link rel="stylesheet" href="css/estilo.css">
  <style>
    .btn__consult{
    display: inline-block;
    font-size: 20px;
    background: green;
    background-color: green;
    color: white;
    border-radius: 15px;
    padding: 15px 20px;
}
  </style>

</head>
<body>
  <div class="contenedor">
    <h2>CRUD EN PHP CON MYSQLX</h2>
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
      if(isset($_GET['folio'])){
        $folio=(int) $_GET['folio'];
        print "Valor del folio: ".$folio;
        $buscar_folio=$db->connect()->prepare('SELECT * FROM rentas WHERE folio=:folio LIMIT 1');
        $buscar_folio->setFetchMode(PDO::FETCH_ASSOC);
        $buscar_folio->execute(array(':folio'=>$folio));
        $row = $buscar_folio->fetch();
        if($buscar_folio -> rowCount() <= 0){
          echo "<br /><br /><h2>No existe ese número de folio.</h2>";
        }elseif ($buscar_folio -> rowCount() > 0){
          print ("<br/><br/><hr/><br/>");
          print ("Datos del registro.");
          print ("<br/><br/><hr/><br/>");
          print ("<table class='table table-striped'>");
            print ("<tr>");
              print ("<th>Folio</th>");
              print ("<td>".$row['folio']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Fecha de apartado</th>");
              print ("<td>" . $row['fecha_apartado'] . "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Nombre del cliente</th>");
              print ("<td>" . $row['nombre_cliente'] . "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Prendas</th>");
              print ("<td>" . $row['descripcion'] . "</td>");
              //$variable = utf8_decode($variable);
            print ("</tr>");
            print ("<tr>");
              print ("<th>Total de renta</th>");
              print ("<td>" .$row['monto_renta']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Accesorios</th>");
              print ("<td>" .$row['accesorios']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Lavado</th>");
              print ("<td>" .$row['lavado']. "</td>");
            print ("</tr>\n");
            print ("<tr>\n");
              print ("<th>Planchado</th>");
              print ("<td>" .$row['planchado']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Empacado</th>");
              print ("<td>" .$row['empacado']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Saldo Total</th>");
              print ("<td>" .$row['saldo_total']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Anticipo</th>");
              print ("<td>" . $row['anticipo'] . "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Pago</th>");
              print ("<td>" .$row['pago']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Saldo Pendiente</th>");
              print ("<td>" . $row['saldo_pendiente'] . "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Estado de Renta</th>");
              print ("<td>" . $row['estado_renta'] . "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Fecha de entrega</th>");
              print ("<td>" .$row['fecha_entrega']. "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Fecha de devolución</th>");
              print ("<td>" . $row['fecha_devolucion'] . "</td>");
            print ("</tr>");
            print ("<tr>");
              print ("<th>Pago Total</th>");
              print ("<td>" .$row['pago_total']. "</td>");
            print ("</tr>");
          print ("</table>");
          print ("<br /><hr />");
          print "<a href='menu.php' class='btn__consult'>Volver</a>";
        } 
      }else{
        header('Location: menu.php');
      }
    ?>
  </div>
</body>
</html>
