
<?php
	session_start();
	require_once "../clases/Cajas.php";

   $obj = new cajas();

	$llaveCaja = sha1($_POST['llaveCaja']);
   $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
		$_POST['codigoUnico'],
		$llaveCaja,
		$usuarioID);

	echo $obj->creaCodigo($datos);
 ?>
