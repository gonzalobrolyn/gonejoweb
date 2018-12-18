
<?php
	require_once "../../clases/Clientes.php";

	$objCliente = new clientes();
	$clave = sha1($_POST['clave']);
	$cargo = "Empresa";
	$fecha = date('Y-m-d H:i:s');
  $datos = array(
    $_POST['usuario'],
    $clave,
		$cargo,
		$fecha,
		$_POST['dni']
	);
	echo $objCliente->registroCliente($datos);
 ?>
