
<?php
	require_once "../../clases/Clientes.php";

	$objCliente = new clientes();
	$clave = sha1($_POST['clave']);
	$cargo = "Empresa";
	$fechaLocal = time() - (7*60*60);
	$fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
   $datos = array(
      $_POST['usuario'],
      $clave,
		$cargo,
		$fechaAhora,
		$_POST['dni']
	);
	echo $objCliente->registroCliente($datos);
?>
