
<?php
	session_start();
	require_once "../../clases/Compras.php";

	$obj = new compras();

	if(count($_SESSION['listaCompraDep'])==0){
		echo 0;
	}else{
		$result = $obj->crearCompraConDep();
		unset($_SESSION['listaCompraDep']);
		echo $result;
	}
?>
