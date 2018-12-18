
<?php
  require_once "Gonexion.php";

  class personas{

    public function registroPersona($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sqlInsert = "INSERT into persona (
                                persona_dni,
                                persona_nombre,
                                persona_apellido,
                                persona_celular,
                                persona_ruc,
                                persona_razon,
                                persona_direccion,
                                persona_ciudad)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]',
                                '$datos[4]',
                                '$datos[5]',
                                '$datos[6]',
                                '$datos[7]')";
      return mysqli_query($conexion, $sqlInsert);
    }

    public function agregaPersona($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sqlInsert = "INSERT into persona (
                                persona_dni,
                                persona_nombre,
                                persona_apellido,
                                persona_celular)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]')";
      $result = mysqli_query($conexion, $sqlInsert);
      return mysqli_insert_id($conexion);
    }

    public function agregaEmpresa($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sqlInsert = "INSERT into persona (
                                persona_ruc,
                                persona_razon,
                                persona_direccion,
                                persona_celular)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]')";
      $result = mysqli_query($conexion, $sqlInsert);
      return mysqli_insert_id($conexion);
    }

    public function registroProveedor($datos){
      $c = new conectar();
      $conexion = $c->conexion();
      $sqlInsert = "INSERT into persona (
                                persona_celular,
                                persona_ruc,
                                persona_razon,
                                persona_direccion,
                                persona_ciudad)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]',
                                '$datos[4]')";
      return mysqli_query($conexion, $sqlInsert);
    }

    public function datosPersona($idPersona){
      $c = new conectar();
      $conexion = $c->conexion();
      $sql = "SELECT persona_nombre,
                     persona_apellido,
                     persona_celular,
                     persona_razon,
                     persona_direccion
                from persona
               where persona_id = '$idPersona'";
      $result = mysqli_query($conexion, $sql);
      $ver = mysqli_fetch_row($result);
      $data = array(
        'nombreP' => $ver[0],
        'apellidoP' => $ver[1],
        'celularP' => $ver[2],
        'razonP' => $ver[3],
        'direccionP' => $ver[4]
      );
      return $data;
    }


  }
?>
