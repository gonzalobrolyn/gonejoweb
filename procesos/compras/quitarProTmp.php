
<?php

	session_start();
	$index=$_POST['ind'];
	unset($_SESSION['listaCompraTmp'][$index]);
	$datos=array_values($_SESSION['listaCompraTmp']);
	unset($_SESSION['listaCompraTmp']);
	$_SESSION['listaCompraTmp']=$datos;

?>
