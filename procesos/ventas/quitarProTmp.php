
<?php

	session_start();
	$index=$_POST['ind'];
	unset($_SESSION['listaVentaTmp'][$index]);
	$datos=array_values($_SESSION['listaVentaTmp']);
	unset($_SESSION['listaVentaTmp']);
	$_SESSION['listaVentaTmp']=$datos;

?>
