
<?php
  session_start();
	require_once "../../clases/Grupos.php";

	$obj = new grupos();

  $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
    $_POST['nombre'],
    $_POST['familia'],
    $usuarioID);
	echo $obj->guardaGrupo($datos);
 ?>
