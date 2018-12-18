
<?php
  session_start();
  require_once "../../clases/Gonexion.php";

  $c = new conectar();
  $conexion =$c->conexion();

  $idProducto = $_POST['productoCompra'];
  $grupo = $_POST['grupoC'];
  $marca = $_POST['marcaC'];
  $detalle = $_POST['detalleC'];
  $cantidad = $_POST['cantidadC'];
  $precio = $_POST['precioC'];

  $sql = "SELECT producto_modelo
            from producto
           where producto_id = '$idProducto'";
  $result = mysqli_query($conexion, $sql);
  $modelo = mysqli_fetch_row($result)[0];

  $item = $idProducto."||".
          $grupo."||".
          $marca."||".
          $modelo."||".
          $detalle."||".
          $cantidad."||".
          $precio;

  $_SESSION['listaCompraDep'][] = $item;
?>
