
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
      $fecha = date('Y-m-d H:i:s');
      $llave = sha1($datos[5]);
      $sql = "UPDATE caja
                 set caja_sede = '$datos[0]',
                     caja_direccion = '$datos[1]',
                     caja_ciudad = '$datos[2]',
                     caja_telefono = '$datos[3]',
                     caja_logo = '$datos[4]',
                     caja_llave = '$llave',
                     caja_efectivo = '$datos[6]',
                     caja_fecha = '$fecha',
                     caja_usuario = '$datos[7]'
               where caja_id = '$datos[8]'";
      return mysqli_query($conexion, $sql);
    }

  }
?>
