
<?php
  require_once "Gonexion.php";

  class marcas{

    public function guardaMarca($datos){
      $c = new conectar();
      $conexion = $c->conexion();

      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

      $sqlPersona = "SELECT usuario_persona
                       from usuario
                      where usuario_id = '$datos[1]'";
      $consulta = mysqli_query($conexion, $sqlPersona);
      $resultadoPersona = mysqli_fetch_row($consulta)[0];

      $sql = "INSERT into marca (
                          marca_nombre,
                          marca_fecha,
                          marca_persona)
                  values ('$datos[0]',
                          '$fechaAhora',
                          '$resultadoPersona')";
      return mysqli_query($conexion, $sql);

    }

    public function actualizaMarca($datos){
      $c = new conectar();
      $conexion = $c->conexion();

      $fechaLocal = time() - (7*60*60);
      $fechaAhora = date("Y-m-d H:i:s", $fechaLocal);

       $sqlPersona = "SELECT usuario_persona
                        from usuario
                       where usuario_id = '$datos[2]'";
       $consulta = mysqli_query($conexion, $sqlPersona);
       $resultadoPersona = mysqli_fetch_row($consulta)[0];

      $sql = "UPDATE marca
                 set marca_nombre = '$datos[1]',
                     marca_fecha = '$fechaAhora',
                     marca_persona = '$resultadoPersona'
               where marca_id = '$datos[0]'";
      echo mysqli_query($conexion,$sql);
    }
  }
?>
