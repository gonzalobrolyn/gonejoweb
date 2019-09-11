
<?php
  session_start();
	require_once "../../clases/Cajas.php";

	$obj = new cajas();

   $usuarioID = $_SESSION['usuarioID'];
   $cajaID = $_SESSION['cajaID'];

	$datos = array(
      'Egreso',
      $_POST['egresoCap'],
      $usuarioID,
      $cajaID,
      $_POST['conceptoEg']);
	echo $obj->egresaCapital($datos);
?>
