
<?php
  session_start();
  require_once "../../clases/Gonexion.php";

  $c = new conectar();
  $conexion = $c->conexion();

  $idProducto = $_POST['productoSelect'];

  $familia = $_POST['familiaC'];
  $grupo = $_POST['grupoC'];
  $marca = $_POST['marcaC'];
  $descripcion = $_POST['descripcionC'];
  $detalle = $_POST['detalleC'];
  $cantidad = $_POST['cantidad'];
  $preciollegada = $_POST['preciollegada'];
  $preciotraspaso = $_POST['preciotraspaso'];
  $precioventa = $_POST['precioventa'];

  $sql = "SELECT producto_codigo,
                 producto_modelo
            from producto
           where producto_id = '$idProducto'";
  $query = mysqli_query($conexion, $sql);
  $result = mysqli_fetch_row($query);

  $item = $idProducto."||".
          $result[0]."||".
          $familia."||".
          $grupo."||".
          $marca."||".
          $result[1]."||".
          $descripcion."||".
          $detalle."||".
          $cantidad."||".          
          $preciollegada."||".
          $preciotraspaso."||".
          $precioventa;

  $_SESSION['listaCompraTmp'][] = $item;
?>
