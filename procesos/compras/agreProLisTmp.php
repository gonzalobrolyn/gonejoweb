
<?php
  session_start();
  require_once "../../clases/Gonexion.php";

  $c = new conectar();
  $conexion = $c->conexion();

  if ($_POST['codigoPro'] > 0) {
     $idProducto = $_POST['codigoPro'];
  } elseif ($_POST['modeloPro'] > 0) {
     $idProducto = $_POST['modeloPro'];
  }

  $familia = $_POST['familiaC'];
  $grupo = $_POST['grupoC'];
  $marca = $_POST['marcaC'];
  $descripcion = $_POST['descripcionC'];
  $detalle = $_POST['detalleC'];
  $cantidad = $_POST['cantidad'];
  $preciofactura = $_POST['preciofactura'];
  $precioempresa = $_POST['precioempresa'];
  $preciotraspaso = $_POST['preciotraspaso'];
  $preciorebaja = $_POST['preciorebaja'];
  $precioventa = $_POST['precioventa'];

  $sql = "SELECT producto_modelo,
                 producto_codigo
            from producto
           where producto_id = '$idProducto'";
  $query = mysqli_query($conexion, $sql);
  $result = mysqli_fetch_row($query);

  $item = $idProducto."||".
          $familia."||".
          $grupo."||".
          $marca."||".
          $result[0]."||".
          $result[1]."||".
          $descripcion."||".
          $detalle."||".
          $cantidad."||".
          $preciofactura."||".
          $precioempresa."||".
          $preciotraspaso."||".
          $preciorebaja."||".
          $precioventa;

  $_SESSION['listaCompraTmp'][] = $item;
?>
