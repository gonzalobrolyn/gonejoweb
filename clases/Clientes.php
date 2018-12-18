
<?php
  require_once "Gonexion.php";

  class clientes{

    public function registroCliente($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sqlSelect = "SELECT persona_id
                      from persona
                     where persona_dni = '$datos[4]'";
      $result = mysqli_query($conexion, $sqlSelect);
      $personaID = mysqli_fetch_row($result)[0];
      $sqlInsert = "INSERT into usuario (
                                usuario_nombre,
                                usuario_clave,
                                usuario_cargo,
                                usuario_fecha,
                                usuario_persona)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]',
                                '$personaID')";
      return mysqli_query($conexion, $sqlInsert);
    }

  }
?>
