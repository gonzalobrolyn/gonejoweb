
<?php
session_start();

	require_once "../../clases/Compras.php";

	$obj= new compras();
  $movimiento = "Deposito";
  $comprobante = "Boucher";
	$fecha = date('Y-m-d H:i:s');
  $idUsuario = $_SESSION['usuarioID'];
  $idCaja = $_SESSION['cajaID'];

  $datos=array(
			$movimiento,
      $_POST['rucSelect'],
			$_POST['monto'],
			$comprobante,
			$_POST['numerocom'],
			$_POST['detalle'],
			$fecha,
      $idUsuario,
			$idCaja);

	echo $obj->registraDeposito($datos);

?>
