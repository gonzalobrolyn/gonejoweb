
<?php
  session_start();
	require_once "../../clases/Cajas.php";

	$obj = new cajas();

   $usuarioID = $_SESSION['usuarioID'];
   $cajaID = $_SESSION['cajaID'];

	$datos = array(
      'Ingreso',
      $_POST['ingresoCap'],
      $usuarioID,
      $cajaID,
      $_POST['conceptoIn']);
	echo $obj->ingresaCapital($datos);
?>
