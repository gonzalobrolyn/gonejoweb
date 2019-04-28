
<?php
  require_once "Gonexion.php";
  class cajas{

    public function creaCodigo($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "INSERT into caja(
                          caja_codigo,
                          caja_llave,
                          caja_usuario)
                  values ('$datos[0]',
                          '$datos[1]',
                          '$datos[2]')";
      return mysqli_query($conexion, $sql);
    }

    public function validaCodigo($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT caja_id
                from caja
               where caja_codigo = '$datos[0]'
                 and caja_llave = '$datos[1]'
                 and caja_usuario = '1'";
      $result = mysqli_query($conexion, $sql);
      return mysqli_fetch_row($result)[0];
    }

    public function agregaCaja($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);
      $llave = sha1($datos[4]);
      $sql = "UPDATE caja
                 set caja_sede = '$datos[0]',
                     caja_direccion = '$datos[1]',
                     caja_telefono = '$datos[2]',
                     caja_logo = '$datos[3]',
                     caja_llave = '$llave',
                     caja_efectivo = '$datos[5]',
                     caja_fecha = '$fechaAhora',
                     caja_usuario = '$datos[6]'
               where caja_id = '$datos[7]'";
      return mysqli_query($conexion, $sql);
    }

    public function cierraCajaDiario($idCaja){
      $c = new conectar();
      $conexion = $c->conexion();
      $sqlMovi = "UPDATE movimiento
                     set movimiento_estado = '1'
                   where movimiento_estado = '0'
                     and movimiento_caja = '$idCaja'";
      return mysqli_query($conexion, $sqlMovi);
   }

  }
?>
