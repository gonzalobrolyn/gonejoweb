
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

      foreach (@$listaCompra as $key) {
         $d = explode("||", @$key);
         $total = $total + $d[8]*$d[9];
      }

      if ($_POST['dniSelect'] > 0) {
         $docu = $_POST['dniSelect'];
      } else if ($_POST['rucSelect'] > 0) {
			$docu = $_POST['rucSelect'];
      } else {
         $docu = 1;
      }

		$datos = array(
			"Compra",
			$docu,
			$total,
			$comprobante,
			$numero
		);

		$result = $obj->crearCompra($datos) ;
		unset($_SESSION['listaCompraTmp']);
		echo $result;
	}
?>
