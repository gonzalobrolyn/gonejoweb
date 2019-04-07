
<?php
   session_start();
	require_once "../../clases/Productos.php";

	$obj = new productos();

   $usuarioID = $_SESSION['usuarioID'];

	$datos = array(
      $_POST['idProductoU'],
      $_POST['modeloU'],
      $_POST['descripcionU'],
      $_POST['detalleU'],
      $usuarioID);
	echo $obj->actualizaProducto($datos);
 ?>
