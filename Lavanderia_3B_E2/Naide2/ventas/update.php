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
		//print "Valor del folio: ".$folio;
		$buscar_folio=$db->connect()->prepare('SELECT * FROM rentas WHERE folio=:folio LIMIT 1');
		$buscar_folio->execute(array(':folio'=>$folio));
		$resultado=$buscar_folio->fetch();
		$conAccesorios = $resultado['accesorios'] == '100' ? 'checked' : '';
		$sinAccesorios = $resultado['accesorios'] == '0' ? 'checked' : '';
		$conLavado = $resultado['lavado'] == '50' ? 'checked' : '';
		$conPlanchado = $resultado['planchado'] == '30' ? 'checked' : '';
		$conEmpacado = $resultado['empacado'] == '20' ? 'checked' : '';
		//echo "valor de accesorios: ".$resultado['accesorios']."<br/>";
		//echo "valor de conAccesorios: ".$conAccesorios."<br/>";
		//echo "valor de sinAccesorios: ".$sinAccesorios."<br/>";
	}else{
		header('Location: menu.php');
	}

	if(isset($_POST['guardar'])){
		$nombre_cliente=$_POST['nombre_cliente'];
		$descripcion=$_POST['descripcion'];
		$monto_renta=$_POST['monto_renta'];
		$anticipo=$_POST['anticipo'];
		$estado_renta=$_POST['estado_renta'];
		$fecha_apartado=$_POST['fecha_apartado'];
		$accesorios = $_POST['accesorios'];
		$lavado=isset($_REQUEST['lavado']) ? $_REQUEST['lavado'] : 0;
		$planchado=isset($_REQUEST['planchado']) ? $_REQUEST['planchado'] : 0;
		$empacado=isset($_REQUEST['empacado']) ? $_REQUEST['empacado'] : 0;
		$pago=isset($_REQUEST['pago']) ? $_REQUEST['pago'] : 0;
		$pago_total=((int)$anticipo+(int)$pago);
		$saldo_total = (int)$monto_renta+(int)$accesorios+(int)$lavado+(int)$planchado+(int)$empacado;
		$saldo_pendiente=(int)$saldo_total-((int)$anticipo+(int)$pago);
		$entrega = $_POST['entrega'];

		$folio=(int) $_GET['folio'];
		if(!empty($fecha_apartado) && 
				!empty($nombre_cliente) && !empty($descripcion) && 
				!empty($monto_renta) && !empty($estado_renta) ){
				$consulta_update=$db->connect()->prepare(' UPDATE rentas SET  
					fecha_apartado=:fecha_apartado,
					nombre_cliente=:nombre_cliente,
					descripcion=:descripcion,
					monto_renta=:monto_renta,
					accesorios=:accesorios,
					lavado = :lavado,
					planchado = :planchado,
					empacado = :empacado,
					saldo_total = :saldo_total,
					anticipo = :anticipo,
					estado_renta=:estado_renta,
					pago = :pago,
					pago_total = :pago_total,
					saldo_pendiente = :saldo_pendiente
					WHERE folio=:folio;'
				);
				$consulta_update->execute(array(
					':fecha_apartado' =>$fecha_apartado,
					':nombre_cliente' =>$nombre_cliente,
					':descripcion' =>$descripcion,
					':monto_renta' =>$monto_renta,
					':accesorios' =>$accesorios,
					':lavado' =>$lavado,
					'planchado' =>$planchado,
					'empacado'=>$empacado,
					'saldo_total'=>$saldo_total,
					':anticipo' =>$anticipo,
					':estado_renta' =>$estado_renta,
					':pago' =>$pago,
					':pago_total' =>$pago_total,
					':saldo_pendiente' =>$saldo_pendiente,
					':folio' =>$folio
				));
				header('Location: menu.php');
			}else{
				echo "<script> alert('Los campos estan vacios');</script>";
			}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editar Renta</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>CRUD EN PHP CON MYSQL</h2>
		<form action="" method="post">
			<div class="form-group">
				<label for="" class="label">Folio:</label>
				<input type="text" name="nombre_cliente" value="<?php if($resultado) echo $resultado['folio']; ?>" 
					class="input__text" readonly>
				<label for="" class="label">Saldo pendiente:</label>
				<input type="text" name="saldo_pendiente" value="<?php if($resultado) echo $resultado['saldo_pendiente']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<label for="">----------------------------------------------------------</label>
				<label for="">----------------------------------------------------------</label>
			</div>	
			<div class="form-group">
				<label for="" class="label">Nombre Cliente:</label>
				<input type="text" name="nombre_cliente" value="<?php if($resultado) echo $resultado['nombre_cliente']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<label for="" class="label">Fecha de apartado:</label>
				<input type="text" name="fecha_apartado" value="<?php if($resultado) echo $resultado['fecha_apartado']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<label for="" class="label">Prenda(s):</label>
				<input type="text" name="descripcion" value="<?php if($resultado) echo $resultado['descripcion']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<label for="" class="label">Estado de la renta:</label>
				<select class="input__text" aria-label="Default select example" name="estado_renta" id="estado_renta">
										<option value="<?php if($resultado) echo $resultado['estado_renta']; ?>"><?php if($resultado) echo $resultado['estado_renta']; ?></option>
										 <option value="apartado">Apartado</option>
										 <option value="entregado">Entregado</option>
										 <option value="devuelto">Devuelto</option>
									</select>
			</div>
			<div class="form-group">
				<label for="" class="label">Monto de renta:</label>
				<input type="text" name="monto_renta" value="<?php if($resultado) echo $resultado['monto_renta']; ?>" class="input__text">
			</div>
			<!-- 
			<div class="form-group">
				<label for="" class="label">Accesorios:</label>
				<input type="text" name="accesorios" value="<?php if($resultado) echo $resultado['accesorios']; ?>" class="input__text">
			</div>
			-->
			<div class="form-group">
				<label for="" class="label">----------------------------------------------------------</label>
				<label for="" class="label">----------------------------------------------------------</label>
			</div>
			<div class="form-group">
			<label for="" class="label">Accesorios:</label>
				<input type="radio" class="form-check-input" name="accesorios" id="accesorios" 
						value ="100" <?php echo $conAccesorios; ?> />
				<label class="form-check-label" for="">Si ($100.00)</label>
				<input type="radio" class="form-check-input" name="accesorios" id="accesorios" 
						value ="0"  <?php echo $sinAccesorios; ?> />
				<label class="form-check-label" for="">No ($0.00)</label>
			</div>
			<div class="form-group">
				<label for="" class="label">----------------------------------------------------------</label>
				<label for="" class="label">----------------------------------------------------------</label>
			</div>
			<div class="form-group">
				<label for="" class="label">----------------------------------------------------------</label>
				<label for="" class="label">----------------------------------------------------------</label>
			</div>
			<div class="form-group">
			<label for="" class="label">Servicios:</label>
				<input type="checkbox" class="form-check-input" name="lavado" id="lavado" 
						value ="50" <?php echo $conLavado; ?> />
				<label class="form-check-label" for="">Lavado ($50.00)</label>
				<input type="checkbox" class="form-check-input" name="planchado" id="planchado" 
						value ="30" <?php echo $conPlanchado; ?> />
				<label class="form-check-label" for="">Planchado ($30.00)</label>
				<input type="checkbox" class="form-check-input" name="empacado" id="empacado" 
						value ="20" <?php echo $conEmpacado; ?> />
				<label class="form-check-label" for="">Empacado ($20.00)</label>
			</div>
			<div class="form-group">
				<label for="" class="label">----------------------------------------------------------</label>
				<label for="" class="label">----------------------------------------------------------</label>
			</div>
			<div class="form-group">
				<label for="" class="label">Anticipo:</label>
				<input type="text" name="anticipo" value="<?php if($resultado) echo $resultado['anticipo']; ?>" class="input__text" readonly>
			</div>
			<div class="form-group">
				<label for="" class="label">Pago:</label>
				<input type="text" name="pago" value="<?php if($resultado) echo $resultado['pago']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<label for="" class="label">Pago total:</label>
				<input type="text" name="pago_total" value="<?php if($resultado) echo $resultado['pago_total']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<label for="" class="label">Saldo Total:</label>
				<input type="text" name="saldo_total" value="<?php if($resultado) echo $resultado['saldo_total']; ?>" class="input__text">
			</div>
			<div class="btn__group">
				<a href="menu.php" class="btn btn__danger">Cancelar</a>
				<input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
			</div>
		</form>
	</div>
</body>
</html>