
<?php
   session_start();

   require_once "../../clases/Ventas.php";

   $obj= new ventas();
   $movimiento = "Adelanto";
   $comprobante = "Recibo";
   $fechaLocal = time() - (7*60*60);
   $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
   $idUsuario = $_SESSION['usuarioID'];
   $idCaja = $_SESSION['cajaID'];

   $datos=array(
      $movimiento,
      $_POST['dniSelect'],
      $_POST['monto'],
      $comprobante,
      $_POST['detalle'],
      $fechaAhora,
      $idUsuario,
      $idCaja);

   echo $obj->registraAdelanto($datos);
?>
