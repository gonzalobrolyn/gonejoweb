
<?php

	require_once "../../clases/Personas.php";

	$obj= new personas();

	echo json_encode($obj->datosPersona($_POST['idPersona']))

 ?>
