
<?php
	require_once "../../clases/Personas.php";

	$objPersona = new personas();
	$datos = array(
      $_POST['ruc'],
      $_POST['razon'],
      $_POST['direccion'],
      $_POST['celular']);
	echo $objPersona->agregaEmpresa($datos);
 ?>
