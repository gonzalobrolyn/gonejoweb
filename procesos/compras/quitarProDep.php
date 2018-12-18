
<?php

	session_start();
	$index=$_POST['ind'];
	unset($_SESSION['listaCompraDep'][$index]);
	$datos=array_values($_SESSION['listaCompraDep']);
	unset($_SESSION['listaCompraDep']);
	$_SESSION['listaCompraDep']=$datos;

?>
