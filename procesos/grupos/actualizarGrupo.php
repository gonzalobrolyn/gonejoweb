
<?php
   session_start();
	require_once "../../clases/Grupos.php";

	$obj = new grupos();

   $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
      $_POST['idgrupo'],
      $_POST['grupoU'],
      $usuarioID);
	echo $obj->actualizaGrupo($datos);
 ?>
