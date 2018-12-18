
<?php
   session_start();

   require_once "../../clases/Ventas.php";

   $obj= new ventas();
   $movimiento = "Adelanto";
   $comprobante = "Recibo";
   $fecha = date('Y-m-d H:i:s');
   $idUsuario = $_SESSION['usuarioID'];
   $idCaja = $_SESSION['cajaID'];

   $datos=array(
      $movimiento,
      $_POST['dniSelect'],
      $_POST['monto'],
      $comprobante,
      $_POST['detalle'],
      $fecha,
      $idUsuario,
      $idCaja);

   echo $obj->registraAdelanto($datos);
?>
