
<?php
  require_once "Gonexion.php";

  class usuarios{

    public function agregaUsuario($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $clave = sha1($datos[1]);
      $sql = "INSERT into usuario (
                          usuario_nombre,
                          usuario_clave,
                          usuario_caja,
                          usuario_cargo,
                          usuario_sueldo,
                          usuario_diapago,
                          usuario_fecha,
                          usuario_persona)
                  values ('$datos[0]',
                          '$clave',
                          '$datos[2]',
                          '$datos[3]',
                          '$datos[4]',
                          '$datos[5]',
                          '$datos[6]',
                          '$datos[7]')";
      return mysqli_query($conexion, $sql);
    }
  }
?>
