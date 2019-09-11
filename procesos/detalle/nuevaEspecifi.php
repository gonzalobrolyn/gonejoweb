
<?php
   session_start();
	require_once "../../clases/Especifi.php";

	$obj = new especifi();

   $idCaja = $_SESSION['cajaID'];

	$datos = array(
      $_POST['atributo'],
      $_POST['especificacion'],
      $_POST['producto'],
      $idCaja);
	echo $obj->guardaEspecifi($datos);
?>
