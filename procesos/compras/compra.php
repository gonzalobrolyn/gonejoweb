
<?php
	session_start();
	require_once "../../clases/Compras.php";

	$obj = new compras();

	if(count($_SESSION['listaCompraTmp'])==0){
		echo 0;
	}else{
    $listaCompra = $_SESSION['listaCompraTmp'];
		$comprobante = $_POST['comprobante'];
		$numero = $_POST['numero'];
    $total = 0;
		
		if ($_POST['proveedorSelect'] > 0) {
			 $docu = $_POST['proveedorSelect'];
		} else {
			 $docu = 1;
		}

    foreach (@$listaCompra as $key) {
       $d = explode("||", @$key);
       $total = $total + $d[8]*$d[9];
    }

		if ($numero == ""){
			$numero = 000;
		}

		$datos = array(
			"Compra",
			$docu,
			$total,
			$comprobante,
			$numero
		);

		$result = $obj->crearCompra($datos);
		unset($_SESSION['listaCompraTmp']);
		echo $result;
	}
?>
