
<?php
	session_start();
	require_once "../clases/Acceso.php";

	$obj = new acceso();
	$clave = sha1($_POST['clave']);
	$llave = sha1($_POST['llave']);
	$datos = array(
		$_POST['usuario'],
		$clave,
		$llave);
	echo $obj->entrarUsuario($datos);
?>
