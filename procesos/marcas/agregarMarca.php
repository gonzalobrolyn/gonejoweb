
<?php
  session_start();
	require_once "../../clases/Marcas.php";

	$obj = new marcas();

  $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
    $_POST['nombre'],
    $usuarioID);
	echo $obj->guardaMarca($datos);
 ?>
