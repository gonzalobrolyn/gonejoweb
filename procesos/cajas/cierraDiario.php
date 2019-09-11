
<?php
   session_start();
	require_once "../../clases/Cajas.php";

	$obj = new cajas();

   $idPersona = $_SESSION['usuarioID'];
   $idCaja = $_SESSION['cajaID'];

   $datos = array(
      'Cuenta',
      $idPersona,
      $idCaja);

	echo $obj->cierraCajaDiario($datos);
 ?>
