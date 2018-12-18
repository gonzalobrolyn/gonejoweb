
<?php
	require_once "../../clases/Personas.php";

	$objPersona = new personas();
	$datos = array(
    $_POST['dni'],
    $_POST['nombre'],
    $_POST['apellido'],
    $_POST['celular'],
    $_POST['ruc'],
    $_POST['razon'],
    $_POST['direccion'],
    $_POST['ciudad']);
	echo $objPersona->registroPersona($datos);
 ?>
