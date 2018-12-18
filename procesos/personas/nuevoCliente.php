
<?php
	require_once "../../clases/Personas.php";

	$objPersona = new personas();
	$datos = array(
      $_POST['dni'],
      $_POST['nombre'],
      $_POST['apellido'],
      $_POST['celular']);
	echo $objPersona->agregaPersona($datos);
 ?>
