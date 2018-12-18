
<?php
   session_start();
	require_once "../../clases/Familias.php";

	$obj = new familias();

   $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
      $_POST['idfamilia'],
      $_POST['familiaU'],
      $usuarioID);
	echo $obj->actualizaFamilia($datos);
 ?>
