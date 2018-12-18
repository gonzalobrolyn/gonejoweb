
<?php
	require_once "../../clases/Personas.php";

	$objPersona = new personas();
	$datos = array(
    $_POST['celular'],
    $_POST['ruc'],
    $_POST['razon'],
    $_POST['direccion'],
    $_POST['ciudad']);
	echo $objPersona->registroProveedor($datos);
 ?>
