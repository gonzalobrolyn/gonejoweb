
<?php
session_start();

	require_once "../../clases/Compras.php";

	$obj= new compras();
  $movimiento = "Deposito";
  $comprobante = "Boucher";
  $fechaLocal = time() - (7*60*60);
  $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
  $idUsuario = $_SESSION['usuarioID'];
  $idCaja = $_SESSION['cajaID'];

  $datos=array(
			$movimiento,
      $_POST['rucSelect'],
			$_POST['monto'],
			$comprobante,
			$_POST['numerocom'],
			$_POST['detalle'],
			$fechaAhora,
      $idUsuario,
			$idCaja);

	echo $obj->registraDeposito($datos);

?>
