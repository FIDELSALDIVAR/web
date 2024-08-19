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
		$query = $db->connect()->prepare('select max(folio) as maximo FROM rentas');
		$query->execute();
		$row = $query->fetch();
		$numero=$row["maximo"];
		$numero++;
		$pago_total=0;
		$fecha_apartado = date('Y-m-d');
			//print "Valor de fecha de apartado: ".$fecha_apartado;
	if(isset($_POST['guardar'])){
		$nombre_cliente=$_POST['nombre_cliente'];
		$descripcion=$_POST['descripcion'];
		$monto_renta=$_POST['monto_renta'];
		$anticipo=$_POST['anticipo'];
		$estado_renta=$_POST['estado_renta'];
		$fecha_apartado = date('Y-m-d');
		$accesorios = $_POST['accesorios'];
		$lavado=isset($_REQUEST['lavado']) ? $_REQUEST['lavado'] : 0;
		$planchado=isset($_REQUEST['planchado']) ? $_REQUEST['planchado'] : 0;
		$empacado=isset($_REQUEST['empacado']) ? $_REQUEST['empacado'] : 0;
		$pago=isset($_REQUEST['pago']) ? $_REQUEST['pago'] : 0;
		$pago_total=((int)$anticipo+(int)$pago);
		$saldo_total = (int)$monto_renta+(int)$accesorios+(int)$lavado+(int)$planchado+(int)$empacado;
		$saldo_pendiente=(int)$saldo_total-((int)$anticipo+(int)$pago);
		$entrega = $_POST['entrega'];
		$fecha_devolucion = strtotime('+5 day', strtotime($entrega));
		$fecha_devolucion = date('Y-m-d', $fecha_devolucion);

		if(!empty($nombre_cliente) && !empty($descripcion) && !empty($monto_renta) && !empty($anticipo)){
				$consulta_insert=$db->connect()->prepare('INSERT INTO rentas(nombre_cliente,descripcion,monto_renta,anticipo,estado_renta,fecha_apartado,saldo_pendiente,pago_total,
																									fecha_entrega,fecha_devolucion,accesorios,lavado,planchado,empacado,saldo_total) 
																									VALUES(:nombre_cliente,:descripcion,:monto_renta,:anticipo,:estado_renta,:fecha_apartado,:saldo_pendiente,:pago_total,
																									:entrega,:fecha_devolucion,:accesorios,:lavado,:planchado,:empacado,:saldo_total)');
				$consulta_insert->execute(array(
					':nombre_cliente' =>$nombre_cliente,
					':descripcion' =>$descripcion,
					':monto_renta' =>$monto_renta,
					':anticipo' =>$anticipo,
					':estado_renta' =>$estado_renta,
					':fecha_apartado' =>$fecha_apartado,
					':saldo_pendiente' =>$saldo_pendiente,
					':pago_total' =>$pago_total,
					':entrega' => $entrega,
					':fecha_devolucion' => $fecha_devolucion,
					':accesorios' => $accesorios,
					':lavado' => $lavado,
					':planchado' => $planchado,
					':empacado' => $empacado,
					':saldo_total' => $saldo_total
				));
				header('Location: menu.php');
		}else{
			echo "<script> alert('Debes llenar todos los datos!!!');</script>";
		}
	}


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Nueva Renta</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<?php $fecha= date('d-m-Y'); ?>
	<div class="contenedor">
		<h2>CRUD RENTAS EN PHP CON MYSQL</h2>
		<form action="" method="post">
		<div class="form-group">
				<label for="" class="label">Folio:<?php echo $numero; ?></label>
				<label for="" class="label" name="fecha" value ="<?php echo $fecha; ?>">Fecha:<?php echo $fecha; ?></label>
			</div>
			<div class="form-group">
				<label for="">___________________________________________</label>
				<label for="">___________________________________________</label>
			</div>
			<div class="form-group">
				<label for="" class="label">Nombre Cliente</label>
				<input type="text" name="nombre_cliente" placeholder="Nombre ciente" 
					autofocus class="input__text" requied>
			</div>
			<div class="form-group">
				<label for="" class="label">Descripción de Prenda</label>
				<input type="text" name="descripcion" placeholder="Descripción" class="input__text">
			</div>
			<div class="form-group">
				<label for="tipo" class="form-label">Incluye accesorios:</label>
							<div class="form-check">
								<input class="form-check-input" 
									type="radio" 
									name="accesorios" 
									value="100" 
								  checked>
									<label class="form-check-label" for="">
										Si ($100.00)
									</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" 
									type="radio" 
									name="accesorios" 
									value="0">
									<label class="form-check-label" for="">
										No ($0.0)
									</label>
							</div>
			</div>
			<div class="form-group">
				<label for="" class="label">Monto de renta</label>
				<input type="text" name="monto_renta" placeholder="Monto Renta" class="input__text">
			</div>
			<div class="form-group">
				<label for="" class="label">Anticipo</label>
				<input type="text" name="anticipo" placeholder="Anticipo" class="input__text">
			</div>
			<div class="form-group">
			<label for="" class="label">Fecha de entrega</label>
			<input type="date" name="entrega" placeholder="Fecha de entrega" class="input__text"
			value="<?php echo date("Y-m-d");?>">
			</div>
			<div class="form-group">
				<label for="" class="label">Estado de renta</label>
				<select name="estado_renta" class="input input__text">
					<option value="Apartado">Apartado</option>
					<option value="Entregado">Entregado</option>
					<option value="Devuelto">Devuelto</option>
				</select>
			</div>
			<div class="form-group">
			<label for="tipo" class="form-label">Servicios incluidos:</label>
							<div class="form-check">
								<input class="form-check-input" 
									type="checkbox" 
									name="lavado" 
									value="50" 
								  >
									<label class="form-check-label" for="">
										Lavado ($50.00)
									</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" 
									type="checkbox" 
									name="planchado" 
									value="30" 
								  >
									<label class="form-check-label" for="">
										Planchado ($30.00)
									</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" 
									type="checkbox" 
									name="empacado" 
									value="20" 
								  >
									<label class="form-check-label" for="">
										Empacado ($20.00)
									</label>
							</div>
			</div>
			<div class="form-group">
				<label for="">___________________________________________</label>
				<label for="">___________________________________________</label>
			</div>
			<div class="btn__group">
				<a href="menu.php" class="btn btn__danger">Cancelar</a>
				<input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
			</div>
		</form>
	</div>
</body>
</html>
