
<?php
  session_start();
	require_once "../../clases/Familias.php";

	$obj = new familias();

  $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
    $_POST['nombre'],
    $usuarioID);
	echo $obj->guardaFamilia($datos);
 ?>
