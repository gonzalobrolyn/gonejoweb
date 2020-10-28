
<?php
	session_start();
	require_once "../../clases/Ventas.php";

	$obj = new ventas();

	if(count($_SESSION['listaVentaTmp'])==0){
		echo 0;
	}else{
      $listaVenta = $_SESSION['listaVentaTmp'];
      $total = 0;

      foreach (@$listaVenta as $key) {
         $d = explode("||", @$key);
         $total = $total + $d[5]*$d[6];
      }

		if ($_POST['clienteSelect'] > 0) {
         $docu = $_POST['clienteSelect'];
      } else {
         $docu = 1;
      }

		$datos = array(
			"Venta",
			$docu,
			$total
		);

		$result = $obj->crearVenta($datos) ;
		unset($_SESSION['listaVentaTmp']);
		echo $result;
	}
?>
