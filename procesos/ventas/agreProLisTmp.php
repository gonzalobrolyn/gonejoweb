
<?php
  session_start();
  require_once "../../clases/Gonexion.php";

  $c = new conectar();
  $conexion = $c->conexion();
  $idCaja = $_SESSION['cajaID'];
  $idAlmacen = $_POST['idAlmacen'];
  $cantidad = $_POST['cantidad'];
  $precio = $_POST['precio'];

  $sql = "SELECT alm.almacen_producto,
                 gru.grupo_nombre,
                 mar.marca_nombre,
                 pro.producto_modelo,
                 pro.producto_descripcion
            from almacen as alm
      inner join producto as pro
              on alm.almacen_producto = pro.producto_id
      inner join grupo as gru
              on pro.producto_grupo = gru.grupo_id
      inner join marca as mar
              on pro.producto_marca = mar.marca_id
           where alm.almacen_id = '$idAlmacen'
             and alm.almacen_caja = '$idCaja'";
  $result = mysqli_query($conexion, $sql);
  $pro = mysqli_fetch_row($result);

  $item = $pro[0]."||".
          $pro[1]."||".
          $pro[2]."||".
          $pro[3]."||".
          $pro[4]."||".
          $cantidad."||".
          $precio;

  $_SESSION['listaVentaTmp'][] = $item;
?>
