
<?php
   session_start();
   require_once "../../clases/Imagenes.php";
	require_once "../../clases/Productos.php";

   $objImagen = new imagenes();
	$objProducto = new productos();

   $usuarioID = $_SESSION['usuarioID'];
	$datosProducto = array();

   $archivo = $_FILES['imagen']['name'];
   $rutaAlma = $_FILES['imagen']['tmp_name'];
   $carpeta = '../../imgprod/';
   $rutaFinal = $carpeta.$archivo;

   $datosImagen = array(
   $rutaFinal,
   $usuarioID);

   if (move_uploaded_file($rutaAlma, $rutaFinal)) {
      $idImagen = $objImagen->guardaImagen($datosImagen);
      if ($idImagen > 0) {
         $datosProducto[0] = $idImagen;
         $datosProducto[1] = $_POST['grupoID'];
         $datosProducto[2] = $_POST['marca'];
         $datosProducto[3] = $_POST['modelo'];
         $datosProducto[4] = $_POST['descripcion'];
         $datosProducto[5] = $_POST['detalle'];
         $datosProducto[6] = $usuarioID;
  	      echo $objProducto->guardaProducto($datosProducto);
      } else {
         echo 0;
      }
   }
?>
