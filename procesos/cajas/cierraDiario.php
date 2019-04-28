
<?php
   session_start();
	require_once "../../clases/Cajas.php";

	$obj = new cajas();

   $idCaja = $_SESSION['cajaID'];

	echo $obj->cierraCajaDiario($idCaja);
 ?>
